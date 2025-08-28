# Cara Membuat Tickets, Seats, dan Orders

## 🎯 Data yang Sudah Dibuat

Setelah menjalankan seeder, Anda sudah memiliki:

### 👥 Users
- **John Doe** (john@example.com) - password: password
- **Jane Smith** (jane@example.com) - password: password

### 🏢 Cinema Data
- **City**: Jakarta
- **Cinema**: CGV Grand Indonesia
- **Studio**: Studio 1
- **Movie**: Avengers: Endgame

### 🎫 Tickets (Jadwal Tayang)
- **Ticket 1**: 2024-12-25 14:00 - Rp 50,000
- **Ticket 2**: 2024-12-25 17:00 - Rp 60,000

### 💺 Seats
Setiap ticket memiliki 15 kursi:
- **Baris A**: A1, A2, A3, A4, A5
- **Baris B**: B1, B2, B3, B4, B5  
- **Baris C**: C1, C2, C3, C4, C5

### 📋 Orders (Sample)
- John Doe: A5 (paid), B1 (pending)
- Jane Smith: B2 (paid), B3 (pending)

## 🚀 Cara Menjalankan Seeder

### 1. Setup Database
```bash
# Jalankan migration
php artisan migrate:fresh

# Jalankan seeder utama
php artisan db:seed --class=TestDataSeeder

# Jalankan seeder sample orders
php artisan db:seed --class=SampleOrdersSeeder
```

### 2. Atau Jalankan Semua Sekaligus
```bash
php artisan migrate:fresh --seed
```

## 📡 Testing API dengan Data yang Ada

### 1. Lihat Kursi Tersedia
```
GET /api/seats/available?ticket_id=1
```
Response: Kursi yang masih available untuk jadwal 14:00

### 2. Lihat Semua Kursi
```
GET /api/seats/ticket/1
```
Response: Semua kursi untuk jadwal 14:00 (available + booked)

### 3. Lihat Orders User
```
GET /api/orders?user_id=1
```
Response: Semua orders milik John Doe

### 4. Buat Order Baru
```
POST /api/orders
Body: {
  "user_id": 1,
  "seat_id": 3
}
```
Response: Order baru untuk John Doe di kursi A3

### 5. Update Payment
```
PUT /api/orders/1/payment
Body: {
  "payment_status": "paid"
}
```

## 🔧 Cara Membuat Data Manual

### 1. Buat Ticket Baru
```php
use App\Models\Ticket;

$ticket = Ticket::create([
    'movie_id' => 1,
    'studio_id' => 1, 
    'city_id' => 1,
    'cinema_id' => 1,
    'date' => '2024-12-26',
    'time' => '19:00:00',
    'price' => 70000
]);
```

### 2. Buat Seats untuk Ticket
```php
use App\Models\Seats;

$seatNumbers = ['A1', 'A2', 'A3', 'B1', 'B2', 'B3'];

foreach ($seatNumbers as $number) {
    Seats::create([
        'ticket_id' => $ticket->id,
        'number' => $number,
        'status' => 'available'
    ]);
}
```

### 3. Buat Order
```php
use App\Models\Order;

$order = Order::create([
    'user_id' => 1,
    'seat_id' => 1,
    'payment' => 'pending'
]);

// Mark seat as booked
$seat = Seats::find(1);
$seat->markAsBooked();
```

## 🎮 Testing Flow Lengkap

### Scenario: User Pesan Tiket

1. **User pilih jadwal**
   ```
   GET /api/seats/available?ticket_id=1
   ```

2. **User lihat kursi tersedia**
   - Response menampilkan kursi A1, A2, A3, A4, B4, B5, C1-C5 (yang belum di-book)

3. **User pilih kursi A1**
   ```
   POST /api/orders
   {
     "user_id": 2,
     "seat_id": 1
   }
   ```

4. **Sistem buat order dan mark seat sebagai booked**
   - Order dibuat dengan status "pending"
   - Seat A1 status berubah jadi "booked"

5. **User bayar**
   ```
   PUT /api/orders/{order_id}/payment
   {
     "payment_status": "paid"
   }
   ```

6. **Cek hasil**
   ```
   GET /api/orders?user_id=2
   ```

## 📊 Data IDs untuk Testing

### User IDs
- John Doe: `user_id = 1`
- Jane Smith: `user_id = 2`

### Ticket IDs
- Jadwal 14:00: `ticket_id = 1`
- Jadwal 17:00: `ticket_id = 2`

### Seat IDs (untuk ticket_id = 1)
- A1: `seat_id = 1`
- A2: `seat_id = 2`
- A3: `seat_id = 3`
- A4: `seat_id = 4`
- A5: `seat_id = 5` (sudah di-book John)
- B1: `seat_id = 6` (sudah di-book John)
- B2: `seat_id = 7` (sudah di-book Jane)
- B3: `seat_id = 8` (sudah di-book Jane)
- B4: `seat_id = 9` (available)
- B5: `seat_id = 10` (available)
- C1-C5: `seat_id = 11-15` (available)

## 🔄 Reset Data
```bash
# Reset semua data
php artisan migrate:fresh

# Buat ulang data testing
php artisan db:seed --class=TestDataSeeder
php artisan db:seed --class=SampleOrdersSeeder
```

Sekarang Anda bisa mulai testing API dengan data yang sudah tersedia! 🎉
