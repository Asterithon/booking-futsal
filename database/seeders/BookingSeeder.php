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
            'user_id' => $user->id,
            'field_id' => $field->id,
            'booking_date' => Carbon::today(),
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
        ], [
            'status' => 'booked'
        ]);
    }
}
