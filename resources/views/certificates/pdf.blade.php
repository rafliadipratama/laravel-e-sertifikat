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
            color: #1e293b;
            background-color: #ffffff;
            position: relative;
            width: 297mm;
            height: 210mm;
        }

        /* Outer Navy Frame */
        .cert-outer-border {
            position: absolute;
            top: 8mm;
            left: 8mm;
            width: 281mm;
            height: 194mm;
            border: 4px solid #1e3a8a;
        }

        /* Inner Gold Frame */
        .cert-inner-border {
            position: absolute;
            top: 11mm;
            left: 11mm;
            width: 275mm;
            height: 188mm;
            border: 1.5px solid #d97706;
        }

        /* 4 Corner Accents */
        .corner-tl {
            position: absolute;
            top: 11mm;
            left: 11mm;
            width: 15mm;
            height: 15mm;
            border-top: 4px solid #d97706;
            border-left: 4px solid #d97706;
        }

        .corner-tr {
            position: absolute;
            top: 11mm;
            left: 271mm;
            width: 15mm;
            height: 15mm;
            border-top: 4px solid #d97706;
            border-right: 4px solid #d97706;
        }

        .corner-bl {
            position: absolute;
            top: 184mm;
            left: 11mm;
            width: 15mm;
            height: 15mm;
            border-bottom: 4px solid #d97706;
            border-left: 4px solid #d97706;
        }

        .corner-br {
            position: absolute;
            top: 184mm;
            left: 271mm;
            width: 15mm;
            height: 15mm;
            border-bottom: 4px solid #d97706;
            border-right: 4px solid #d97706;
        }

        /* Content Container */
        .content-box {
            position: absolute;
            top: 16mm;
            left: 18mm;
            width: 261mm;
            height: 178mm;
        }

        .header-section {
            text-align: center;
            height: 38mm;
        }

        .organizer-name {
            font-size: 11pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 2mm;
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
            font-size: 10pt;
            font-style: italic;
            color: #64748b;
            letter-spacing: 1.5px;
            margin-bottom: 2.5mm;
        }

        .cert-number {
            display: inline-block;
            font-family: 'Courier New', Courier, monospace;
            font-size: 9pt;
            font-weight: bold;
            color: #1e293b;
            background-color: #f8fafc;
            padding: 1.5mm 4mm;
            border: 1px solid #cbd5e1;
        }

        .body-section {
            text-align: center;
            height: 92mm;
            padding-top: 4mm;
        }

        .presented-to {
            font-size: 10pt;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 3mm;
        }

        .recipient-name {
            font-size: 25pt;
            font-weight: bold;
            color: #1e3a8a;
            text-decoration: underline;
            text-decoration-color: #d97706;
            margin-bottom: 3mm;
        }

        .role-badge {
            font-size: 12pt;
            font-weight: bold;
            color: #d97706;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 4mm;
        }

        .event-context {
            font-size: 10.5pt;
            color: #475569;
            line-height: 1.5;
            max-width: 220mm;
            margin: 0 auto;
        }

        .event-title {
            font-size: 14pt;
            font-weight: bold;
            color: #0f172a;
            margin: 2mm 0;
        }

        .event-meta {
            font-size: 9.5pt;
            color: #64748b;
            margin-top: 2mm;
        }

        /* Footer Section */
        .footer-section {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 38mm;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: bottom;
            padding: 0;
        }

        .qr-image {
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
            line-height: 1.35;
        }

        .signature-date {
            font-size: 9pt;
            color: #475569;
            margin-bottom: 15mm;
            text-align: right;
        }

        .signature-name {
            font-size: 11.5pt;
            font-weight: bold;
            color: #0f172a;
            border-top: 1px solid #1e293b;
            display: inline-block;
            padding-top: 2mm;
            min-width: 55mm;
            text-align: center;
        }

        .signature-position {
            font-size: 8.5pt;
            color: #64748b;
            text-align: center;
            margin-top: 1mm;
        }
    </style>
</head>
<body>
    <!-- Outer Navy Frame -->
    <div class="cert-outer-border"></div>

    <!-- Inner Gold Frame -->
    <div class="cert-inner-border"></div>

    <!-- 4 Corner Accents -->
    <div class="corner-tl"></div>
    <div class="corner-tr"></div>
    <div class="corner-bl"></div>
    <div class="corner-br"></div>

    <!-- Content -->
    <div class="content-box">
        <!-- Header -->
        <div class="header-section">
            @if(isset($logoBase64) && $logoBase64)
                <div style="margin-bottom: 1.5mm;">
                    <img src="{{ $logoBase64 }}" style="max-height: 11mm; max-width: 50mm;" />
                </div>
            @endif
            <div class="organizer-name">{{ $certificate->event->organizer }}</div>
            <div class="main-title">SERTIFIKAT PENGHARGAAN</div>
            <div class="sub-title">CERTIFICATE OF APPRECIATION</div>
            <div class="cert-number">NOMOR: {{ $certificate->certificate_number }}</div>
        </div>

        <!-- Body -->
        <div class="body-section">
            <div class="presented-to">Diberikan Dengan Hormat Kepada:</div>
            <div class="recipient-name">{{ $certificate->recipient_name }}</div>
            <div class="role-badge">Sebagai: {{ $certificate->role }}</div>

            <div class="event-context">
                Atas partisipasi dan kontribusinya secara aktif dalam kegiatan:
                <div class="event-title">"{{ $certificate->event->title }}"</div>
                @if($certificate->description)
                    <div style="font-style: italic; font-size: 9pt; margin-top: 1.5mm; color: #64748b;">
                        {{ $certificate->description }}
                    </div>
                @endif
                <div class="event-meta">
                    Diselenggarakan pada {{ $certificate->event->event_date->format('d F Y') }}
                    @if($certificate->event->location)
                        &bull; {{ $certificate->event->location }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-section">
            <table class="footer-table">
                <tr>
                    <td style="width: 45%; text-align: left;">
                        @if(isset($qrCode))
                            <img src="{{ $qrCode }}" alt="QR Verifikasi" class="qr-image" />
                        @endif
                        <div class="qr-text">
                            <strong style="color: #0f172a;">VERIFIKASI RESMI</strong><br>
                            Pindai QR Code untuk memeriksa<br>
                            keabsahan sertifikat ini secara online.
                        </div>
                    </td>
                    <td style="width: 10%;"></td>
                    <td style="width: 45%; text-align: right;">
                        <div class="signature-date">
                            Diterbitkan pada {{ $certificate->issue_date->format('d F Y') }}
                        </div>
                        <div style="text-align: right;">
                            <div style="display: inline-block; text-align: center; min-width: 55mm;">
                                @if(isset($signatureBase64) && $signatureBase64)
                                    <div style="margin-bottom: -3mm;">
                                        <img src="{{ $signatureBase64 }}" style="height: 14mm; max-width: 50mm;" />
                                    </div>
                                @endif
                                <div class="signature-name">{{ $certificate->event->signer_name }}</div>
                                <div class="signature-position">{{ $certificate->event->signer_position }}</div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
