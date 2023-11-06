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
        Schema::create('planes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('descripcion');
            $table->decimal('cost', 10, 2); // '10, 2' indica 10 dígitos en total y 2 decimales
            $table->timestamps();
            $table->boolean('status'); // Crea un campo booleano
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_servicios');
    }
};
