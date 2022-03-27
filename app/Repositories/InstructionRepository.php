<?php

namespace App\Repositories;

use App\Models\Instruction;

class InstructionRepository extends Repository
{
    public function getAllItems(){
        return Instruction::all();
    }
    public function getItemById(int $id){
        return Instruction::findOrFail($id);
    }
    public function createItem(array $details)
    {
        return Instruction::create($details);
    }
    public function updateItem(int $id, array $details)
    {
        return Instruction::whereId($id)->update($details);
    }
    public function deleteItem(int $id)
    {
        Instruction::destroy($id);
    }
}