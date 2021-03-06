<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promotions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'image',
        'percent',
        'quantity',
        'date_start',
        'date_end',
        'product_id'
    ];

    /**
     * Get parent that own promotion
     *
     * @return Product
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
