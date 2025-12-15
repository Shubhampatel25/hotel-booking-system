<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'number_of_people' => 'required|integer|min:1|max:4',
        ]);

        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $nights = $checkIn->diff($checkOut)->days;
        
        $room = DB::table('rooms')->where('id', $request->room_id)->first();
        $subtotal = $nights * $room->price;
        $taxes = $subtotal * 0.134;
        $totalPrice = $subtotal + $taxes;

        DB::table('bookings')->insert([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'number_of_people' => $request->number_of_people,
        ]);

        DB::table('rooms')
            ->where('id', $request->room_id)
            ->update(['status' => 'booked']);

        return redirect('/my-bookings')->with('success', 'Booking confirmed successfully!');
    }

    public function my()
    {
        $bookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->where('bookings.user_id', Auth::id())
            ->select('bookings.*', 'rooms.room_number', 'rooms.price', 'rooms.image')
            ->orderBy('bookings.id', 'desc')
            ->get();
        
        return view('my-bookings', compact('bookings'));
    }
}