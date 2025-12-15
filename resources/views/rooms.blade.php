<!DOCTYPE html>
<html>
<head>
    <title>Available Rooms</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        
        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header nav a { margin: 0 15px; text-decoration: none; color: #333; }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .room-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .room-card:hover { transform: translateY(-5px); }
        
        .room-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
        }
        
        .room-content { padding: 20px; }
        
        .room-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .room-price {
            font-size: 24px;
            color: #333;
            margin: 15px 0;
        }
        
        .book-btn {
            width: 100%;
            background: #003580;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
        }
        
        .book-btn:hover { background: #002760; }
        .book-btn:disabled { background: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏨 EasyStay Hotel</h1>
        <nav>
            <a href="/rooms">Rooms</a>
            <a href="/my-bookings">My Bookings</a>
            <form method="POST" action="/logout" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </nav>
    </div>

    <div class="container">
        <h2 style="font-size: 28px; margin-bottom: 10px;">Available Rooms</h2>
        <p style="color: #666;">Choose your perfect room</p>

        <div class="rooms-grid">
            @forelse($rooms as $room)
            <div class="room-card">
                <div class="room-image">🛏️</div>
                
                <div class="room-content">
                    <div class="room-title">Room {{ $room->room_number }}</div>
                    
                    <div class="room-price">
                        Book From <strong>${{ $room->price }}</strong>/night
                    </div>
                    
                    @if($room->status == 'available')
                        <a href="/booking/{{ $room->id }}" class="book-btn">Book Now</a>
                    @else
                        <button class="book-btn" disabled>Not Available</button>
                    @endif
                </div>
            </div>
            @empty
            <p>No rooms available at the moment.</p>
            @endforelse
        </div>
    </div>
</body>
</html>