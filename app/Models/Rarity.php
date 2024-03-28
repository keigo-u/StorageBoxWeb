<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rarity extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public static function getId($value) {
        switch($value) {
            case "OR":
                return 1;
            case "SR":
                return 2;
            case "VR":
                return 3;
            case "R":
                return 4;
            case "U":
                return 5;
            case "C":
                return 6;
            case "レアリティなし":
                return 7;
            case "KGM":
                return 8;
            case "MAS":
                return 9;
            case "LEG":
                return 10;
            case "WVC":
                return 11;
            case "VIC":
                return 12;
            case "MSZ":
                return 13;
            case "MHZ":
                return 14;
            case "MDS":
                return 15;
            case "MDZ":
                return 16;
            case "FFL":
                return 17;
            case "DSR":
                return 18;
            case "MSS":
                return 19;
            case "DG":
                return 20;
            case "KDL":
                return 21;
            case "KGR":
                return 22;
            default:
                return 0;
        }
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
