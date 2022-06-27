<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('dni',45)->unique();
            $table->bigInteger('id_reg');
            $table->bigInteger('id_com');
            $table->string('email',120);
            $table->string('name',45);
            $table->string('last_name',45);
            $table->string('address',255)->nullable();
            $table->dateTime('date_reg');
            $table->enum('status',['A','I']);
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
        Schema::dropIfExists('customers');
    }
}
