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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('names');
            $table->string('surnames');
            $table->unsignedBigInteger('phone');
            $table->string('email');
            $table->string('address');
            $table->string('id_type');

            $table->string('RTN')->default("");
            $table->string('birth_date')->default("");
            $table->string('gender')->default("");
            $table->string('status')->default("");


            $table->unsignedBigInteger('identification');
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
        Schema::dropIfExists('clients');
    }
};
