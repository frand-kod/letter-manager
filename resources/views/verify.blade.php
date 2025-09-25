<h2>Verifikasi Surat</h2>
<p>Nomor: {{ $doc->number }}</p>
<p>Judul: {{ $doc->title }}</p>
<p>Status: {{ $doc->status }}</p>
<p>Upload: {{ $doc->uploaded_at }}</p>
<a href="{{ asset('storage/surat/'.$doc->filename) }}" target="_blank">Download Surat</a>
<img src="{{ asset('storage/qrcodes/' . basename($doc->qr_code)) }}" alt="QR Code">
