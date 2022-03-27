<?php

namespace App\Repositories;

use App\Models\stockType;

class stockTypeRepository extends Repository
{
    public function getAllItems(){
        return stockType::all();
    }
    public function getItemById(int $id){
        return stockType::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return stockType::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return stockType::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        stockType::destroy($id);
    }
}