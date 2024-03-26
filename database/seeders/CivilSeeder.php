<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("civils")->insert([
            ["name" => "火"],
            ["name" => "水"],
            ["name" => "自然"],
            ["name" => "光"],
            ["name" => "闇"],
            ["name" => "ゼロ"]
        ]);
    }
}
