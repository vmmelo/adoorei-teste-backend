<?php

namespace App\Services;

use App\Http\Resources\PaginationResource;
use App\Models\Sale;
use App\Models\SalesProduct;

/**
 * Class SalesService
 * @package App\Services
 */
class SalesService
{

    public function getAll($limit = 5, $page = 1): PaginationResource
    {
        return new PaginationResource(
            Sale::orderBy('created_at', 'desc')->paginate(
                $limit,
                ['*'],
                'page',
                $page
            )

    );
    }

    public function getSaleById($id): Sale
    {
        return Sale::where('id', $id)->with('salesProducts', 'salesProducts.product')->firstOrFail();
    }

    public function store($data)
    {
        try {
            \DB::beginTransaction();
            $amount = $this->getSalePriceFromProducts($data['products']);
            $sale = Sale::create(['amount' => $amount]);

            $productsCollection = collect($data['products']);
            $productsCollection = $productsCollection->map(function ($p) use ($sale) {
                return new SalesProduct([
                    'sale_id' => $sale->id,
                    'product_id' => $p['id'],
                    'amount' => $p['amount']
                ]);
            })->all();
            $sale->salesProducts()->saveMany($productsCollection);
            \DB::commit();
            return $this->getSaleById($sale->id);
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    private function getSalePriceFromProducts(array $products)
    {
        $productsService = new ProductsService();
        $amount = 0;
        $productsFind = $productsService->findProductsByIds(collect($products)->pluck('id')->all());
        foreach($products as $product){
            $amount = $amount + ($product['amount'] * $productsFind[$product['id']]['price']);
        }
        return $amount;
    }



}
