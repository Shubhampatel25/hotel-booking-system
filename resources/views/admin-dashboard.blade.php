<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .nav { background: #333; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .logout-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        .card h2 {
            font-size: 48px;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .card p { color: #666; font-size: 18px; margin-bottom: 20px; }
        
        .card a {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            transition: background 0.2s;
        }
        
        .card a:hover {
            background: #5568d3;
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

    <h1>Admin Dashboard</h1>

    <div class="cards">
        <div class="card">
            <h2>{{ $totalRooms }}</h2>
            <p>Total Rooms</p>
            <a href="/admin/rooms">Manage Rooms</a>
        </div>

        <div class="card">
            <h2>{{ $totalBookings }}</h2>
            <p>Total Bookings</p>
            <a href="/admin/bookings">View Bookings</a>
        </div>

        <div class="card">
            <h2>{{ $totalUsers }}</h2>
            <p>Total Users</p>
            <a href="/admin/users">Manage Users</a>
        </div>
    </div>
</body>
</html>