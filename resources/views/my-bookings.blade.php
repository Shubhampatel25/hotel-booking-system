<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .header nav a { margin: 0 15px; text-decoration: none; color: #333; }
        .logout-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        
        .bookings-container { display: grid; gap: 20px; }
        
        .booking-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: grid;
            grid-template-columns: 200px 1fr auto;
            gap: 20px;
        }
        
        .booking-image {
            width: 200px;
            height: 150px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 60px;
        }
        
        .booking-details { padding: 20px 0; }
        
        .booking-details h3 { margin-bottom: 10px; color: #333; }
        
        .booking-details p { margin: 5px 0; color: #666; }
        
        .booking-price {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #f8f9fa;
            min-width: 150px;
        }
        
        .booking-price .amount {
            font-size: 28px;
            font-weight: bold;
            color: #003580;
            margin-bottom: 5px;
        }
        
        .booking-price .label { font-size: 14px; color: #666; }
        
        .no-bookings {
            background: white;
            padding: 60px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .btn {
            background: #003580;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 20px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .booking-card { grid-template-columns: 1fr; }
            .booking-image { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>My Bookings</h1>
        <nav>
            <a href="/rooms">Browse Rooms</a>
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </nav>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(count($bookings) > 0)
    <div class="bookings-container">
        @foreach($bookings as $booking)
        <div class="booking-card">
            <div class="booking-image">🛏️</div>
            
            <div class="booking-details">
                <h3>Room {{ $booking->room_number }}</h3>
                <p><strong>📅 Check-in:</strong> {{ date('M d, Y', strtotime($booking->check_in)) }}</p>
                <p><strong>📅 Check-out:</strong> {{ date('M d, Y', strtotime($booking->check_out)) }}</p>
                <p><strong>👥 Guests:</strong> {{ $booking->number_of_people }} {{ $booking->number_of_people > 1 ? 'People' : 'Person' }}</p>
                <p><strong>🌙 Nights:</strong> 
                    @php
                        $nights = (strtotime($booking->check_out) - strtotime($booking->check_in)) / (60*60*24);
                        echo $nights . ' ' . ($nights > 1 ? 'Nights' : 'Night');
                    @endphp
                </p>
                <p><strong>💵 Price per Night:</strong> ${{ $booking->price }}</p>
            </div>
            
            <div class="booking-price">
                <div class="amount">${{ number_format($booking->total_price, 2) }}</div>
                <div class="label">Total Paid</div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-bookings">
        <h2>📋 No Bookings Yet</h2>
        <p style="margin: 15px 0; color: #666;">You haven't made any bookings. Start exploring our rooms!</p>
        <a href="/rooms" class="btn">Browse Available Rooms</a>
    </div>
    @endif
</body>
</html>