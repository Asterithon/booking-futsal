<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('team_name')->after('field_id');
            $table->string('phone')->after('team_name');
            $table->date('booking_date')->change();

            $table->string('payment_method')->after('booking_date');
            $table->integer('total_price')->after('payment_method');

            $table->string('status')->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'team_name',
                'phone',
                'payment_method',
                'total_price'
            ]);
        });
    }
};
