<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository extends Repository
{
    public function getAllItems(){
        return Recipe::all();
    }
    public function getItemById(int $id){
        return Recipe::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Recipe::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return Recipe::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        Recipe::destroy($id);
    }
}