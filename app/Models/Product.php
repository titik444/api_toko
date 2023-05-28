<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    // use HasFactory;
    use SoftDeletes;
    use HasSlug;


    // declare table name
    public $table = 'product';

    // declare fillable fields
    protected $fillable = [
        'name',
        'slug',
        'description',
        'photo',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    // slug
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
