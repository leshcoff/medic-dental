<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->index();
            $table->string('lastname', 150)->nullable();
            $table->date('birthday')->nullable();
            $table->string('gender')->nullable();
            $table->string('rfc', 13)->nullable();

            $table->string('phone', 10)->nullable();
            $table->string('email', 250)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('photo', 50)->nullable();
            $table->mediumText('notes')->nullable();

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
        Schema::dropIfExists('patients');
    }
}
