<!DOCTYPE html>
<html>
<head>
    <title>All Bookings</title>
    <style>
        body { 
            font-family: Arial; 
            padding: 20px; 
            background: #f5f5f5; 
            margin: 0;
        }
        
        .nav { 
            background: #333; 
            color: white; 
            padding: 15px; 
            margin-bottom: 20px; 
            border-radius: 5px; 
        }
        
        .nav a { 
            color: white; 
            margin-right: 20px; 
            text-decoration: none; 
        }
        
        .nav a:hover { 
            text-decoration: underline; 
        }
        
        .logout-btn { 
            background: red; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            cursor: pointer; 
            border-radius: 5px; 
        }
        
        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .filter-box h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .filter-box form {
            display: flex;
            gap: 15px;
            align-items: end;
            flex-wrap: wrap;
        }
        
        .filter-box .form-group { 
            flex: 1;
            min-width: 200px;
        }
        
        .filter-box label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        .filter-box input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .btn { 
            background: blue; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            font-size: 14px;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .btn-clear {
            background: #6c757d;
        }
        
        .btn-cancel { 
            background: #dc3545; 
            padding: 8px 15px; 
            font-size: 14px; 
            text-decoration: none;
            color: white;
            border-radius: 4px;
            display: inline-block;
        }
        
        .btn-cancel:hover {
            background: #c82333;
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
            font-weight: bold;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .success { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da; 
            color: #721c24; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 16px;
        }
        
        .no-data p {
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .filter-box form {
                flex-direction: column;
            }
            
            .filter-box .form-group {
                width: 100%;
            }
            
            table {
                font-size: 12px;
            }
            
            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
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

    <!-- Success Message -->
    @if(session('success'))
        <div class="success">
            ✓ {{ session('success') }}
        </div>
    @endif
    
    <!-- Error Message -->
    @if(session('error'))
        <div class="error">
            ✗ {{ session('error') }}
        </div>
    @endif

    <h1 style="margin-bottom: 20px;">All Bookings</h1>

    <!-- Date Filter Box -->
    <div class="filter-box">
        <h3>🔍 Filter Bookings by Date</h3>
        <form method="GET" action="/admin/bookings">
            <div class="form-group">
                <label>From Date</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}">
            </div>
            
            <div class="form-group">
                <label>To Date</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}">
            </div>
            
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn">Apply Filter</button>
                <a href="/admin/bookings"><button type="button" class="btn btn-clear">Clear Filter</button></a>
            </div>
        </form>
    </div>

    <!-- Bookings Table -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Guest Name</th>
                <th>Email</th>
                <th>Room</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Guests</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>{{ $booking->user_name }}</td>
                <td>{{ $booking->email }}</td>
                <td>Room {{ $booking->room_number }}</td>
                <td>{{ date('M d, Y', strtotime($booking->check_in)) }}</td>
                <td>{{ date('M d, Y', strtotime($booking->check_out)) }}</td>
                <td>{{ $booking->number_of_people }} {{ $booking->number_of_people > 1 ? 'People' : 'Person' }}</td>
                <td>${{ number_format($booking->total_price, 2) }}</td>
                <td>
                    <a href="/admin/cancel-booking/{{ $booking->id }}" 
                       class="btn-cancel"
                       onclick="return confirm('Are you sure you want to cancel this booking?\n\nGuest: {{ $booking->user_name }}\nRoom: {{ $booking->room_number }}\n\nThis action cannot be undone.')">
                        Cancel Booking
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="no-data">
                    <p><strong>📋 No Bookings Found</strong></p>
                    <p style="color: #999;">There are no bookings in the system yet.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($bookings->count() > 0)
    <div style="margin-top: 20px; padding: 15px; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <strong>Total Bookings:</strong> {{ $bookings->count() }}
        @if(request('from_date') || request('to_date'))
            <span style="color: #666; margin-left: 20px;">
                (Filtered 
                @if(request('from_date'))
                    from {{ date('M d, Y', strtotime(request('from_date'))) }}
                @endif
                @if(request('to_date'))
                    to {{ date('M d, Y', strtotime(request('to_date'))) }}
                @endif
                )
            </span>
        @endif
    </div>
    @endif

</body>
</html>