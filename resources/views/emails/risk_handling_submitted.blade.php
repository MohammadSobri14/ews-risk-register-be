<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Efektivitas Penanganan Risiko</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        h1 {
            color: #2c3e50;
        }
        .label {
            font-weight: bold;
            margin-top: 15px;
        }
        .value {
            margin-bottom: 10px;
        }
        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            color: white;
        }
        .TE { background-color: #27ae60; }
        .KE { background-color: #f39c12; }
        .E  { background-color: #e74c3c; }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Efektivitas Penanganan Risiko</h1>

        <p>Data efektivitas penanganan risiko telah diinput oleh:</p>

        <div class="label">Nama Petugas:</div>
          <div class="value">
          {{ $handling->handledBy->name ?? 'Tidak diketahui' }}
          </div>

          <div class="label">Role Petugas:</div>
          <div class="value">
          {{ $handling->handledBy->role ?? '-' }}
          </div>


        <div class="label">Efektivitas:</div>
        <div class="value">
            <span class="badge {{ $handling->effectiveness }}">
                {{ $handling->effectiveness }}
            </span>
        </div>

        <div class="label">Waktu Input:</div>
        <div class="value">{{ $handling->created_at->format('d M Y, H:i') }}</div>

        <div class="footer">
            Email ini dikirim secara otomatis oleh sistem EWS-Risk. Mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
