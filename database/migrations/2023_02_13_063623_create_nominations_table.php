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
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->string('uid');
            $table->string('ukey');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('designation');
            $table->string('organization');
            $table->string('address');
            $table->string('confirmLinkSend')->default(0);
            $table->longText('members');
            $table->string('comment')->nullable();
            $table->string('payment')->nullable();
            $table->string('invoice')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('trash')->default(false);
            $table->boolean('pv')->default(false);
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
        Schema::dropIfExists('nominations');
    }
};
