<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruction extends Model
{
    use HasFactory;

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }
    public function ingredient(){
        return $this->belongsTo(Ingredient::class);
    }
    public function instrument(){
        return $this->belongsTo(Instrument::class);
    }

    protected $fillable = [
        'recipe_id',
        'rank',
        'ingredient_id',
        'ingredientAmount', 
        'instrument_id',
        'description',
    ];
}
