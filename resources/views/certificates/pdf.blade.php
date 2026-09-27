<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->recipient_name }}</title>
    <style>
        @page {
            size: 297mm 210mm landscape;
            margin: 0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            width: 297mm;
            height: 210mm;
            position: relative;
        }

        .certificate-container {
            width: 277mm;
            height: 190mm;
            margin: 10mm;
            border: 4px solid #1e3a8a; /* Navy border */
            position: relative;
            background-color: #ffffff;
        }

        .inner-border {
            width: 271mm;
            height: 184mm;
            margin: 2mm;
            border: 1px solid #d97706; /* Gold inner border */
            padding: 12mm 15mm;
            position: relative;
        }

        .corner-accent-tl {
            position: absolute;
            top: -2px;
            left: -2px;
            width: 20mm;
            height: 20mm;
            border-top: 4px solid #d97706;
            border-left: 4px solid #d97706;
        }

        .corner-accent-br {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 20mm;
            height: 20mm;
            border-bottom: 4px solid #d97706;
            border-right: 4px solid #d97706;
        }

        .header {
            text-align: center;
            margin-bottom: 5mm;
        }

        .organizer-name {
            font-size: 13pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 3mm;
        }

        .main-title {
            font-size: 26pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 1.5mm;
        }

        .sub-title {
            font-size: 10.5pt;
            font-style: italic;
            color: #64748b;
            letter-spacing: 1.5px;
            margin-bottom: 3mm;
        }

        .cert-number {
            display: inline-block;
            font-family: 'Courier New', Courier, monospace;
            font-size: 9.5pt;
            font-weight: bold;
            color: #1e293b;
            background-color: #f1f5f9;
            padding: 1.5mm 4mm;
            border: 1px solid #cbd5e1;
        }

        .body-content {
            text-align: center;
            margin-top: 4mm;
        }

        .presented-to {
            font-size: 10pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 3mm;
        }

        .recipient-name {
            font-size: 23pt;
            font-weight: bold;
            color: #1e3a8a;
            text-decoration: underline;
            text-decoration-color: #d97706;
            margin-bottom: 3.5mm;
        }

        .role-badge {
            font-size: 11pt;
            font-weight: bold;
            color: #d97706;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4mm;
        }

        .event-context {
            font-size: 10pt;
            color: #475569;
            line-height: 1.5;
            max-width: 220mm;
            margin: 0 auto 3mm auto;
        }

        .event-title {
            font-size: 13pt;
            font-weight: bold;
            color: #0f172a;
            margin: 2mm 0;
        }

        .event-meta {
            font-size: 9.5pt;
            color: #64748b;
        }

        /* Footer Table Layout */
        .footer-table {
            width: 100%;
            margin-top: 5mm;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
        }

        .qr-section {
            width: 35%;
            text-align: left;
        }

        .qr-section img {
            width: 24mm;
            height: 24mm;
            display: inline-block;
            vertical-align: middle;
            margin-right: 3mm;
        }

        .qr-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 7.5pt;
            color: #64748b;
            line-height: 1.3;
        }

        .signature-section {
            width: 45%;
            text-align: right;
        }

        .signature-date {
            font-size: 9pt;
            color: #475569;
            margin-bottom: 14mm;
        }

        .signature-name {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            border-top: 1px solid #1e293b;
            display: inline-block;
            padding-top: 1.5mm;
            min-width: 50mm;
            text-align: center;
        }

        .signature-position {
            font-size: 8.5pt;
            color: #64748b;
            text-align: center;
            margin-top: 0.5mm;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="inner-border">
            <div class="corner-accent-tl"></div>
            <div class="corner-accent-br"></div>

            <!-- Header -->
            <div class="header">
                <div class="organizer-name">{{ $certificate->event->organizer }}</div>
                <div class="main-title">SERTIFIKAT PENGHARGAAN</div>
                <div class="sub-title">CERTIFICATE OF APPRECIATION</div>
                <div class="cert-number">NOMOR: {{ $certificate->certificate_number }}</div>
            </div>

            <!-- Body -->
            <div class="body-content">
                <div class="presented-to">Diberikan Dengan Hormat Kepada:</div>
                <div class="recipient-name">{{ $certificate->recipient_name }}</div>
                <div class="role-badge">Sebagai: {{ $certificate->role }}</div>

                <div class="event-context">
                    Atas partisipasi dan kontribusinya secara aktif dalam kegiatan:
                    <div class="event-title">"{{ $certificate->event->title }}"</div>
                    @if($certificate->description)
                        <div style="font-style: italic; font-size: 9pt; margin-top: 1mm;">
                            {{ $certificate->description }}
                        </div>
                    @endif
                    <div class="event-meta" style="margin-top: 2mm;">
                        Diselenggarakan pada {{ $certificate->event->event_date->format('d F Y') }}
                        @if($certificate->event->location)
                            &bull; {{ $certificate->event->location }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Table -->
            <table class="footer-table">
                <tr>
                    <td class="qr-section">
                        @if(isset($qrCode))
                            <img src="{{ $qrCode }}" alt="QR Verifikasi" />
                        @endif
                        <div class="qr-text">
                            <strong>VERIFIKASI RESMI</strong><br>
                            Pindai QR Code untuk memeriksa<br>
                            keabsahan sertifikat ini.
                        </div>
                    </td>
                    <td style="width: 20%;"></td>
                    <td class="signature-section">
                        <div class="signature-date">
                            Diterbitkan pada {{ $certificate->issue_date->format('d F Y') }}
                        </div>
                        <div style="text-align: right;">
                            <div class="signature-name">{{ $certificate->event->signer_name }}</div>
                            <div class="signature-position">{{ $certificate->event->signer_position }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
