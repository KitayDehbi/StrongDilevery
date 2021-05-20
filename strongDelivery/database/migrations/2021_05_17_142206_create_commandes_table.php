<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;


class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('client_id');            
            // $table->unsignedBigInteger('delivery_id');
            $table->integer('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('delivery_id')->nullable()->references('id')->on('users')->onDelete('cascade');           
            $table->string('adresse');
            $table->double('total',8,2);
            $table->timestamp('date');
            $table->string('type_de_paiment');
            $table->enum('statut',['nouvelle', 'en cours', 'livré', 'Annuler']);
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
        Schema::dropIfExists('commandes');
    }
}
