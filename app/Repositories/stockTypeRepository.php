<?php

namespace App\Repositories;

use App\Models\StockType;

class stockTypeRepository extends Repository
{
    public function getAllItems(){
        return StockType::all();
    }
    public function getItemById(int $id): StockType
    {
        return StockType::findOrFail($id);
    }
    public function createItem(array $details): StockType
    {
        return StockType::create($details);
    }
    /**
     * @param StockType $stockType
     */
    public function updateItem(mixed $stockType, array $details): StockType
    {
        $stockType->update($details);
        return $stockType->refresh();
    }
    /**
     * @param StockType $stockType
     */
    public function deleteItem(mixed $stockType)
    {
        StockType::destroy($stockType);
    }
}