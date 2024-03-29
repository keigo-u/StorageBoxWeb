<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Civil extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public static function getId($value): int {
        switch($value) {
            case "火":
                return 1;
            case "水":
                return 2;
            case "自然":
                return 3;
            case "光":
                return 4;
            case "闇":
                return 5;
            case "ゼロ":
                return 6;
            default:
                return 0;
        }
    }

    public function cards()
    {
        return $this->belongsToMany(Card::class);
    }
}
