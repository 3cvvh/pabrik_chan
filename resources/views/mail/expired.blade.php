<!-- filepath: c:\laragon\www\pabrik_chan\resources\views\mail\expired.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            padding: 40px 30px;
        }
        .content p {
            color: #333;
            line-height: 1.6;
            margin: 15px 0;
            font-size: 16px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .warning strong {
            color: #856404;
        }
        .button {
            display: inline-block;
            background-color: #667eea;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #764ba2;
        }
        .footer {
            background-color: #f9f9f9;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #eee;
        }
        .factory-name {
            color: #667eea;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ Subscription Expired</h1>
        </div>

        <div class="content">
            <p>Halo <span class="factory-name">{{ $PabrikName }}</span>,</p>

            <p>Kami informasikan bahwa masa berlaku subscription Anda telah berakhir pada tanggal ini.</p>

            <div class="warning">
                <strong>⚠️ Perhatian:</strong> Layanan Anda saat ini tidak aktif. Segera lakukan pembayaran untuk melanjutkan layanan dan menghindari kehilangan data penting.
            </div>

            <p>Untuk melanjutkan menggunakan layanan kami, silakan lakukan pembayaran dengan mengklik tombol di bawah:</p>

            <center>
                <a href="{{ route('payment.index') }}" class="button">Lakukan Pembayaran Sekarang</a>
            </center>

            <p>Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi tim support kami.</p>

            <p>Terima kasih,<br><strong>Tim Factorynize</strong></p>
        </div>

        <div class="footer">
            <p>© 2025 Factorynize. All rights reserved.</p>
            <p>Email ini dikirim karena subscription Anda telah expired. Jika ini bukan Anda, abaikan email ini.</p>
        </div>
    </div>
</body>
</html>
