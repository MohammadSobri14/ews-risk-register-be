<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Validasi Risiko</title>
</head>
<body>
    <p>Risiko <strong>{{ $risk->name }}</strong> telah 
        {{ $isApproved ? 'disetujui' : 'ditolak' }} oleh Koordinator Manajemen Risiko.</p>

    @if(!$isApproved && $notes)
        <p><strong>Catatan Penolakan:</strong> {{ $notes }}</p>
    @endif

    <p>
        <a href="{{ url('/risks/' . $risk->id) }}">Klik di sini untuk melihat detail risiko</a>
    </p>
</body>
</html>
