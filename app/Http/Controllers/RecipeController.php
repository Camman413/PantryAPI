<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private RecipeRepository $recipeRepository;

    public function __construct(RecipeRepository $recipeRepository)
    {
        $this->recipeRepository = $recipeRepository;
    }
    
    public function index()
    {
        return RecipeResource::collection($this->recipeRepository->getAllItems());
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
            'name'
        ]);
        return new RecipeResource($this->recipeRepository->createItem($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->route('recipe');
        return new RecipeResource($this->recipeRepository->getItemById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->route('recipe');

        $details = $request->only([
            'name'
        ]);

        return new RecipeResource($this->recipeRepository->updateItem($id, $details));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->route('recipe');
        $this->recipeRepository->deleteItem($id);
    }
}
