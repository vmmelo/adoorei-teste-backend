<?php

namespace App\Services;

use App\Http\Resources\PaginationResource;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * Class UserService
 * @package App\Services
 */
class ProductsService
{
    /**
     * @var Product
     */
    protected $product;

    public function getAll($limit = 15, $page = 1): PaginationResource
    {
        return new PaginationResource(
            Product::orderBy('created_at')->paginate(
                $limit,
                ['*'],
                'page',
                $page
            )

    );
    }

}
