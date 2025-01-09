<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reception_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reception_form_id')->constrained('reception_forms')->onDelete('cascade');
            $table->string('category');
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['ok', 'nok']);
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reception_items');
    }
};
