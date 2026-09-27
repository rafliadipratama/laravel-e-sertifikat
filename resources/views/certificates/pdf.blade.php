<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat - {{ $certificate->recipient_name }}</title>
    <style>
        @page {
            size: a4 landscape;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            background-color: #ffffff;
        }

        .border-outer {
            border: 3.5px solid #1e3a8a;
            padding: 2.5mm;
        }

        .border-inner {
            border: 1.5px solid #d97706;
            padding: 6mm 10mm 4mm 10mm;
            position: relative;
        }

        .corner-accent-tl {
            position: absolute;
            top: -2px;
            left: -2px;
            width: 15mm;
            height: 15mm;
            border-top: 3.5px solid #d97706;
            border-left: 3.5px solid #d97706;
        }

        .corner-accent-br {
            position: absolute;
            bottom: -2px;
            right: -2px;
            width: 15mm;
            height: 15mm;
            border-bottom: 3.5px solid #d97706;
            border-right: 3.5px solid #d97706;
        }

        .header {
            text-align: center;
            margin-bottom: 3mm;
        }

        .organizer-name {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 1.5mm;
        }

        .main-title {
            font-size: 22pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }

        .sub-title {
            font-size: 9.5pt;
            font-style: italic;
            color: #64748b;
            letter-spacing: 1px;
            margin-bottom: 2mm;
        }

        .cert-number {
            display: inline-block;
            font-family: 'Courier New', Courier, monospace;
            font-size: 8.5pt;
            font-weight: bold;
            color: #1e293b;
            background-color: #f1f5f9;
            padding: 1mm 3mm;
            border: 1px solid #cbd5e1;
        }

        .body-content {
            text-align: center;
            margin-top: 3mm;
        }

        .presented-to {
            font-size: 9pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2mm;
        }

        .recipient-name {
            font-size: 20pt;
            font-weight: bold;
            color: #1e3a8a;
            text-decoration: underline;
            text-decoration-color: #d97706;
            margin-bottom: 2mm;
        }

        .role-badge {
            font-size: 10pt;
            font-weight: bold;
            color: #d97706;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 2.5mm;
        }

        .event-context {
            font-size: 9.5pt;
            color: #475569;
            line-height: 1.4;
            max-width: 90%;
            margin: 0 auto 2mm auto;
        }

        .event-title {
            font-size: 12pt;
            font-weight: bold;
            color: #0f172a;
            margin: 1.5mm 0;
        }

        .event-meta {
            font-size: 8.5pt;
            color: #64748b;
        }

        /* Footer Table Layout */
        .footer-table {
            width: 100%;
            margin-top: 4mm;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
            padding: 0;
        }

        .qr-section {
            width: 38%;
            text-align: left;
        }

        .qr-image {
            width: 20mm;
            height: 20mm;
            display: inline-block;
            vertical-align: middle;
            margin-right: 2.5mm;
        }

        .qr-text {
            display: inline-block;
            vertical-align: middle;
            font-size: 7pt;
            color: #64748b;
            line-height: 1.25;
        }

        .signature-section {
            width: 45%;
            text-align: right;
        }

        .signature-date {
            font-size: 8.5pt;
            color: #475569;
            margin-bottom: 11mm;
        }

        .signature-name {
            font-size: 10.5pt;
            font-weight: bold;
            color: #0f172a;
            border-top: 1px solid #1e293b;
            display: inline-block;
            padding-top: 1.5mm;
            min-width: 48mm;
            text-align: center;
        }

        .signature-position {
            font-size: 8pt;
            color: #64748b;
            text-align: center;
            margin-top: 0.5mm;
        }
    </style>
</head>
<body>
    <div class="border-outer">
        <div class="border-inner">
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
                        <div style="font-style: italic; font-size: 8.5pt; margin-top: 1mm; color: #64748b;">
                            {{ $certificate->description }}
                        </div>
                    @endif
                    <div class="event-meta" style="margin-top: 1.5mm;">
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
                            <img src="{{ $qrCode }}" alt="QR Verifikasi" class="qr-image" />
                        @endif
                        <div class="qr-text">
                            <strong>VERIFIKASI RESMI</strong><br>
                            Pindai QR Code untuk memeriksa<br>
                            keabsahan sertifikat ini.
                        </div>
                    </td>
                    <td style="width: 17%;"></td>
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
