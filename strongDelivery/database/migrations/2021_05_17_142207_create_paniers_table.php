<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaniersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paniers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plat_id');
            $table->unsignedBigInteger('commande_id');
            $table->foreign('user_id')->references('id')->
            on('users')->onDelete('cascade');
             $table->foreign('plat_id')->references('id')->
             on('plats')->onDelete('cascade');
            $table->foreign('commande_id')->references('id')->
            on('commandes')->onDelete('cascade');

            
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
        Schema::dropIfExists('paniers');
    }
}
