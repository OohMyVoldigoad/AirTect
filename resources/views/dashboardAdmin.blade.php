<!DOCTYPE html>
<html>
<head>
    <title>Create Saran</title>
</head>
<body>
    <h2>Create Saran</h2>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div>{{ session('error') }}</div>
    @endif
    <form action="{{ route('sarans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="saran">Saran:</label>
            <textarea name="saran" id="saran" required></textarea>
        </div>
        <div>
            <label for="gambar">Gambar:</label>
            <input type="file" name="gambar" id="gambar" required>
        </div>
        <div>
            <label for="tipe">Tipe:</label>
            <select name="tipe" id="tipe" required>
                <option value="sehat">Sehat</option>
                <option value="hati-hati">Hati-hati</option>
                <option value="danger">Danger</option>
            </select>
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
