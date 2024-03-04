<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Services\SalesService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SalesController extends Controller
{
    private SalesService $service;
    public function __construct(SalesService $salesService)
    {
        $this->service = new SalesService();

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \App\Http\Resources\PaginationResource
    {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $withTrashed = $request->input('with_trashed');
        return $this->service->getAll($limit, $page, $withTrashed);
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
        try {
            $validatedData = $this->validate($request, Sale::$rulesStore);
            return $this->service->store($validatedData);
        } catch (ValidationException $e){
            dd($e->errors());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return $this->service->getSaleById(intval($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Sale not found'], 400);
        }
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

    public function addProducts(Request $request, string $id)
    {
        try {
            return $this->service->addProducts(intval($id), $request->all());
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Sale not found'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->service->destroy(intval($id));
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Sale not found'], 400);
        }
        return response()->noContent();
    }
}
