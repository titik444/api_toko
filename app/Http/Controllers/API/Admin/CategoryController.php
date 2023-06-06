<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController as BaseController;

// use library here

// request
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

// use everything here
use Symfony\Component\HttpFoundation\Request;

// use model here
use App\Models\Category;


class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::query();

        // Search
        if ($request->q) {
            $categories->where(function ($query) use ($request) {
                $query->where('name', 'LIKE', "%{$request->q}%")
                    ->orWhere('description', 'LIKE', "%{$request->q}%");
            });
        }

        // Sorting
        $sortField = $request->sf ?? 'id';
        $sortOrder = $request->so === 'desc' ? 'desc' : 'asc';
        $categories->orderBy($sortField, $sortOrder);

        // Limit
        $limit = $request->limit ?? 10;
        $categories = $categories->paginate($limit);

        return $this->sendResponse($categories, 'Categories retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $input = $request->all();

        $category = Category::create($input);

        return $this->sendResponse($category, 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return $this->sendError('Category not found.');
        }

        return $this->sendResponse($category, 'Category retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $input = $request->all();

        $category = Category::find($id);

        $category->update($input);

        return $this->sendResponse($category, 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        return $this->sendResponse([], 'Category deleted successfully.');
    }
}
