<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->enum('status', ['available', 'maintenance', 'disabled'])
                ->default('available')
                ->change();
        });
    }

    public function down()
    {
        Schema::table('fields', function (Blueprint $table) {
            $table->enum('status', ['available', 'maintenance'])
                ->default('available')
                ->change();
        });
    }
};