<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->integer('price');
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->foreignId('client_id')->constrained('clients', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id');
            $table->timestamps();



            // otherWay of define foreign key
            // $table->unsignedBigInteger('client_id');
            // $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
