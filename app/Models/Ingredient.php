<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    public function instructions(){
        return $this->hasMany(Instruction::class);
    }
    public function stockType(){
        return $this->belongsTo(stockType::class);
    }

    protected $fillable = ['name', 'stock', 'stock_type_id'];
}