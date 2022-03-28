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
            $table->foreignId('user_id');
            $table->foreignId('client_id')->constrained('clients', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('price');
            $table->string('start_date')->default(now()->format('Y-m-d'));
            $table->string('end_date')->default(now()->format('Y-m-d'));
            $table->enum('status', ['pending', 'complete'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->longText('description');
            $table->softDeletes();
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
