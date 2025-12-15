<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $totalRooms = DB::table('rooms')->count();
        $totalBookings = DB::table('bookings')->count();
        $totalUsers = DB::table('users')->where('role', 'guest')->count();
        
        return view('admin-dashboard', compact('totalRooms', 'totalBookings', 'totalUsers'));
    }

    /**
     * View all rooms
     */
    public function rooms()
    {
        $rooms = DB::table('rooms')->orderBy('id', 'desc')->get();
        return view('admin-rooms', compact('rooms'));
    }

    /**
     * Show add room form
     */
    public function addRoomForm()
    {
        return view('admin-add-room');
    }

    /**
     * Store new room
     */
    public function addRoom(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms',
            'price' => 'required|numeric|min:0',
        ]);

        DB::table('rooms')->insert([
            'room_number' => $request->room_number,
            'price' => $request->price,
            'status' => 'available',
        ]);

        return redirect('/admin/rooms')->with('success', 'Room added successfully!');
    }

    /**
     * Show edit room form
     */
    public function editRoomForm($id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();
        
        if (!$room) {
            return redirect('/admin/rooms')->with('error', 'Room not found!');
        }
        
        return view('admin-edit-room', compact('room'));
    }

    /**
     * Update room
     */
    public function updateRoom(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,'.$id,
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,booked',
        ]);

        DB::table('rooms')->where('id', $id)->update([
            'room_number' => $request->room_number,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect('/admin/rooms')->with('success', 'Room updated successfully!');
    }

    /**
     * Delete room
     */
    public function deleteRoom($id)
    {
        $hasBookings = DB::table('bookings')->where('room_id', $id)->exists();
        
        if ($hasBookings) {
            return redirect('/admin/rooms')->with('error', 'Cannot delete room with existing bookings!');
        }

        DB::table('rooms')->where('id', $id)->delete();
        return redirect('/admin/rooms')->with('success', 'Room deleted successfully!');
    }

    /**
     * View all bookings with optional date filter
     */
    public function bookings(Request $request)
    {
        $query = DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->select(
                'bookings.*', 
                'users.name as user_name', 
                'users.email', 
                'rooms.room_number', 
                'rooms.price'
            );

        if ($request->has('from_date') && $request->from_date) {
            $query->where('bookings.check_in', '>=', $request->from_date);
        }
        
        if ($request->has('to_date') && $request->to_date) {
            $query->where('bookings.check_out', '<=', $request->to_date);
        }

        $bookings = $query->orderBy('bookings.id', 'desc')->get();
        
        return view('admin-bookings', compact('bookings'));
    }

    /**
     * Cancel booking
     */
    public function cancelBooking($id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();
        
        if (!$booking) {
            return redirect('/admin/bookings')->with('error', 'Booking not found!');
        }

        DB::table('bookings')->where('id', $id)->delete();
        
        DB::table('rooms')
            ->where('id', $booking->room_id)
            ->update(['status' => 'available']);
        
        return redirect('/admin/bookings')->with('success', 'Booking cancelled successfully!');
    }

    /**
     * View all users
     */
    public function users()
    {
        $users = DB::table('users')
            ->where('role', 'guest')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin-users', compact('users'));
    }

    /**
     * View user details
     */
    public function userDetails($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        
        if (!$user) {
            return redirect('/admin/users')->with('error', 'User not found!');
        }
        
        $bookings = DB::table('bookings')
            ->join('rooms', 'bookings.room_id', '=', 'rooms.id')
            ->where('bookings.user_id', $id)
            ->select('bookings.*', 'rooms.room_number', 'rooms.price')
            ->orderBy('bookings.created_at', 'desc')
            ->get();
        
        return view('admin-user-details', compact('user', 'bookings'));
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $hasBookings = DB::table('bookings')->where('user_id', $id)->exists();
        
        if ($hasBookings) {
            return redirect('/admin/users')->with('error', 'Cannot delete user with existing bookings!');
        }
        
        DB::table('users')->where('id', $id)->delete();
        
        return redirect('/admin/users')->with('success', 'User deleted successfully!');
    }
}