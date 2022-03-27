<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockTypeResource;
use App\Models\stockType;
use App\Repositories\stockTypeRepository;
use Illuminate\Http\Request;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private stockTypeRepository $stockTypeRepository;

    public function __construct(stockTypeRepository $stockTypeRepository)
    {
        $this->stockTypeRepository = $stockTypeRepository;
    }

    public function index()
    {
        return StockTypeResource::collection($this->stockTypeRepository->getAllItems());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details = $request->only([
            'name'
        ]);

        return new StockTypeResource($this->stockTypeRepository->createItem($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\stockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function show(stockType $stockType)
    {
        return new StockTypeResource($this->stockTypeRepository->getItemById($stockType->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\stockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function update(stocktype $stockType, Request $request)
    {
        $details = $request->only([
            'name'
        ]);

        return new StockTypeResource($this->stockTypeRepository->updateItem($stockType->id, $details));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\stockType  $stockType
     * @return \Illuminate\Http\Response
     */
    public function destroy(stockType $stockType)
    {
        $this->stockTypeRepository->deleteItem($stockType->id);
    }
}
