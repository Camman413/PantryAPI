<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function instructions(){
        return $this->hasMany(Instruction::class);
    }
    protected $fillable = ['name'];
}
