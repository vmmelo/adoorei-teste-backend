<?php

namespace App\Http\Controllers;


use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private ProductsService $service;
    public function __construct(ProductsService $productsService)
    {
        $this->service = new ProductsService();

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \App\Http\Resources\PaginationResource
    {
        $page = $request->input('page');
        $limit = $request->input('limit');
        return $this->service->getAll($limit, $page);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // todo
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // todo
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // todo
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // todo
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // todo
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // todo
    }
}
