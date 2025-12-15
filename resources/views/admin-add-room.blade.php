<!DOCTYPE html>
<html>
<head>
    <title>Add New Room</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; }
        .card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        .btn { background: blue; color: white; padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; }
        .btn-secondary { background: #6c757d; margin-left: 10px; }
        a { text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="/admin/rooms">← Back to Rooms</a>
        
        <div class="card" style="margin-top: 20px;">
            <h2>Add New Room</h2>
            
            <form method="POST" action="/admin/add-room">
                @csrf
                
                <div class="form-group">
                    <label>Room Number</label>
                    <input type="text" name="room_number" placeholder="e.g., 106" required>
                </div>
                
                <div class="form-group">
                    <label>Price per Night ($)</label>
                    <input type="number" name="price" placeholder="e.g., 75.00" step="0.01" required>
                </div>
                
                <button type="submit" class="btn">Add Room</button>
                <a href="/admin/rooms"><button type="button" class="btn btn-secondary">Cancel</button></a>
            </form>
        </div>
    </div>
</body>
</html>