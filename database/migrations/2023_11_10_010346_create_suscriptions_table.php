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
        Schema::create('suscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('client_id');
            $table->decimal('cost', 10, 2); // '10, 2' indica 10 dígitos en total y 2 decimales
            $table->date('start_date');
            $table->date('expiration_date');
            $table->boolean('status')->default(true); // Crea un campo booleano con valor predeterminado true
            $table->timestamps();
            $table->foreign('plan_id')->references('id')->on('plans');
            $table->foreign('client_id')->references('id')->on('clients');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suscripcion');
    }
};
