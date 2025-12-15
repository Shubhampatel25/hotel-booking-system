<!DOCTYPE html>
<html>
<head>
    <title>Book Room</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
        }
        
        .card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        h2 { margin-bottom: 20px; }
        
        .form-group { margin-bottom: 20px; }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .room-info {
            background: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .summary-row.total {
            font-size: 20px;
            font-weight: bold;
            border-top: 2px solid #333;
            margin-top: 10px;
            padding-top: 10px;
        }
        
        .btn {
            width: 100%;
            background: #003580;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
        }
        
        .btn:hover { background: #002760; }
        
        a { color: #003580; text-decoration: none; }

        @media (max-width: 768px) {
            .container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <a href="/rooms">← Back to Rooms</a>
    
    <h1 style="margin: 20px 0;">Complete Your Booking</h1>

    <div class="container">
        <div class="card">
            <h2>Booking Details</h2>
            
            <div class="room-info">
                <h3>Room {{ $room->room_number }}</h3>
                <p><strong>Price:</strong> ${{ $room->price }} per night</p>
                <p><strong>Status:</strong> {{ ucfirst($room->status) }}</p>
            </div>

            <form method="POST" action="/book">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="total_price" id="total_price" value="0">

                <div class="form-group">
                    <label>Check-in Date</label>
                    <input type="date" name="check_in" id="check_in" 
                           min="{{ date('Y-m-d') }}" 
                           required 
                           onchange="calculateTotal()">
                </div>

                <div class="form-group">
                    <label>Check-out Date</label>
                    <input type="date" name="check_out" id="check_out" 
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                           required 
                           onchange="calculateTotal()">
                </div>

                <div class="form-group">
                    <label>Number of People</label>
                    <select name="number_of_people" id="number_of_people" required>
                        <option value="">Select number of guests</option>
                        <option value="1">1 Person</option>
                        <option value="2">2 People</option>
                        <option value="3">3 People</option>
                        <option value="4">4 People</option>
                    </select>
                </div>

                <button type="submit" class="btn">Confirm Booking</button>
            </form>
        </div>

        <div class="card">
            <h2>Reservation Summary</h2>
            
            <div class="summary-row">
                <span>Room {{ $room->room_number }}</span>
                <span>${{ $room->price }}/night</span>
            </div>
            
            <div class="summary-row">
                <span>Number of Nights</span>
                <span id="nights">0</span>
            </div>
            
            <div class="summary-row">
                <span>Room Charges</span>
                <span id="subtotal">$0.00</span>
            </div>
            
            <div class="summary-row">
                <span>Taxes (13.4%)</span>
                <span id="taxes">$0.00</span>
            </div>
            
            <div class="summary-row total">
                <span>Total:</span>
                <span id="total">$0.00</span>
            </div>
        </div>
    </div>

    <script>
        var pricePerNight = parseFloat("{{ $room->price }}");
        
        function calculateTotal() {
            var checkIn = document.getElementById('check_in').value;
            var checkOut = document.getElementById('check_out').value;
            
            if (checkIn && checkOut) {
                var date1 = new Date(checkIn);
                var date2 = new Date(checkOut);
                var diffTime = date2 - date1;
                var nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (nights > 0) {
                    var subtotal = nights * pricePerNight;
                    var taxes = subtotal * 0.134;
                    var total = subtotal + taxes;
                    
                    document.getElementById('nights').textContent = nights;
                    document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
                    document.getElementById('taxes').textContent = '$' + taxes.toFixed(2);
                    document.getElementById('total').textContent = '$' + total.toFixed(2);
                    document.getElementById('total_price').value = total.toFixed(2);
                }
            }
        }
    </script>
</body>
</html>