<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Riwayat booking user
     */
    public function index()
    {
        $bookings = Booking::with('field')
            ->where('user_id', Auth::id())
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Tampilkan form booking
     */
    public function create(Request $request)
    {
        $field = Field::first(); // sementara 1 lapangan
        $date  = $request->booking_date ?? now()->toDateString();

        return view('bookings.create', compact('field'));
    }

    /**
     * Simpan booking
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'team_name'     => 'required|string',
            'phone'         => 'required|string',
            'booking_date'  => 'required|date',
            'start_hour'    => 'required|integer|min:0|max:23',
            'end_hour'      => 'required|integer|gt:start_hour|max:24',
            'payment_method'=> 'required|in:cash,qris',
        ]);

        $startTime = sprintf('%02d:00:00', $data['start_hour']);
        $endTime   = sprintf('%02d:00:00', $data['end_hour']);

        /**
         * VALIDASI BENTROK WAKTU (WAJIB)
         * booking.start < end AND booking.end > start
         */
        $conflict = Booking::where('booking_date', $data['booking_date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)
                  ->where('end_time', '>', $startTime);
            })
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['time' => 'Jam yang dipilih sudah dibooking'])
                ->withInput();
        }

        $field = Field::first();
        $duration = $data['end_hour'] - $data['start_hour'];
        $totalPrice = $duration * $field->price_per_hour;

        // SIMPAN BOOKING
        Booking::create([
            'user_id'        => Auth::id(),
            'field_id'       => $field->id,
            'team_name'      => $data['team_name'],
            'phone'          => $data['phone'],
            'booking_date'   => $data['booking_date'],
            'start_time'     => $startTime,
            'end_time'       => $endTime,
            'payment_method'=> $data['payment_method'],
            'total_price'    => $totalPrice,
            'status' => $data['payment_method'] === 'cash'
                ? 'pending'
                : 'pending',
            'payment_status' => $data['payment_method'] === 'qris'
                ? 'unpaid'
                : 'unpaid',

        ]);

        // QRIS masih dummy → tidak simpan transaksi
        if ($data['payment_method'] === 'qris') {
            return redirect()->route('booking.payment');
        }

        return redirect()->route('dashboard')
            ->with('success', 'Booking berhasil disimpan');
    }

    /**
     * Batalkan booking (soft cancel)
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking dibatalkan');
    }

    /**
     * Halaman pembayaran QRIS (dummy)
     */
    public function payment()
    {
        return view('bookings.payment');
    }

    /**
     * Alias riwayat booking (jika dipakai terpisah)
     */
    public function myBookings()
    {
        $bookings = Booking::with('field')
            ->where('user_id', Auth::id())
            ->orderBy('booking_date', 'desc')
            ->get();

        return view('bookings.my', compact('bookings'));
    }

    public function adminIndex(Request $request)
{
    $query = Booking::with(['field', 'user']);

    if ($request->date === 'today') {
        $query->whereDate('booking_date', today());
    } elseif ($request->date === 'tomorrow') {
        $query->whereDate('booking_date', today()->addDay());
    } elseif ($request->filled('date')) {
        $query->whereDate('booking_date', $request->date);
    }

    $bookings = $query->orderBy('booking_date')->get();

    return view('bookings.admin.index', compact('bookings'));
}

public function cancel(Request $request, Booking $booking)
{
    $request->validate([
        'reason' => 'required|string',
    ]);

    $booking->update([
        'status' => 'cancelled',
        'cancelled_reason' => $request->reason,
        'cancelled_at' => now(),
    ]);

    return back()->with('success', 'Booking dibatalkan');
}

public function updateStatus(Request $request, Booking $booking)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,completed,cancelled',
    ]);

    $oldStatus = $booking->status;

    $booking->update([
        'status' => $request->status,
        'payment_status' =>
            $request->status === 'confirmed'
                ? 'paid'
                : $booking->payment_status,
    ]);

    $booking->statusHistories()->create([
        'old_status' => $oldStatus,
        'new_status' => $request->status,
        'changed_by'=> auth::id(),
    ]);

    return back()->with('success', 'Status diperbarui');
}


public function show(Booking $booking)
{
    return view('bookings.admin.show', compact('booking'));
}
public function edit(Booking $booking)
{
    return view('bookings.admin.edit', compact('booking'));
}
public function update(Request $request, Booking $booking)
{
    $data = $request->validate([
        'team_name'   => 'required|string',
        'phone'       => 'required|string',
        'start_hour'  => 'required|integer|min:0|max:23',
        'end_hour'    => 'required|integer|gt:start_hour|max:24',
    ]);

    $startTime = sprintf('%02d:00:00', $data['start_hour']);
    $endTime   = sprintf('%02d:00:00', $data['end_hour']);

    // VALIDASI BENTROK (KECUALI BOOKING INI SENDIRI)
    $conflict = Booking::where('booking_date', $booking->booking_date)
        ->where('id', '!=', $booking->id)
        ->where('status', '!=', 'cancelled')
        ->where(function ($q) use ($startTime, $endTime) {
            $q->where('start_time', '<', $endTime)
              ->where('end_time', '>', $startTime);
        })
        ->exists();

    if ($conflict) {
        return back()
            ->withErrors(['time' => 'Jam baru bentrok dengan booking lain'])
            ->withInput();
    }

    $duration = $data['end_hour'] - $data['start_hour'];
    $totalPrice = $duration * $booking->field->price_per_hour;

    $booking->update([
        'team_name'    => $data['team_name'],
        'phone'        => $data['phone'],
        'start_time'   => $startTime,
        'end_time'     => $endTime,
        'total_price'  => $totalPrice,
    ]);

    return redirect()->route('bookings.admin')
        ->with('success', 'Booking berhasil diperbarui');
}

public function availability(Request $request)
{
    $request->validate([
        'date' => 'required|date'
    ]);

    $bookings = Booking::whereDate('booking_date', $request->date)
        ->where('status', '!=', 'cancelled')
        ->get(['start_time', 'end_time']);

    $bookedHours = [];

foreach ($bookings as $booking) {
    $start = \Carbon\Carbon::parse($booking->start_time)->hour;
    $end   = \Carbon\Carbon::parse($booking->end_time)->hour;

    for ($h = $start; $h < $end; $h++) {
        $bookedHours[] = $h;
    }
}

    return response()->json([
        'booked_hours' => array_values(array_unique($bookedHours))
    ]);
}




}
