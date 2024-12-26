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
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .category {
            margin-bottom: 30px;
        }
        .category-header {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .item {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .present {
            background-color: #d4edda;
        }
        .missing {
            background-color: #f8d7da;
        }
        .item-name {
            font-weight: bold;
        }
        .item-description {
            color: #666;
            margin: 5px 0;
        }
        .item-comment {
            font-style: italic;
            color: #dc3545;
            margin-top: 5px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .stat-item {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Rapport de Vérification Matériel G05</h1>
            <p>Généré par: {{ $userName }} le {{ $date }}</p>
        </div>

        <div class="summary">
            <h2>Résumé Global</h2>
            <div class="stats">
                <div class="stat-item">
                    <strong>Total des composants:</strong> {{ $totalItems }}
                </div>
                <div class="stat-item">
                    <strong>Composants présents:</strong> {{ $presentItems }}
                </div>
                <div class="stat-item">
                    <strong>Composants manquants:</strong> {{ $missingItems }}
                </div>
                <div class="stat-item">
                    <strong>Avec commentaires:</strong> {{ $itemsWithComments }}
                </div>
            </div>
        </div>

        @foreach($categorizedItems as $category => $categoryStats)
        <div class="category">
            <div class="category-header">
                <h3>{{ $category }}</h3>
                <div class="stats">
                    <div class="stat-item">Présents: {{ $categoryStats['present'] }}/{{ $categoryStats['total'] }}</div>
                    <div class="stat-item">Manquants: {{ $categoryStats['missing'] }}</div>
                </div>
            </div>

            @foreach($categoryStats['items'] as $item)
            <div class="item {{ $item['is_present'] ? 'present' : 'missing' }}">
                <div class="item-name">{{ $item['name'] }}</div>
                <div class="item-description">{{ $item['description'] }}</div>
                @if(!$item['is_present'] && isset($item['comment']) && $item['comment'])
                    <div class="item-comment">
                        Commentaire: {{ $item['comment'] }}
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</body>
</html>
