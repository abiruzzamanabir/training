<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('url')->nullable()->default('https://bbf.digital/cyber-security-summit-2024/');
            $table->string('footer')->nullable()->default('Bangladesh Brand Forum. All rights reserved.');
            $table->dateTime('close')->nullable()->default('2024-02-20 00:00:00');
            $table->string('name')->nullable()->default('Cyber Security Summit');
            $table->string('amount')->nullable()->default('15000');
            $table->string('logo')->nullable()->default('logo.png');
            $table->string('iconbg')->nullable()->default('icon_bg.png');
            $table->string('background')->nullable()->default('background.jpg');
            $table->string('favicon')->nullable()->default('favicon.ico');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
};
