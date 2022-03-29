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
    /**
     * @param Location $location
     */
    public function updateItem(mixed $location, array $details)
    {
        $location->update($details);
        return $location->refresh();
    }
    /**
     * @param Location $location
     */
    public function deleteItem(mixed $location)
    {
        Location::destroy($location);
    }
}