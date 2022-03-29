<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\Instrument;
use Illuminate\Http\Resources\Json\JsonResource;


class InstructionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'recipe' => $this->recipe_id,
            'rank' => $this->rank,
            'ingredient_id' => new IngredientResource(Ingredient::findOrFail($this->ingredient_id)),
            'ingredientAmount' => $this->ingredientAmount,
            'instrument_id' => new InstrumentResource(Instrument::findOrFail($this->instrument_id)),
            'description' => $this->description
        ];
    }
}
