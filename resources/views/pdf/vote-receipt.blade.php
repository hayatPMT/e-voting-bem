<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Voting</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background: #fff;
            margin: 0;
            padding: 40px;
            color: #333;
        }
        .container {
            border: 2px solid #333;
            padding: 40px;
            text-align: center;
            height: 90vh; /* Occupy most of the page */
            box-sizing: border-box;
            position: relative;
        }
        .header {
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .logo {
            max-height: 100px;
            margin-bottom: 15px;
        }
        h1 {
            font-size: 28px;
            text-transform: uppercase;
            margin: 0 0 10px 0;
            color: #1a202c;
        }
        h2 {
            font-size: 18px;
            font-weight: normal;
            margin: 0;
            color: #4a5568;
            letter-spacing: 2px;
        }
        .timestamp {
            background: #f7fafc;
            display: inline-block;
            padding: 15px 30px;
            border-radius: 50px;
            margin-bottom: 40px;
            border: 1px solid #e2e8f0;
        }
        .timestamp p {
            margin: 5px 0;
            font-size: 16px;
            color: #2d3748;
        }
        .candidate-box {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            margin: 20px auto;
            max-width: 400px;
            border: 2px solid #4299e1;
        }
        .candidate-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4299e1;
            margin-bottom: 20px;
        }
        .candidate-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
            color: #2b6cb0;
            text-transform: uppercase;
        }
        .vote-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-badge {
            background: #48bb78;
            color: white;
            padding: 10px 30px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18px;
            display: inline-block;
            margin-top: 30px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 60px;
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            color: rgba(0, 0, 0, 0.03);
            font-weight: bold;
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="watermark">SUARA SAH</div>

        <div class="header">
            @if(isset($setting) && $setting->election_logo && file_exists(storage_path('app/public/' . $setting->election_logo)))
                <img src="{{ storage_path('app/public/' . $setting->election_logo) }}" class="logo" alt="Logo">
            @endif
            <h1>{{ $setting->election_name ?? 'E-VOTING BEM' }}</h1>
            <h2>BUKTI SAH PEMILIHAN</h2>
        </div>

        <div class="timestamp">
            <p><strong>TANGGAL:</strong> {{ \Carbon\Carbon::parse($vote_time)->format('d F Y') }}</p>
            <p><strong>WAKTU:</strong> {{ \Carbon\Carbon::parse($vote_time)->format('H:i:s') }} WIB</p>
        </div>

        <div class="content">
            <p class="vote-label">KAUM MUDA MEMILIH:</p>
            
            <div class="candidate-box">
                @if($kandidat->foto && file_exists(storage_path('app/public/' . $kandidat->foto)))
                    <img src="{{ storage_path('app/public/' . $kandidat->foto) }}" class="candidate-image" alt="{{ $kandidat->nama }}">
                @else
                    <div style="width: 150px; height: 150px; background: #edf2f7; border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; border: 4px solid #4299e1;">
                        <span style="font-size: 60px; color: #a0aec0;">?</span>
                    </div>
                @endif
                
                <h3 class="candidate-name">{{ $kandidat->nama }}</h3>
            </div>
            
            <div class="status-badge">
                ✓ SUARA TERCATAT
            </div>
        </div>

        <div class="footer">
            <p>Terima kasih telah menggunakan hak suara Anda dalam pemilihan ini.</p>
            <p>Bukti ini adalah dokumen sah yang diterbitkan oleh sistem E-Voting.</p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
