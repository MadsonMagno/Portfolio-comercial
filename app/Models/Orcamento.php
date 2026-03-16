<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function itens(){
        return $this->hasMany(Item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
