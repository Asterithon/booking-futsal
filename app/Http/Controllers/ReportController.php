<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // DEFAULT RANGE: 30 hari terakhir
        $start = $request->start_date
            ? Carbon::parse($request->start_date)
            : now()->subDays(29);

        $end = $request->end_date
            ? Carbon::parse($request->end_date)
            : now();

        // =====================
        // BASE QUERY
        // =====================
        $baseQuery = Booking::whereBetween('booking_date', [
                $start->toDateString(),
                $end->toDateString()
            ])
            ->whereIn('status', ['completed', 'cancelled']);

        // =====================
        // TABLE DATA
        // =====================
        $bookings = (clone $baseQuery)
            ->with('field')
            ->orderBy('booking_date', 'desc')
            ->get();

        // =====================
        // CHART: BOOKING PER HARI
        // =====================
        $perDay = (clone $baseQuery)
            ->selectRaw('booking_date, COUNT(*) as total')
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        $bookingDates = $perDay->pluck('booking_date');
        $bookingTotals = $perDay->pluck('total');

        // =====================
        // CHART: STATUS
        // =====================
        $perStatus = (clone $baseQuery)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        $statusLabels = $perStatus->pluck('status')
            ->map(fn ($s) => ucfirst($s));

        $statusTotals = $perStatus->pluck('total');

        return view('reports.index', compact(
            'bookings',
            'bookingDates',
            'bookingTotals',
            'statusLabels',
            'statusTotals',
            'start',
            'end'
        ));
    }
}
