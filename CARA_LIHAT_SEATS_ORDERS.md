# 🎯 Cara Melihat Seats dan Orders di Web Interface

## 🚀 Akses Web Interface

1. **Start Server**
   ```bash
   php artisan serve
   ```

2. **Buka Browser**
   ```
   http://localhost:8000
   ```

## 📋 **Menu Navigasi**

Sekarang ada **navbar dengan menu lengkap**:

### 🎬 **Menu Utama:**
- **Movies** - Daftar film
- **Cities** - Daftar kota  
- **Cinemas** - Daftar bioskop
- **Studios** - Daftar studio
- **Promos** - Daftar promo
- **Tickets** - Daftar jadwal tayang ⭐
- **Seats** - Manajemen kursi ⭐ **BARU**
- **Orders** - Manajemen pesanan ⭐ **BARU**

## 🪑 **Halaman Seats**

### 1. **Seats Index** (`/seats`)
**Fitur:**
- ✅ **Filter by Ticket** - Lihat kursi per jadwal
- ✅ **Filter by Status** - Available/Booked
- ✅ **Stats Cards** - Total, Available, Booked
- ✅ **Table View** - Detail lengkap setiap kursi
- ✅ **Pagination** - Navigasi halaman

**Informasi yang ditampilkan:**
- Seat Number (A1, A2, dll)
- Movie Title
- Cinema Name  
- Date & Time
- Status (Available/Booked)
- Booked By (nama customer)
- Payment Status

### 2. **Seat Details** (`/seats/{id}`)
**Fitur:**
- ✅ **Seat Information** - ID, Number, Status
- ✅ **Ticket Information** - Movie, Cinema, Date, Time, Price
- ✅ **Order Information** - Customer details, payment status
- ✅ **Quick Actions** - View all seats, view ticket

### 3. **Seats by Ticket** (`/seats/ticket/{ticketId}`)
**Fitur:**
- ✅ **Show Information** - Movie, Cinema, Date, Time
- ✅ **Visual Seat Map** - Layout kursi seperti bioskop
- ✅ **Color Coding** - Hijau (Available), Merah (Booked)
- ✅ **Stats Summary** - Total, Available, Booked
- ✅ **Detailed Table** - List lengkap dengan customer info

## 📋 **Halaman Orders**

### 1. **Orders Index** (`/orders`)
**Fitur:**
- ✅ **Filter by User** - Lihat pesanan per customer
- ✅ **Filter by Payment** - Pending/Paid/Cancelled
- ✅ **Stats Cards** - Total, Pending, Paid, Cancelled
- ✅ **Table View** - Detail lengkap setiap order
- ✅ **Quick Actions** - View, Cancel

**Informasi yang ditampilkan:**
- Order ID
- Customer (nama + email)
- Movie Title
- Cinema Name
- Seat Number
- Date & Time
- Price
- Payment Status
- Created Date

### 2. **Order Details** (`/orders/{id}`)
**Fitur:**
- ✅ **Order Information** - ID, Customer, Seat, Payment
- ✅ **Show Information** - Movie, Cinema, Date, Time, Price
- ✅ **Update Payment** - Change status (Pending/Paid/Cancelled)
- ✅ **Quick Actions** - View seat, Cancel order

## 🎮 **Flow Penggunaan**

### **Scenario 1: Cek Ketersediaan Kursi**
1. Klik **"Seats"** di navbar
2. Filter by **Ticket** → Pilih jadwal yang diinginkan
3. Lihat kursi yang **Available** (hijau) vs **Booked** (merah)
4. Klik **"View All"** untuk melihat seat map visual

### **Scenario 2: Lihat Detail Pesanan**
1. Klik **"Orders"** di navbar
2. Filter by **User** atau **Payment Status**
3. Klik **"View"** pada order yang diinginkan
4. Lihat detail lengkap + update payment status

### **Scenario 3: Monitor Seat Map**
1. Klik **"Seats"** → **"View All"** pada ticket tertentu
2. Lihat **visual seat map** seperti layout bioskop
3. Kursi hijau = tersedia, merah = sudah dipesan
4. Klik kursi untuk lihat detail

### **Scenario 4: Manage Payment**
1. Dari **Orders** → Klik **"View"** order
2. Update **Payment Status** dari dropdown
3. Klik **"Update"** untuk simpan
4. Jika **Cancel** → kursi otomatis jadi available lagi

## 📊 **Dashboard Features**

### **Stats Cards:**
- **Seats Page**: Total Seats, Available, Booked
- **Orders Page**: Total Orders, Pending, Paid, Cancelled

### **Filtering:**
- **Seats**: By Ticket, By Status
- **Orders**: By User, By Payment Status

### **Visual Elements:**
- **Badges** untuk status (Available/Booked, Pending/Paid/Cancelled)
- **Color coding** konsisten
- **Responsive design** untuk mobile

## 🔧 **Admin Actions**

### **Dari Seats:**
- View seat details
- View all seats for a show
- Navigate to related order

### **Dari Orders:**
- Update payment status
- Cancel pending orders
- View seat details
- Navigate to seat map

## 📱 **Responsive Design**

Interface sudah **responsive** dengan:
- ✅ **Mobile sidebar** (hamburger menu)
- ✅ **Responsive tables** (horizontal scroll)
- ✅ **Bootstrap 5** styling
- ✅ **Card layouts** untuk mobile

## 🎯 **Quick Access URLs**

```
http://localhost:8000/seats              # All seats
http://localhost:8000/seats/1            # Seat detail
http://localhost:8000/seats/ticket/1     # Seats for ticket #1
http://localhost:8000/orders             # All orders  
http://localhost:8000/orders/1           # Order detail
```

## 🔄 **Real-time Updates**

Ketika ada perubahan:
- ✅ **Cancel order** → Seat otomatis jadi available
- ✅ **Update payment** → Status langsung berubah
- ✅ **Seat status** → Sinkron dengan order status

Sekarang Anda punya **interface web lengkap** untuk melihat dan mengelola seats & orders! 🎉
