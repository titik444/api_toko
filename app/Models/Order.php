<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    // use HasFactory;
    use SoftDeletes;

    // declare table name
    public $table = 'order';

    // declare fillable fields
    protected $fillable = [
        'status',
        'user_id',
    ];

    // one to many
    public function order_product()
    {
        return $this->hasMany('App\Models\OrderProduct', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
