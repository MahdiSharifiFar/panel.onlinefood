<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('footer_section', function (Blueprint $table) {
            $table->id();
            $table->string('contact_address');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->string('title');
            $table->string('body');
            $table->string('work_days');
            $table->string('work_start_time');
            $table->string('work_end_time');
            $table->string('telegram_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('whatsapp_link')->nullable();
            $table->string('copyright');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footers');
    }
};
