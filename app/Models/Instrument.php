<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;
    public function Instructions(){
        return $this->hasMany(Instruction::class);
    }
    public function Location(){
        return $this->belongsTo(Location::class);
    }

    protected $fillable = ['name', 'location_id'];
}
