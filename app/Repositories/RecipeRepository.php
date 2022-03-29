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
    /**
     * @param Recipe $recipe
     */
    public function updateItem(mixed $recipe, array $details)
    {
        return Recipe::whereId($recipe)->update($details);
    }
    /**
     * @param Recipe $recipe
     */
    public function deleteItem(mixed $recipe)
    {
        Recipe::destroy($recipe);
    }
}