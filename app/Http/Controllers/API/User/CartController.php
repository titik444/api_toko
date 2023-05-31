<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

use Auth;
use Validator;


class CartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::with('product')->get();

        return $this->sendResponse($carts, 'Carts retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'total' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 403);
        }

        // update to database
        $cart->update($input);

        return $this->sendResponse($cart, 'Cart updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return $this->sendResponse([], 'Cart deleted successfully.');
    }

    public function addCart(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 403);
        }

        $cart = Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $input['product_id'])
            ->first();

        $input['total'] = ($input['total']) ?? 1;

        if (!$cart) {

            $input['user_id'] = Auth::user()->id;

            $cart = Cart::create($input);
        } else {

            $cart->increment('total', $input['total']);
        }

        return $this->sendResponse($cart, 'Cart updated successfully.');
    }

    public function payNow(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'cart_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 403);
        }

        // create order
        $order = Order::create(['user_id' => Auth::user()->id, 'status' => 'success']);

        foreach ($input['cart_id'] as $cartId) {

            // get data from cart
            $cart = Cart::where('id', $cartId)->first();

            // get price from product
            $price = Product::where('id', $cart->product_id)->pluck('price')->first();

            // create order_product
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'total' => $cart->total,
                'price' => $price,
            ]);

            // delete cart
            $cart->delete();
        }

        $order = Order::with('order_product')->where('id', $order->id)->first();

        return $this->sendResponse($order, 'Order created successfully.');
    }
}
