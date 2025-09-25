<h2>Upload Surat</h2>
@if(session('success'))<p>{{ session('success') }}</p>@endif
<form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Nomor Surat:</label>
    <input type="text" name="number" required><br>
    <label>Judul Surat:</label>
    <input type="text" name="title" required><br>
    <label>File PDF/Image:</label>
    <input type="file" name="document" required><br>
    <button type="submit">Upload & Generate QR</button>
</form>
<br><a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
