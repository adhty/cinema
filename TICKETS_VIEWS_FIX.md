# 🎫 Tickets Views Fix - COMPLETED

## ❌ **Error yang Diperbaiki:**
```
View [tickets.create] not found.
View [tickets.edit] not found.
```

## ✅ **Solusi yang Diterapkan:**

### 1. **Created Missing Views**

#### **📄 tickets/create.blade.php**
**Features:**
- ✅ Form untuk membuat ticket baru
- ✅ Dropdown untuk Movie, Cinema, Studio, City
- ✅ Date picker dengan validasi (tidak boleh masa lalu)
- ✅ Time picker dengan suggestion
- ✅ Price input dengan format Rupiah
- ✅ Auto-create seats option (A1-A5, B1-B5, C1-C5)
- ✅ Validation error handling
- ✅ Responsive design

#### **📄 tickets/edit.blade.php**
**Features:**
- ✅ Form untuk edit ticket existing
- ✅ Pre-filled dengan data current
- ✅ Warning jika ada booking existing
- ✅ Seats status summary
- ✅ Validation error handling
- ✅ Link ke seat map jika ada booking

### 2. **Enhanced TicketController**

#### **🔧 Improved Methods:**
```php
// CREATE
public function create()
{
    $movies = Movie::all();
    $studios = Studio::all();
    $cities = City::all();
    $cinemas = Cinema::all();
    return view('tickets.create', compact('movies', 'studios', 'cities', 'cinemas'));
}

// STORE
public function store(Request $request)
{
    // Enhanced validation
    $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'studio_id' => 'required|exists:studios,id',
        'city_id' => 'required|exists:cities,id',
        'cinema_id' => 'required|exists:cinemas,id',
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
        'price' => 'required|numeric|min:0',
    ]);

    $ticket = Ticket::create($request->only([
        'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
    ]));

    // Auto-create seats if requested
    if ($request->has('create_seats')) {
        $this->createSeatsForTicket($ticket);
    }

    return redirect()->route('tickets.index')->with('success', 'Ticket created successfully!');
}

// EDIT
public function edit($id)
{
    $ticket = Ticket::findOrFail($id);
    $movies = Movie::all();
    $studios = Studio::all();
    $cities = City::all();
    $cinemas = Cinema::all();
    return view('tickets.edit', compact('ticket', 'movies', 'studios', 'cities', 'cinemas'));
}

// UPDATE
public function update(Request $request, $id)
{
    // Enhanced validation
    $request->validate([
        'movie_id' => 'required|exists:movies,id',
        'studio_id' => 'required|exists:studios,id',
        'city_id' => 'required|exists:cities,id',
        'cinema_id' => 'required|exists:cinemas,id',
        'date' => 'required|date|after_or_equal:today',
        'time' => 'required',
        'price' => 'required|numeric|min:0',
    ]);

    $ticket = Ticket::findOrFail($id);
    $ticket->update($request->only([
        'movie_id', 'studio_id', 'city_id', 'cinema_id', 'date', 'time', 'price'
    ]));

    return redirect()->route('tickets.show', $id)->with('success', 'Ticket updated successfully!');
}

// DESTROY
public function destroy($id)
{
    $ticket = Ticket::findOrFail($id);
    
    // Check if ticket has any bookings
    $bookedSeats = $ticket->seats()->where('status', 'booked')->count();
    
    if ($bookedSeats > 0) {
        return redirect()->route('tickets.index')
            ->with('error', 'Cannot delete ticket with existing bookings!');
    }

    // Delete all seats first
    $ticket->seats()->delete();
    
    // Delete ticket
    $ticket->delete();

    return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully!');
}

// HELPER METHOD
private function createSeatsForTicket(Ticket $ticket)
{
    $seatNumbers = ['A1', 'A2', 'A3', 'A4', 'A5', 'B1', 'B2', 'B3', 'B4', 'B5', 'C1', 'C2', 'C3', 'C4', 'C5'];
    
    foreach ($seatNumbers as $number) {
        Seats::create([
            'ticket_id' => $ticket->id,
            'number' => $number,
            'status' => 'available'
        ]);
    }
}
```

### 3. **Enhanced Features**

#### **🎯 Form Validation:**
- ✅ Date tidak boleh masa lalu (`after_or_equal:today`)
- ✅ Price minimum 0
- ✅ Required fields validation
- ✅ Foreign key validation (exists)

#### **🪑 Auto Seat Creation:**
- ✅ Checkbox option untuk auto-create seats
- ✅ Default layout: A1-A5, B1-B5, C1-C5 (15 seats)
- ✅ Status default: 'available'

#### **🔒 Safety Features:**
- ✅ Tidak bisa delete ticket yang ada booking
- ✅ Warning saat edit ticket yang ada booking
- ✅ Proper error handling

#### **🎨 UI/UX Improvements:**
- ✅ Responsive form layout
- ✅ Date/time picker
- ✅ Price formatting
- ✅ Success/error messages
- ✅ Navigation breadcrumbs

## 🚀 **Testing Flow**

### **Create New Ticket:**
1. Klik **"+ Add New Ticket"** di tickets index
2. Fill form: Movie, Cinema, Studio, City, Date, Time, Price
3. Check **"Auto-create seats"** (optional)
4. Klik **"Create Ticket"**
5. Redirect ke tickets index dengan success message

### **Edit Existing Ticket:**
1. Dari tickets index, klik **"Edit"** pada ticket
2. Modify fields yang diinginkan
3. Lihat warning jika ada booking existing
4. Klik **"Update Ticket"**
5. Redirect ke ticket detail dengan success message

### **Delete Ticket:**
1. Dari tickets index, klik **"Delete"** pada ticket
2. Confirm deletion
3. Jika ada booking → Error message
4. Jika tidak ada booking → Success deletion

## 🎯 **URLs yang Sekarang Berfungsi:**

```
GET    /tickets                    # List all tickets
GET    /tickets/create             # Create form ✅ FIXED
POST   /tickets                    # Store new ticket
GET    /tickets/{id}               # Show ticket details
GET    /tickets/{id}/edit          # Edit form ✅ FIXED
PUT    /tickets/{id}               # Update ticket
DELETE /tickets/{id}               # Delete ticket
```

## 📱 **Responsive Design**

### **Desktop:**
- ✅ 2-column form layout
- ✅ Full-width dropdowns
- ✅ Inline date/time/price

### **Mobile:**
- ✅ Single-column layout
- ✅ Touch-friendly inputs
- ✅ Proper spacing

## 🎉 **Final Result**

### **✅ Semua Berfungsi:**
1. **tickets.create** - Form create ticket dengan auto-seat creation
2. **tickets.edit** - Form edit dengan warning untuk existing bookings
3. **tickets.show** - Detail ticket dengan seat summary
4. **tickets.index** - List tickets dengan CRUD actions
5. **CRUD Operations** - Create, Read, Update, Delete
6. **Data Validation** - Proper form validation
7. **Safety Features** - Prevent deletion with bookings
8. **Auto Seat Creation** - 15 seats per ticket

**Error `View [tickets.create] not found` sudah SELESAI diperbaiki! 🎊**

Sekarang semua fitur tickets management berfungsi dengan sempurna.
