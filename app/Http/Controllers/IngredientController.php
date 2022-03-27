<?php

namespace App\Http\Controllers;

use App\Http\Resources\IngredientResource;
use App\Models\Ingredient;
use App\Repositories\IngredientRepository;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private IngredientRepository $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }
    
    public function index()
    {
        return IngredientResource::collection($this->ingredientRepository->getAllItems());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $details = $request->only([
            'name',
            'stock',
            'stock_type_id'
        ]);

        return new IngredientResource($this->ingredientRepository->createItem($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->route('ingredient');

        return new IngredientResource($this->ingredientRepository->getItemById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->route('ingredient');

        $details = $request->only([
            'name',
            'stock',
            'stock_type_id'
        ]);

        return new IngredientResource($this->ingredientRepository->updateItem($id, $details));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->route('ingredient');

        $this->ingredientRepository->deleteItem($id);
    }
}
