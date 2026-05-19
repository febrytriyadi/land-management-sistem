     1|<!DOCTYPE html>
     2|<html lang="id">
     3|<head>
     4|    <meta charset="UTF-8">
     5|    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     6|    <title>Tagihan Sewa Tanah</title>
     7|    <style>
     8|        body { font-family: 'Segoe UI', Arial, sans-serif; background: #F5F0E8; margin: 0; padding: 0; }
     9|        .container { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    10|        .header { background: #2D5A27; padding: 32px 40px; text-align: center; }
    11|        .header h1 { color: #F5F0E8; margin: 0; font-size: 22px; }
    12|        .header p { color: #C8D6C0; margin: 8px 0 0; font-size: 14px; }
    13|        .body { padding: 32px 40px; }
    14|        .info-table { width: 100%; border-collapse: collapse; }
    15|        .info-table td { padding: 10px 0; border-bottom: 1px solid #f0ede5; font-size: 14px; }
    16|        .info-table td:first-child { color: #7a7a7a; width: 140px; }
    17|        .info-table td:last-child { font-weight: 600; color: #2D5A27; }
    18|        .amount-box { background: #F5F0E8; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
    19|        .amount-box .label { color: #7a7a7a; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }
    20|        .amount-box .value { font-size: 36px; font-weight: 800; color: #2D5A27; margin: 8px 0; }
    21|        .amount-box .date { color: #b8944e; font-size: 14px; }
    22|        .status-badge { display: inline-block; padding: 4px 16px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    23|        .status-belum_dibayar { background: #FFF3E0; color: #E65100; }
    24|        .status-terlambat { background: #FFEBEE; color: #C62828; }
    25|        .status-lunas { background: #E8F5E9; color: #2E7D32; }
    26|        .footer { padding: 24px 40px; text-align: center; border-top: 1px solid #f0ede5; }
    27|        .footer p { color: #999; font-size: 12px; margin: 4px 0; }
    28|        .btn { display: inline-block; background: #2D5A27; color: white !important; text-decoration: none; padding: 12px 32px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 16px; }
    29|        .btn:hover { background: #1B3D18; }
    30|    </style>
    31|</head>
    32|<body>
    33|    <div class="container">
    34|        <div class="header">
    35|            <h1> PT Inhutani I</h1>
    36|            <p>Sistem Manajemen Sewa Aset Tanah</p>
    37|        </div>
    38|
    39|        <div class="body">
    40|            <p style="font-size:16px; color:#333;">Yth. <strong>{{ $pembayaran->kontrak->penyewa->nama }}</strong>,</p>
    41|            <p style="color:#666; line-height:1.6;">Berikut adalah tagihan sewa tanah untuk periode Anda. Mohon segera lakukan pembayaran sebelum tanggal jatuh tempo.</p>
    42|
    43|            <table class="info-table">
    44|                <tr><td>No. Kontrak</td><td>{{ $pembayaran->kontrak->no_kontrak }}</td></tr>
    45|                <tr><td>Nama Tanah</td><td>{{ $pembayaran->kontrak->tanah->nama }}</td></tr>
    46|                <tr><td>Lokasi</td><td>{{ $pembayaran->kontrak->tanah->lokasi }}</td></tr>
    47|                <tr><td>Cicilan Ke</td><td>{{ $pembayaran->cicilan_ke }} / {{ $pembayaran->kontrak->jumlah_cicilan }}</td></tr>
    48|                <tr><td>Status</td><td><span class="status-badge status-{{ $pembayaran->status }}">{{ str_replace('_', ' ', ucfirst($pembayaran->status)) }}</span></td></tr>
    49|            </table>
    50|
    51|            <div class="amount-box">
    52|                <div class="label">Total Tagihan</div>
    53|                <div class="value">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</div>
    54|                <div class="date">Jatuh tempo: {{ $pembayaran->tanggal_jatuh_tempo->format('d F Y') }}</div>
    55|            </div>
    56|
    57|            <div style="background: #F0F5EE; border-left: 4px solid #2D5A27; padding: 16px; border-radius: 8px; font-size: 13px; color: #555;">
    58|                INFO: Pembayaran dapat dilakukan melalui transfer ke rekening:<br>
    59|                <strong>Bank Mandiri</strong> — 123.00.4567890 — PT Inhutani I
    60|            </div>
    61|        </div>
    62|
    63|        <div class="footer">
    64|            <p>© {{ date('Y') }} PT Inhutani I. All rights reserved.</p>
    65|            <p style="font-size:11px; color:#bbb;">Email ini dikirim otomatis oleh sistem manajemen aset tanah.</p>
    66|        </div>
    67|    </div>
    68|</body>
    69|</html>
    70|