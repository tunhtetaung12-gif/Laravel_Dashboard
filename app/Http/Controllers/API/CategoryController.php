<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class CategoryController extends BaseController
{
    public function index()
    {
        $categories = Category::get();

        $result = CategoryResource::collection($categories);
        return $this->success($result, "Categories Retireved Successfully", 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        $result = new CategoryResource($category);

        return $this->success($result, "Category Show Successful", 200);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error("Validation Error", $validation->errors(), 422);
        }

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(public_path('categoryImages'), $imageName);
        }

        $category = Category::create([
            'name' => $request->name,
            'image' => $imageName,
        ]);


        return $this->success($category, "Category created successfully", 201);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->error("Category not found", [], 404);
        }

        $validation = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if ($validation->fails()) {
            return $this->error("Validation Error", $validation->errors(), 422);
        }

        // Update name
        $category->name = $request->name;

        // Update image if provided
        if ($request->hasFile('image')) {

            // Delete old image
            if ($category->image && file_exists(public_path('categoryImages/' . $category->image))) {
                unlink(public_path('categoryImages/' . $category->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('categoryImages'), $imageName);

            $category->image = $imageName;
        }

        $category->save();

        return $this->success(
            new CategoryResource($category),
            "Category updated successfully",
            200
        );
    }

    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->error("Category not found", [], 404);
        }

        // Delete image file
        if ($category->image && file_exists(public_path('categoryImages/' . $category->image))) {
            unlink(public_path('categoryImages/' . $category->image));
        }

        $category->delete();

        return $this->success([], "Category deleted successfully", 200);
    }
}
