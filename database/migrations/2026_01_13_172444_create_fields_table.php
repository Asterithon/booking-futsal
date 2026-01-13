<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up(): void
    {
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('price_per_hour');
            $table->enum('status', ['available', 'maintenance'])->default('available');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
