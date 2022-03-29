<?php

namespace App\Http\Resources;

use App\Models\Instruction;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResource extends JsonResource
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
            'name' => $this->name,
            'instructions' => InstructionResource::collection(Instruction::where('recipe_id', $this->id)->get()),

        ];
    }
}
