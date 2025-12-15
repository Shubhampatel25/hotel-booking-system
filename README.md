# 🏨 EasyStay Hotel Booking System

A complete hotel room booking system built with Laravel.

## Features

### User Features
- ✅ User registration and login
- ✅ Browse available rooms
- ✅ Book rooms with date selection
- ✅ Real-time price calculation
- ✅ View booking history
- ✅ Select number of guests

### Admin Features
- ✅ Separate admin login
- ✅ Admin dashboard with statistics
- ✅ Add, edit, delete rooms
- ✅ Update room prices
- ✅ View all bookings
- ✅ Filter bookings by date
- ✅ Cancel bookings

## Technology Stack

- Laravel 9+
- PHP 8+
- MySQL
- HTML/CSS
- JavaScript

## Installation

### 1. Clone Repository
```bash
git clone https://github.com/Shubhampatel25/hotel-booking.git
cd hotel-booking
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
- Create database named `hotel`
- Import `database.sql` file
- Update `.env` with your database credentials

### 5. Run Application
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Default Login Credentials

**Admin:**
- Email: admin@hotel.com
- Password: 12345

**Guest:**
- Register a new account

## Database Structure

- **users** - Stores user accounts
- **rooms** - Stores room information
- **bookings** - Stores all reservations

## Screenshots

(Add screenshots here)

## License

Open source - free to use

## Author

Shubham Patel