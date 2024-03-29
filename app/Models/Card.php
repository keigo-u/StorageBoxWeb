<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        "card_name",
        "pack_name",
        "base_image_url",
        "image_url",
        "power",
        "cost",
        "mana",
        "illust",
        "ability",
        "flavor",
        "type_id",
        "rarity_id"
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function rarity()
    {
        return $this->belongsTo(Rarity::class);
    }

    public function civils()
    {
        return $this->belongsToMany(Civil::class);
    }

    public function races()
    {
        return $this->belongsToMany(Race::class);
    }
}
