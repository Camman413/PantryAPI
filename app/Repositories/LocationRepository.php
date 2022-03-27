<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository extends Repository
{
    public function getAllItems(){
        return Location::all();
    }
    public function getItemById(int $id){
        return Location::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Location::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return Location::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        Location::destroy($id);
    }
}