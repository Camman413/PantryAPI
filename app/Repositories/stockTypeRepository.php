<?php

namespace App\Repositories;

use App\Models\stockType;

class stockTypeRepository extends Repository
{
    public function getAllItems(){
        return stockType::all();
    }
    public function getItemById($id){
        return stockType::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return stockType::create($details);
    }
    public function updateItem($id, array $details)
    {
        return stockType::whereId($id)->update($details);
    }
    public function deleteItem($id)
    {
        stockType::destroy($id);
    }
}