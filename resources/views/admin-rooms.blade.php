<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .nav { background: #333; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .logout-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background: #333; color: white; }
        .btn { background: blue; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; }
        .btn-delete { background: red; padding: 8px 15px; font-size: 14px; }
        .btn-edit { background: #28a745; padding: 8px 15px; font-size: 14px; margin-right: 5px; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="nav">
        <strong>ADMIN PANEL</strong>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/rooms">Manage Rooms</a>
        <a href="/admin/bookings">View Bookings</a>
        <form method="POST" action="/logout" style="display: inline; float: right;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <h1>Manage Rooms</h1>
    <a href="/admin/add-room" class="btn">Add New Room</a>

    <table style="margin-top: 20px;">
        <tr>
            <th>ID</th>
            <th>Room Number</th>
            <th>Price</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        @foreach($rooms as $room)
        <tr>
            <td>{{ $room->id }}</td>
            <td>{{ $room->room_number }}</td>
            <td>${{ $room->price }}</td>
            <td>{{ ucfirst($room->status) }}</td>
            <td>
                <a href="/admin/edit-room/{{ $room->id }}" class="btn btn-edit" style="text-decoration: none;">Edit</a>
                <a href="/admin/delete-room/{{ $room->id }}" class="btn btn-delete" onclick="return confirm('Delete this room?')" style="text-decoration: none;">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>