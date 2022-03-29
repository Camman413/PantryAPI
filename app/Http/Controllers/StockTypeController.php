<?php

namespace App\Http\Controllers;

use App\Http\Resources\StockTypeResource;
use App\Models\StockType;
use App\Repositories\StockTypeRepository;
use Illuminate\Http\Request;

class StockTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private StockTypeRepository $stockTypeRepository;

    public function __construct(StockTypeRepository $stockTypeRepository)
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
     * @param  \App\Models\StockType  $StockType
     * @return \Illuminate\Http\Response
     */
    public function show(StockType $stocktype)
    {
        return new StockTypeResource($this->stockTypeRepository->getItemById($stocktype->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockType  $StockType
     * @return \Illuminate\Http\Response
     */
    public function update(StockType $stocktype, Request $request)
    {
        $details = $request->only([
            'name'
        ]);

        return new StockTypeResource($this->stockTypeRepository->updateItem($stocktype, $details));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockType  $StockType
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockType $stocktype)
    {
        $this->stockTypeRepository->deleteItem($stocktype);
    }
}
