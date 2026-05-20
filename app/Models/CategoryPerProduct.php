<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CategoryPerProduct
 * @package App\Models
 * @author Richard Guevara
 */
class CategoryPerProduct extends Model
{
    use SoftDeletes;

    protected $table = 'category_per_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_category_id',
    ];
}