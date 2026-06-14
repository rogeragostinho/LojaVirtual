<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $database = 'product_images';

    protected $fillable = [
        'product_id',
        'url'
    ];
}
