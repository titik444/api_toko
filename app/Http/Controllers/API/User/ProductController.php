<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController as BaseController;

// use library here

// request

// use everything here
use Illuminate\Http\Request;

// use model here
use App\Models\Product;


class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = new Product;

        if ($request->category_id) {
            $products = $products->where('category_id', $request->category_id);
        }

        $products = $products->get();

        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    public function featured()
    {
        $products = Product::orderBy('is_featured', 'DESC')->orderBy('updated_at', 'DESC')->limit(5)->get();

        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
