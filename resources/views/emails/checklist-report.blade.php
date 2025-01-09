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
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin: 0 auto;
            display: block;
        }
        .info-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .checklist-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .status-present {
            color: #28a745;
        }
        .status-non-present {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/mikron-logo.png') }}" alt="Mikron Logo" class="logo">
            <h1>Checklist Reception Machine</h1>
            <h2>Etec Standard G05</h2>
        </div>

        <div class="info-section">
            <p><strong>Projet:</strong> {{ $checklistData['project'] }}</p>
            <p><strong>Date du Check:</strong> {{ $checklistData['check_date'] }}</p>
            <p><strong>Numéro de timbrage:</strong> {{ $checklistData['stamp_number'] }}</p>
        </div>

        <div class="checklist-section">
            <h3>Résumé des vérifications</h3>
            @foreach($checklistData['items'] as $item)
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

        <p>Un rapport PDF détaillé est joint à cet email.</p>
    </div>
</body>
</html>
