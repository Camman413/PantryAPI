<?php

namespace App\Repositories;

use App\Models\StockType;

class stockTypeRepository extends Repository
{
    public function getAllItems(){
        return StockType::all();
    }
    public function getItemById(int $id){
        return StockType::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return StockType::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return StockType::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        StockType::destroy($id);
    }
}