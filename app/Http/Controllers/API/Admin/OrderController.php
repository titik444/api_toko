<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\BaseController as BaseController;

// use library here

// request

// use everything here
use Auth;

// use model here
use App\Models\Order;


class OrderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::withSum('order_product', 'total')
            ->withSum('order_product', 'price')
            ->with('user');

        if (!Auth::user()->isAdmin()) {
            $orders = $orders->where('user_id', Auth::user()->id);
        }

        $orders = $orders->groupBy('id')
            ->get();

        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }
}
