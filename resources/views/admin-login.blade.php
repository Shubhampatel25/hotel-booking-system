<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 400px;
        }
        h2 { text-align: center; margin-bottom: 10px; }
        .badge {
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: #dc3545;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .link { text-align: center; margin-top: 20px; }
        .link a { color: #dc3545; text-decoration: none; }
    </style>
</head>
<body>
    <div class="box">
        <h2>🔐 Admin Login</h2>
        <span class="badge">ADMIN ONLY</span>
        
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif
        
        <form method="POST" action="/admin/login">
            @csrf
            <input type="email" name="email" placeholder="Admin Email" required>
            <input type="password" name="password" placeholder="Admin Password" required>
            <button type="submit">Login as Admin</button>
        </form>
        <div class="link">
            <a href="/login">← Back to User Login</a>
        </div>
    </div>
</body>
</html>