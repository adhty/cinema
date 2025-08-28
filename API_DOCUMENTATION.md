# Cinema Booking API Documentation

## Overview
Backend API untuk sistem pemesanan tiket bioskop dengan hubungan antara Users, Seats, dan Orders.

## Database Structure
- **Users**: Menyimpan data pengguna (name, phone, email, gender, birthdate, pin)
- **Seats**: Menyimpan data kursi per jadwal/ticket (ticket_id, number, status)
- **Orders**: Menyimpan data pemesanan (user_id, seat_id, payment)

## API Endpoints

### 1. Orders API

#### GET /api/orders
Mendapatkan daftar pesanan berdasarkan user_id
```
Query Parameters:
- user_id (required): ID pengguna

Response:
{
  "success": true,
  "message": "Orders retrieved successfully",
  "data": [
    {
      "id": 1,
      "seat_number": "A1",
      "movie_title": "Avengers: Endgame",
      "cinema_name": "CGV Grand Indonesia",
      "studio_name": "Studio 1",
      "show_date": "2024-12-25",
      "show_time": "14:00:00",
      "price": 50000,
      "payment_status": "pending",
      "created_at": "2024-08-27 14:30:00"
    }
  ]
}
```

#### POST /api/orders
Membuat pesanan baru
```
Body:
{
  "user_id": 1,
  "seat_id": 5
}

Response:
{
  "success": true,
  "message": "Order created successfully",
  "data": {
    "order_id": 1,
    "user_name": "John Doe",
    "seat_number": "A1",
    "movie_title": "Avengers: Endgame",
    "cinema_name": "CGV Grand Indonesia",
    "studio_name": "Studio 1",
    "show_date": "2024-12-25",
    "show_time": "14:00:00",
    "price": 50000,
    "payment_status": "pending",
    "created_at": "2024-08-27 14:30:00"
  }
}
```

#### GET /api/orders/{id}
Mendapatkan detail pesanan
```
Response:
{
  "success": true,
  "message": "Order retrieved successfully",
  "data": {
    "order_id": 1,
    "user_name": "John Doe",
    "user_email": "john@example.com",
    "user_phone": "081234567890",
    "seat_number": "A1",
    "movie_title": "Avengers: Endgame",
    "cinema_name": "CGV Grand Indonesia",
    "studio_name": "Studio 1",
    "show_date": "2024-12-25",
    "show_time": "14:00:00",
    "price": 50000,
    "payment_status": "pending",
    "created_at": "2024-08-27 14:30:00"
  }
}
```

#### PUT /api/orders/{id}/payment
Update status pembayaran
```
Body:
{
  "payment_status": "paid"
}

Response:
{
  "success": true,
  "message": "Payment status updated successfully",
  "data": {
    "order_id": 1,
    "payment_status": "paid"
  }
}
```

#### PUT /api/orders/{id}/cancel
Membatalkan pesanan
```
Response:
{
  "success": true,
  "message": "Order cancelled successfully"
}
```

### 2. Seats API

#### GET /api/seats/available
Mendapatkan kursi yang tersedia berdasarkan jadwal
```
Query Parameters:
- ticket_id (required): ID tiket/jadwal

Response:
{
  "success": true,
  "message": "Seats retrieved successfully",
  "data": {
    "ticket_info": {
      "ticket_id": 1,
      "movie_title": "Avengers: Endgame",
      "cinema_name": "CGV Grand Indonesia",
      "studio_name": "Studio 1",
      "city_name": "Jakarta",
      "show_date": "2024-12-25",
      "show_time": "14:00:00",
      "price": 50000
    },
    "seats": {
      "available": [
        {
          "seat_id": 1,
          "seat_number": "A1",
          "status": "available",
          "is_available": true,
          "is_booked": false
        }
      ],
      "booked": [],
      "total_seats": 15,
      "available_count": 15,
      "booked_count": 0
    }
  }
}
```

#### GET /api/seats/ticket/{ticketId}
Mendapatkan semua kursi untuk jadwal tertentu
```
Response:
{
  "success": true,
  "message": "All seats retrieved successfully",
  "data": {
    "ticket_info": {
      "ticket_id": 1,
      "movie_title": "Avengers: Endgame",
      "cinema_name": "CGV Grand Indonesia",
      "studio_name": "Studio 1",
      "city_name": "Jakarta",
      "show_date": "2024-12-25",
      "show_time": "14:00:00",
      "price": 50000
    },
    "seats": [
      {
        "seat_id": 1,
        "seat_number": "A1",
        "status": "available",
        "is_available": true
      },
      {
        "seat_id": 2,
        "seat_number": "A2",
        "status": "booked",
        "is_available": false,
        "order_info": {
          "order_id": 1,
          "user_name": "John Doe",
          "payment_status": "pending",
          "booked_at": "2024-08-27 14:30:00"
        }
      }
    ]
  }
}
```

#### GET /api/seats/{seatId}
Mendapatkan detail kursi tertentu
```
Response:
{
  "success": true,
  "message": "Seat details retrieved successfully",
  "data": {
    "seat_id": 1,
    "seat_number": "A1",
    "status": "available",
    "is_available": true,
    "ticket_info": {
      "ticket_id": 1,
      "movie_title": "Avengers: Endgame",
      "cinema_name": "CGV Grand Indonesia",
      "studio_name": "Studio 1",
      "city_name": "Jakarta",
      "show_date": "2024-12-25",
      "show_time": "14:00:00",
      "price": 50000
    }
  }
}
```

## Flow Pemesanan

1. **User memilih jadwal**: Frontend menampilkan daftar jadwal film
2. **Lihat kursi tersedia**: `GET /api/seats/available?ticket_id={ticket_id}`
3. **User pilih kursi**: User memilih nomor kursi dari daftar yang tersedia
4. **Buat pesanan**: `POST /api/orders` dengan `user_id` dan `seat_id`
5. **Update pembayaran**: `PUT /api/orders/{id}/payment` setelah pembayaran berhasil

## Error Responses

```json
{
  "success": false,
  "message": "Error message here"
}
```

Common HTTP Status Codes:
- 200: Success
- 201: Created
- 400: Bad Request (validation error, seat not available, etc.)
- 404: Not Found
- 500: Internal Server Error

## Setup Instructions

1. Jalankan migration: `php artisan migrate`
2. Jalankan seeder: `php artisan db:seed --class=TestDataSeeder`
3. Start server: `php artisan serve`
4. Test API menggunakan Postman atau tools lainnya
