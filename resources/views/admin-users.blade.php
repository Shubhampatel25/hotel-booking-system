<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .nav { background: #333; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; }
        .logout-btn { background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        
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
        
        .btn-view { 
            background: #28a745; 
            color: white; 
            padding: 8px 15px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px; 
            margin-right: 5px;
        }
        
        .btn-delete { 
            background: #dc3545; 
            color: white; 
            padding: 8px 15px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px; 
        }
        
        .success { 
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .stats {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
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

    @if(session('success'))
        <div class="success">✓ {{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="error">✗ {{ session('error') }}</div>
    @endif

    <h1>Manage Users</h1>

    <div class="stats">
        <strong>Total Registered Users:</strong> {{ $users->count() }}
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>#{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ date('M d, Y', strtotime($user->created_at)) }}</td>
                <td>
                    <a href="/admin/user-details/{{ $user->id }}" class="btn-view">
                        View Details
                    </a>
                    <a href="/admin/delete-user/{{ $user->id }}" 
                       class="btn-delete"
                       onclick="return confirm('Are you sure you want to delete this user?\n\nUser: {{ $user->name }}\n\nThis action cannot be undone.')">
                        Delete
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px;">
                    <p><strong>No users registered yet</strong></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>