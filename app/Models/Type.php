<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public static function getId($value): int {
        switch($value) {
            case "クリーチャー":
                return 1;
            case "呪文":
                return 2;
            case "進化クリーチャー":
                return 3;
            case "サイキック":
                return 4;
            case "ドラグハート":
                return 5;
            case "フィールド":
                return 6;
            case "城":
                return 7;
            case "クロスギア":
                return 8;
            case "エグザイル・クリーチャー":
                return 9;
            case "GR":
                return 10;
            case "オーラ":
                return 11;
            case "タマシード":
                return 12;
            default:
                return 13;
        }
    }

    public function cards()
    {
        $this->hasMany(Card::class);
    }
}
