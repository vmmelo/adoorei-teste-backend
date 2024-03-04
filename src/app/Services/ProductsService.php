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
    public function getAll($limit = 15, $page = 1): PaginationResource
    {
        return new PaginationResource(
            Product::orderBy('name')->paginate(
                $limit,
                ['*'],
                'page',
                $page
            )

    );
    }

    public function findProductsByIds(array $products_ids)
    {
        return Product::whereIn('id', $products_ids)->get()->keyBy('id');
    }

}
