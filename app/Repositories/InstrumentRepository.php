<?php

namespace App\Repositories;

use App\Models\Instrument;

class InstrumentRepository extends Repository
{
    public function getAllItems(){
        return Instrument::all();
    }
    public function getItemById(int $id): Instrument
    {
        return Instrument::findOrFail($id);
    }
    /**
     * @param Instrument $instrument
     */
    public function createItem(array $details): Instrument
    {
        return Instrument::create($details);
    }
    /**
     * @param Instrument $instrument
     */
    public function updateItem(mixed $instrument, array $details): Instrument
    {
        $instrument->update($details);
        return $instrument->refresh();
    }
    public function deleteItem(mixed $instrument)
    {
        Instrument::destroy($instrument->id);
    }
}