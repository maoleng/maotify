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
        Schema::create('notifies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('banner');
            $table->integer('type');
            $table->string('schedule');
            $table->foreignId('category_id')->constrained();
            $table->bigInteger('count')->default(0);
            $table->foreignId('content_id')->nullable()->constrained();
            $table->dateTime('created_at')->default(now());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifies');
    }
};
