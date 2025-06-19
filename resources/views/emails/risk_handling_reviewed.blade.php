<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Review Penanganan Risiko</title>
</head>
<body>
    <h2>Hasil Review Laporan Penanganan Risiko</h2>
    <p><strong>Oleh:</strong> {{ $handling->reviewer->name ?? 'Tidak diketahui' }}</p>
    <p><strong>Status:</strong> {{ $handling->is_approved ? 'Disetujui' : 'Ditolak' }}</p>
    @if(!$handling->is_approved)
        <p><strong>Catatan:</strong> {{ $handling->review_notes ?? '-' }}</p>
    @endif
    <p><strong>Petugas:</strong> {{ $handling->handledBy->name ?? 'Tidak diketahui' }}</p>
    <p><strong>Waktu Penanganan:</strong> {{ $handling->created_at->format('d M Y, H:i') }}</p>
    <p>Email ini dikirim otomatis oleh sistem EWS-Risk.</p>
</body>
</html>
