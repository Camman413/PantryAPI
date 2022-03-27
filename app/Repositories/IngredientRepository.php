<?php

namespace App\Repositories;

use App\Models\Ingredient;

class IngredientRepository extends Repository
{
    public function getAllItems(){
        return Ingredient::all();
    }
    public function getItemById(int $id){
        return Ingredient::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Ingredient::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return Ingredient::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        Ingredient::destroy($id);
    }
}