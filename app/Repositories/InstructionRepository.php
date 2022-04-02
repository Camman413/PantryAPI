<?php

namespace App\Repositories;

use App\Models\Instruction;

class InstructionRepository extends Repository
{
    public function getAllItems(){
        return Instruction::all();
    }
    public function getItemById(int $id):Instruction
    {
        return Instruction::findOrFail($id);
    }
    public function createItem(array $details): Instruction
    {
        return Instruction::create($details);
    }

    /**
     * @param Instruction $instruction
     */
    public function updateItem(mixed $instruction, array $details): Instruction
    {
        $instruction->update($details);
        return $instruction->refresh();
    }
    /**
     * @param Instruction $instruction
     */
    public function deleteItem(mixed $instruction)
    {
        Instruction::destroy($instruction->id);
    }
}