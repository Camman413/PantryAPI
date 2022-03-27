<?php

namespace App\Repositories;

use App\Models\Instrument;

class InstrumentRepository extends Repository
{
    public function getAllItems(){
        return Instrument::all();
    }
    public function getItemById(int $id){
        return Instrument::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Instrument::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return Instrument::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        Instrument::destroy($id);
    }
}