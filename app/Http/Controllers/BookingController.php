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

        // Ambil booking yang sudah ada di tanggal tersebut
        $bookings = Booking::where('booking_date', $date)
            ->where('status', '!=', 'cancelled')
            ->get(['start_time', 'end_time']);

        return view('bookings.create', compact('field', 'date', 'bookings'));
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
            'status'         => $data['payment_method'] === 'cash'
                                ? 'pending'
                                : 'pending',
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
}
