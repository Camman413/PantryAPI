<?php

namespace App\Repositories;

use App\Models\Ingredient;

class IngredientRepository extends Repository
{
    public function getAllItems()
    {
        return Ingredient::all();
    }
    public function getItemById(int $id): Ingredient
    {
        return Ingredient::findOrFail($id);
    }
    public function createItem(array $details): Ingredient
    {
        return Ingredient::create($details);
    }

    /**
     * @param ingredient $ingredient
     */

    public function updateItem(mixed $ingredient, array $details): Ingredient
    {
        $ingredient->update($details);
        return $ingredient->refresh();
    }
    /**
     * @param ingredient $ingredient
     */
    public function deleteItem(mixed $ingredient)
    {
        Ingredient::destroy($ingredient->id);
    }
}