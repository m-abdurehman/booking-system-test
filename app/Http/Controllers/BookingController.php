<?php

namespace App\Http\Controllers;

use App\Events\BookingConfirmed;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())->get();
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'provider_service_id' => 'required|exists:provider_services,id',
            'booking_date' => 'required|date',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'provider_service_id' => $request->provider_service_id,
            'booking_date' => $request->booking_date,
        ]);

        return response()->json($booking, 201);
    }

    public function show($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_date' => 'required|date',
        ]);

        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->update($request->all());

        return response()->json($booking);
    }

    public function destroy($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);
        $booking->delete();

        return response()->json(['message' => 'Booking deleted'], 200);
    }

    public function confirm($id)
    {
        $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

        if ($booking->status === 'confirmed') {
            return response()->json(['message' => 'Booking is already confirmed'], 400);
        }

        $booking->update(['status' => 'confirmed']);

        broadcast(new BookingConfirmed($booking));

        return response()->json(['message' => 'Booking confirmed', 'booking' => $booking]);
    }
}
