<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Field;
use Carbon\Carbon;


class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'customer')->first();
        $field = Field::where('status', 'available')->first();


        if (!$user || !$field) {
            return;
        }


        Booking::updateOrCreate([
            'user_id' => 2,
            'field_id' => 1,
            'team_name' => 'Tim Garuda',
            'phone' => '08123456789',
            'booking_date' => now()->toDateString(),
            'time_slots' => [9, 10, 11],
            'payment_method' => 'cash',
            'total_price' => 3 * 100000,
            'status' => 'booked',
        ]);
    }
}
