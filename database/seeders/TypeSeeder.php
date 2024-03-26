<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("types")->insert([
            ["name" => "クリーチャー"],
            ["name" => "呪文"],
            ["name" => "進化クリーチャー"],
            ["name" => "サイキック"],
            ["name" => "ドラグハート"],
            ["name" => "フィールド"],
            ["name" => "城"],
            ["name" => "クロスギア"],
            ["name" => "エグザイル・クリーチャー"],
            ["name" => "GR"],
            ["name" => "オーラ"],
            ["name" => "タマシード"],
            ["name" => "その他"]
        ]);
    }
}
