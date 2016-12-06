<?php

namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository
{

    /**
    * All of the registered after callbacks.
    *
    * @var product
    */
    protected $model;
    
    /**
    * Create a new  instance.
    *
    * @param product $product
    *
    * @return void
    */
    public function __construct(Product $product)
    {
        $this->model=$product;
    }
}
