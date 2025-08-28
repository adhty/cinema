# Cinema Booking Backend Setup

## Overview
Backend API untuk sistem pemesanan tiket bioskop dengan fitur:
- Manajemen user dengan data lengkap (name, phone, email, gender, birthdate, pin)
- Sistem kursi per jadwal dengan status available/booked
- Pemesanan tiket dengan hubungan user-seat-order

## Database Schema

### Users Table
- id (PK)
- name
- phone
- email (unique)
- gender (male/female)
- birthdate
- pin (6 digits)
- password
- is_admin
- timestamps

### Seats Table
- id (PK)
- ticket_id (FK to tickets)
- number (seat number: A1, A2, etc.)
- status (available/booked)
- timestamps
- unique(ticket_id, number)

### Orders Table
- id (PK)
- user_id (FK to users)
- seat_id (FK to seats)
- payment (pending/paid/cancelled)
- timestamps
- unique(seat_id) - one seat can only have one active order

## Setup Instructions

### 1. Database Configuration
Pastikan database MySQL sudah running dan update file `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cinema
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Run Migrations
```bash
php artisan migrate
```

### 5. Seed Test Data (Optional)
```bash
php artisan db:seed --class=TestDataSeeder
```

Ini akan membuat:
- 2 test users (john@example.com, jane@example.com)
- 1 city (Jakarta)
- 1 cinema (CGV Grand Indonesia)
- 1 studio
- 1 movie (Avengers: Endgame)
- 2 tickets/schedules (14:00 & 17:00)
- 15 seats per schedule (A1-A5, B1-B5, C1-C5)

### 6. Start Server
```bash
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

## API Endpoints

### Orders API
- `GET /api/orders?user_id={id}` - Get user orders
- `POST /api/orders` - Create new order
- `GET /api/orders/{id}` - Get order details
- `PUT /api/orders/{id}/payment` - Update payment status
- `PUT /api/orders/{id}/cancel` - Cancel order

### Seats API
- `GET /api/seats/available?ticket_id={id}` - Get available seats
- `GET /api/seats/ticket/{ticketId}` - Get all seats for ticket
- `GET /api/seats/{seatId}` - Get seat details

## Testing

### Using Postman
1. Import file `Cinema_API_Tests.postman_collection.json`
2. Set variable `base_url` to `http://localhost:8000`
3. Run the requests

### Manual Testing Flow
1. **Get available seats**: `GET /api/seats/available?ticket_id=1`
2. **Create order**: `POST /api/orders` with user_id=1 and seat_id from step 1
3. **Check order**: `GET /api/orders?user_id=1`
4. **Update payment**: `PUT /api/orders/{id}/payment` with payment_status="paid"

## Key Features

### Seat Management
- Seats are automatically marked as booked when order is created
- Seats become available again when order is cancelled
- Unique constraint prevents double booking

### Order Management
- Orders track user, seat, and payment status
- Automatic seat status updates
- Payment status tracking (pending/paid/cancelled)

### Data Relationships
- User hasMany Orders
- Seat hasOne Order (active)
- Order belongsTo User and Seat
- Ticket hasMany Seats

## Error Handling
- Validation errors for required fields
- Business logic errors (seat not available, etc.)
- Database transaction rollback on errors
- Consistent JSON error responses

## Security Considerations
- Input validation on all endpoints
- Database transactions for data consistency
- Proper error messages without sensitive data exposure

## Next Steps
- Add authentication middleware
- Add rate limiting
- Add logging for audit trail
- Add payment gateway integration
- Add email notifications
