<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string("card_name")->comment("カード名");
            $table->string("pack_name")->comment("パック名");
            $table->string("base_image_url")->comment("元画像URL");
            $table->string("image_url")->comment("画像URL");
            $table->string("power")->comment("パワー");
            $table->string("cost")->comment("コスト");
            $table->integer("mana")->comment("マナ");
            $table->string("illust")->comment("イラストレーター");
            $table->string("ability")->comment("特殊能力");
            $table->string("flavor")->comment("フレーバーテキスト");
            $table->foreignId("type_id")->constrained();
            $table->string("rarity_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
