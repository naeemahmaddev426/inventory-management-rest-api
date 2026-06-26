<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{

    public function index()
    {
        return CategoryResource::collection(Category::latest()->paginate(10));
    }

    public function store(StoreCategoryRequest $request)
    {

        $category = Category::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

            'description' => $request->description,

            'status' => $request->status

        ]);

        return new CategoryResource($category);

    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $category->update([

            'name'=>$request->name,

            'slug'=>Str::slug($request->name),

            'description'=>$request->description,

            'status'=>$request->status

        ]);

        return new CategoryResource($category);

    }

    public function destroy(Category $category)
    {

        $category->delete();

        return response()->json([

            'message'=>'Category Deleted Successfully'

        ]);

    }

}