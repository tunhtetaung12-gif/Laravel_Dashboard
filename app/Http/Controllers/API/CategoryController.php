<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
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

        $result=new CategoryResource($category);

        return $this->success($result,"Category Show Successful",200);
    }
}
