<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::with('category')->get();

        return $this->success(
            ProductResource::collection($products),
            "Products retrieved successfully",
            200
        );
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);

        if (!$product) {
            return $this->error("Product not found", [], 404);
        }

        return $this->success(
            new ProductResource($product),
            "Product retrieved successfully",
            200
        );
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer',
            'image'       => 'required|image|mimes:jpg,jpeg,png',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'nullable|boolean',
        ]);

        if ($validation->fails()) {
            return $this->error("Validation Error", $validation->errors(), 422);
        }

        // Upload image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('productImages'), $imageName);

        $product = Product::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'image'       => $imageName,
            'category_id' => $request->category_id,
            'status'      => $request->has('status') ? true : false,
        ]);

        return $this->success(
            new ProductResource($product),
            "Product created successfully",
            201
        );
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->error("Product not found", [], 404);
        }

        $validation = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|integer',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error("Validation Error", $validation->errors(), 422);
        }

        // Update image if exists
        if ($request->hasFile('image')) {

            if ($product->image && file_exists(public_path('productImages/' . $product->image))) {
                unlink(public_path('productImages/' . $product->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('productImages'), $imageName);

            $product->image = $imageName;
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id' => $request->category_id,
            'status'      => $request->has('status') ? true : false,
        ]);

        return $this->success(
            new ProductResource($product),
            "Product updated successfully",
            200
        );
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->error("Product not found", [], 404);
        }

        // Delete image
        if ($product->image && file_exists(public_path('productImages/' . $product->image))) {
            unlink(public_path('productImages/' . $product->image));
        }

        $product->delete();

        return $this->success([], "Product deleted successfully", 200);
    }
}
