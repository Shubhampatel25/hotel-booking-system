<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .nav { background: #333; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .logout-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .user-info {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .user-info h2 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .info-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .label {
            font-weight: bold;
            color: #555;
        }
        
        .value {
            color: #333;
        }
        
        .section-title {
            font-size: 24px;
            margin: 30px 0 20px 0;
            color: #333;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }
        
        th, td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left; 
        }
        
        th { 
            background: #333; 
            color: white; 
        }
        
        .back-link {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 16px;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .no-bookings {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #666;
        }
    </style>
</head>
<body>
    <div class="nav">
        <strong>ADMIN PANEL</strong>
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/rooms">Manage Rooms</a>
        <a href="/admin/bookings">View Bookings</a>
        <a href="/admin/users">Manage Users</a>
        <form method="POST" action="/logout" style="display: inline; float: right;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <a href="/admin/users" class="back-link">← Back to Users</a>

        <div class="user-info">
            <h2>👤 User Information</h2>
            
            <div class="info-row">
                <div class="label">User ID:</div>
                <div class="value">#{{ $user->id }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Full Name:</div>
                <div class="value">{{ $user->name }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Email Address:</div>
                <div class="value">{{ $user->email }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Account Type:</div>
                <div class="value">{{ ucfirst($user->role) }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Registered On:</div>
                <div class="value">{{ date('F d, Y \a\t h:i A', strtotime($user->created_at)) }}</div>
            </div>
            
            <div class="info-row">
                <div class="label">Total Bookings:</div>
                <div class="value">{{ $bookings->count() }} booking(s)</div>
            </div>
        </div>

        <h3 class="section-title">📋 Booking History</h3>

        @if($bookings->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Guests</th>
                    <th>Total Price</th>
                    <th>Booked On</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>Room {{ $booking->room_number }}</td>
                    <td>{{ date('M d, Y', strtotime($booking->check_in)) }}</td>
                    <td>{{ date('M d, Y', strtotime($booking->check_out)) }}</td>
                    <td>{{ $booking->number_of_people }} {{ $booking->number_of_people > 1 ? 'people' : 'person' }}</td>
                    <td>${{ number_format($booking->total_price, 2) }}</td>
                    <td>{{ date('M d, Y', strtotime($booking->created_at)) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-bookings">
            <p><strong>No Bookings Yet</strong></p>
            <p style="margin-top: 10px; color: #999;">This user hasn't made any bookings.</p>
        </div>
        @endif
    </div>
</body>
</html>