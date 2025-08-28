<!-- resources/views/cities/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Pilih Kota</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h1 class="text-xl font-bold mb-4">Pilih Kota</h1>

        <form method="POST" action="{{ route('cities.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2">Tambah Kota Baru</label>
                <input type="text" name="name" placeholder="Nama Kota"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Simpan Kota
            </button>
        </form>

        <hr class="my-6">

        <label class="block text-sm font-medium mb-2">Pilih Kota yang Tersedia</label>
        <select class="w-full border rounded px-3 py-2">
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
    </div>

</body>
</html>
