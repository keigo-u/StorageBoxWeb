<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
