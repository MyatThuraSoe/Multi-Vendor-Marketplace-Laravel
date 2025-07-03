<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\CategoryResource($category),
            'Category created successfully.',
            201
        );
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new \App\Http\Resources\ApiResponseResource(
            new \App\Http\Resources\CategoryResource($category),
            'Category updated successfully.',
            200
        );
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return new \App\Http\Resources\ApiResponseResource(null, 'Category deleted successfully.', 200);
    }
}
