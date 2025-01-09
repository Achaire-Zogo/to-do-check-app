<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .document-title {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .info-section {
            margin-bottom: 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .checklist-section {
            margin-bottom: 30px;
        }
        .checklist-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .status-present {
            color: #28a745;
        }
        .status-non-present {
            color: #dc3545;
        }
        .signature-section {
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .signature-box {
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
        }
        .signature-image {
            max-width: 200px;
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="document-title">Checklist Reception Machine</div>
        <div>Etec Standard G05</div>
        <div>Wiring Prerequisites Checklist</div>
    </div>

    <div class="info-section">
        <div class="info-grid">
            <div>
                <strong>Projet:</strong> {{ $data['project'] }}
            </div>
            <div>
                <strong>Date du Check:</strong> {{ $data['check_date'] }}
            </div>
            <div>
                <strong>Numéro de timbrage:</strong> {{ $data['stamp_number'] }}
            </div>
        </div>
    </div>

    <div class="checklist-section">
        <h3>Vérifications</h3>
        @foreach($data['items'] as $item)
            <div class="checklist-item">
                <h4>{{ $item['name'] }}</h4>
                <p class="status-{{ $item['status'] }}">
                    Status: {{ $item['status'] === 'present' ? 'Présent' : 'Non Présent' }}
                </p>
                @if($item['comment'])
                    <p><strong>Commentaire:</strong> {{ $item['comment'] }}</p>
                @endif
            </div>
        @endforeach
    </div>

    <div class="signature-section">
        <div class="signature-grid">
            <div class="signature-box">
                <img src="{{ $signature_performer }}" alt="Performer Signature" class="signature-image">
                <p>Performed by</p>
                <p>Date: {{ $data['check_date'] }}</p>
            </div>
            @if($signature_witness)
            <div class="signature-box">
                <img src="{{ $signature_witness }}" alt="Witness Signature" class="signature-image">
                <p>Witnessed by</p>
                <p>Date: {{ $data['check_date'] }}</p>
            </div>
            @endif
            @if($signature_reviewer)
            <div class="signature-box">
                <img src="{{ $signature_reviewer }}" alt="Reviewer Signature" class="signature-image">
                <p>Reviewed by</p>
                <p>Date: {{ $data['check_date'] }}</p>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
