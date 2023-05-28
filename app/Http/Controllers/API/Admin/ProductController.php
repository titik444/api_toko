<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Product;

use Storage;
use Validator;
use File;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 403);
        }

        // upload process here
        if (isset($input['photo'])) {

            $path = 'images/' . now()->format('Y/m/d');

            if (!Storage::has('public/' . $path)) {
                Storage::makeDirectory('public/' . $path);
            }

            // store file
            $input['photo'] = $input['photo']->store($path, 'public');
        }

        $product = Product::create($input);

        return $this->sendResponse($product, 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 403);
        }

        // update to database
        $product = Product::find($id);

        // upload process here
        if (isset($input['photo'])) {

            $path = 'images/' . now()->format('Y/m/d');

            if (!Storage::has('public/' . $path)) {
                Storage::makeDirectory('public/' . $path);
            }

            // store file
            $input['photo'] = $input['photo']->store($path, 'public');

            // first checking old photo to delete from storage
            $get_item = $product->photo;

            // delete old photo from storage
            $input_old = 'storage/' . $get_item;

            if (File::exists($input_old)) {
                File::delete($input_old);
            } else {
                File::delete('storage/app/public/' . $get_item);
            }
        }

        $product->update($input);

        return $this->sendResponse($product, 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
