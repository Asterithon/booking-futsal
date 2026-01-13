<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        $bookings = Report::bookingByDate($date);
        $total = Report::totalIncome($date);

        return view('reports.index', compact('bookings', 'total', 'date'));
    }
}
