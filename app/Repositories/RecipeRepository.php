<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository extends Repository
{
    public function getAllItems(){
        return Recipe::all();
    }
    public function getItemById($id){
        return Recipe::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Recipe::create($details);
    }
    public function updateItem($id, array $details)
    {
        return Recipe::whereId($id)->update($details);
    }
    public function deleteItem($id)
    {
        Recipe::destroy($id);
    }
}