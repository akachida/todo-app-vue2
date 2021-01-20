<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodoTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('todo_tags', function (Blueprint $table) {
            $table->id();
            $table->uuid('todo_uuid');
            $table->uuid('tag_uuid');
            $table->foreign('todo_uuid')
                ->references('uuid')
                ->on('todos')
                ->onDelete('cascade');
            $table->foreign('tag_uuid')
                ->references('uuid')
                ->on('todos')
                ->onDelete('cascade');
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
        Schema::dropIfExists('todo_tags');
    }
}
