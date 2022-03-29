<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstructionResource;
use App\Models\Instruction;
use App\Repositories\InstructionRepository;
use Illuminate\Http\Request;

class InstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private InstructionRepository $instructionRepository;

    public function __construct(InstructionRepository $instructionRepository)
    {
        $this->instructionRepository = $instructionRepository;
    }
    
    public function index()
    {
        return InstructionResource::collection($this->instructionRepository->getAllItems());
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
            'recipe_id',
            'rank',
            'ingredient_id',
            'ingredientAmount', 
            'instrument_id',
            'description',
        ]);

        return new InstructionResource($this->instructionRepository->createItem($details));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function show(Instruction $instruction)
    {
        return new InstructionResource($this->instructionRepository->getItemById($instruction->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Instruction $instruction)
    {
        $details = $request->only([
            'recipe_id',
            'rank',
            'ingredient_id',
            'ingredientAmount', 
            'instrument_id',
            'description',
        ]);

        return new InstructionResource($this->instructionRepository->updateItem($instruction, $details));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Instruction  $instruction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Instruction $instruction)
    {
        $this->instructionRepository->deleteItem($instruction);
    }
}
