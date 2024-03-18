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
        Schema::create('outboxs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('subject');
            $table->string('body');
            $table->string('file_upload')->nullable();
            $table->enum('is_read', ['0', '1']);
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
        Schema::dropIfExists('outboxs');
    }
};
