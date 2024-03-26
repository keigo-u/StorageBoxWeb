<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RaritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("rarities")->insert([
            ["name" => "OR"],
            ["name" => "SR"],
            ["name" => "VR"],
            ["name" => "R"],
            ["name" => "U"],
            ["name" => "C"],
            ["name" => "レアリティなし"],
            ["name" => "KGM"],
            ["name" => "MAS"],
            ["name" => "LEG"],
            ["name" => "WVC"],
            ["name" => "VIC"],
            ["name" => "MSZ"],
            ["name" => "MHZ"],
            ["name" => "MDS"],
            ["name" => "MDZ"],
            ["name" => "FFL"],
            ["name" => "DSR"],
            ["name" => "MSS"],
            ["name" => "DG"],
            ["name" => "KDL"],
            ["name" => "KGR"]
        ]);
    }
}
