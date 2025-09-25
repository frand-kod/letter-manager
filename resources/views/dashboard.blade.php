<h2>Dashboard Surat</h2>

{{-- @php var_dump($document); @endphp --}}

@if(session('success'))<p>{{ session('success') }}</p>@endif
<a href="{{ route('upload.form') }}">Upload Surat Baru</a>
<table border="1" cellpadding="5">
<thead>
<tr>
<th>No</th><th>Nomor</th><th>Judul</th><th>Tanggal</th><th>Status</th><th>QR</th><th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($document as $doc)
<tr>
<td>{{ $loop->iteration }}</td>
<td>{{ $doc->number }}</td>
<td>{{ $doc->title }}</td>
<td>{{ $doc->uploaded_at }}</td>
<td>{{ $doc->status }}</td>
<td><img src="{{ asset('storage/qrcodes/' . basename($doc->qr_code)) }}" width="50"></td>
<td>
<a href="{{ route('documents.show', $doc->id) }}">Detail</a> |
<form action="{{ route('documents.revoke', $doc->id) }}" method="POST" style="display:inline;">
@csrf
<button type="submit">Revoke</button>
</form>
<form action="{{ route('documents.unrevoke', $doc->id) }}" method="POST" style="display:inline;">
@csrf
<button type="submit">unrevoke</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
