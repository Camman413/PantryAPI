<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrumentResource;
use App\Models\Instrument;
use App\Repositories\InstrumentRepository;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private InstrumentRepository $instrumentRepository;

    public function __construct(InstrumentRepository $instrumentRepository)
    {
        $this->instrumentRepository = $instrumentRepository;
    }

    public function index()
    {
        return InstrumentResource::collection($this->instrumentRepository->getAllItems());
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
            'name',
            'location_id',
        ]);

        return new InstrumentResource($this->instrumentRepository->createItem($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\Response
     */
    public function show(Instrument $instrument)
    {
        return new InstrumentResource($this->instrumentRepository->getItemById($instrument->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instrument $instrument)
    {
        $details = $request->only([
            'name',
            'location_id',
        ]);

        return new InstrumentResource($this->instrumentRepository->updateItem($instrument->id, $details));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instrument  $instrument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instrument $instrument)
    {
        $this->instrumentRepository->deleteItem($instrument->id);
    }
}
