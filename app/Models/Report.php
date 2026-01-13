<?php

namespace App\Models;

use App\Models\Booking;
use Illuminate\Support\Collection;

class Report
{
    public static function bookingByDate(?string $date = null): Collection
    {
        $query = Booking::with(['user', 'field']);

        if ($date) {
            $query->whereDate('booking_date', $date);
        }

        return $query->get();
    }

    public static function totalIncome(?string $date = null): int
    {
        return self::bookingByDate($date)
            ->sum(fn ($b) => $b->field->price_per_hour);
    }
}
