<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .section { margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 5px; }
        .header { background: #f8f9fa; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .item { margin: 10px 0; padding: 10px; background: #f8f9fa; border-radius: 3px; }
        .status { display: inline-block; padding: 3px 8px; border-radius: 3px; font-size: 0.9em; }
        .status-ok { background: #d4edda; color: #155724; }
        .status-nok { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Rapport de Réception</h2>
            <p><strong>Projet:</strong> {{ $reportData['project'] }}</p>
            <p><strong>Date du Check:</strong> {{ \Carbon\Carbon::parse($reportData['check_date'])->format('d/m/Y') }}</p>
            <p><strong>Numéro de timbrage:</strong> {{ $reportData['stamp_number'] }}</p>
        </div>

        <div class="section">
            <h3>Détails du Formulaire</h3>
            <p><strong>Check Roadmap:</strong> {{ $reportData['check_roadmap'] }}</p>
            <p><strong>Check Schémas:</strong> {{ $reportData['check_schemas'] }}</p>
            <p><strong>Check Étiquette:</strong> {{ $reportData['check_etiquette'] }}</p>
        </div>

        @if(!empty($commentArray))
            <div class="section">
                <h3>Liste de Contrôle</h3>
                @foreach($commentArray as $category => $items)
                    <div class="category">
                        <h4>{{ $category }}</h4>
                        @foreach($items as $item)
                            <div class="item">
                                <p>
                                    <strong>{{ $item['name'] }}</strong>
                                    <span class="status {{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                        {{ strtoupper($item['status']) }}
                                    </span>
                                </p>
                                @if(!empty($item['comment']))
                                    <p><em>Commentaire: {{ $item['comment'] }}</em></p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endif

        <div class="section">
            <h3>Informations Supplémentaires</h3>
            @if(!empty($reportData['missing_parts']))
                <div class="item">
                    <h4>Pièces Manquantes</h4>
                    <p>{{ $reportData['missing_parts'] }}</p>
                </div>
            @endif
            @if(!empty($reportData['unmounted_parts']))
                <div class="item">
                    <h4>Pièces non montées</h4>
                    <p>{{ $reportData['unmounted_parts'] }}</p>
                </div>
            @endif
        </div>

        <div class="section">
            <p><strong>Effectué par:</strong> {{ $reportData['signature_performer'] }}</p>
            @if(!empty($reportData['signature_witness']))
                <p><strong>Témoin:</strong> {{ $reportData['signature_witness'] }}</p>
            @endif
            @if(!empty($reportData['signature_reviewer']))
                <p><strong>Revu par:</strong> {{ $reportData['signature_reviewer'] }}</p>
            @endif
        </div>

        <p>Veuillez trouver le rapport détaillé en pièce jointe au format PDF.</p>
    </div>
</body>
</html>
