<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reception_forms', function (Blueprint $table) {
            $table->id();
            $table->string('project');
            $table->date('check_date');
            $table->string('stamp_number');
            $table->string('check_roadmap');
            $table->string('check_schemas');
            $table->string('check_etiquette');
            $table->string('receiver_email');
            $table->text('missing_parts')->nullable();
            $table->text('unmounted_parts')->nullable();
            $table->string('signature_performer');
            $table->longText('signature_image')->nullable();
            $table->string('signature_witness')->nullable();
            $table->longText('signature_reviewer')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reception_forms');
    }
};
