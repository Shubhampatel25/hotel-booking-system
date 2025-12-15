<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = DB::table('rooms')
            ->where('status', 'available')
            ->get();
        
        return view('rooms', compact('rooms'));
    }
    
    public function showBooking($id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();
        
        if (!$room) {
            return redirect('/rooms')->with('error', 'Room not found');
        }
        
        return view('booking', compact('room'));
    }
}