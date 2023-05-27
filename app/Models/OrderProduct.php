<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'order_product';

    // declare fillable fields
    protected $fillable = [
        'total',
        'price',
        'order_id',
        'product_id',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
}
