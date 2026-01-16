<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'field'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('reports.index', compact('bookings'));
    }
}
