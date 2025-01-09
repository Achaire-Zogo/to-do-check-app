<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .logo { height: 50px; }
        .title { text-align: center; font-size: 24px; margin: 20px 0; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        .info-item { margin-bottom: 10px; }
        .label { font-weight: bold; }
        .category { background: #f3f4f6; padding: 10px; margin: 15px 0; font-weight: bold; }
        .item { margin: 10px 0; padding: 10px; border: 1px solid #e5e7eb; }
        .item-header { display: flex; justify-content: space-between; }
        .status { font-weight: bold; }
        .status-ok { color: green; }
        .status-nok { color: red; }
        .comment { font-style: italic; color: #666; margin-top: 5px; }
        .signature-section { margin-top: 30px; }
        .signature-image { max-width: 200px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" class="logo">
        <div>
            <div>DP 07.3-12e</div>
            <div>V1.0</div>
        </div>
    </div>

    <h1 class="title">Formulaire de Réception</h1>

    <div class="info-grid">
        <div class="info-item">
            <span class="label">Projet:</span>
            <span>{{ $form->project }}</span>
        </div>
        <div class="info-item">
            <span class="label">Email du receveur:</span>
            <span>{{ $form->receiver_email }}</span>
        </div>
        <div class="info-item">
            <span class="label">Numéro de timbrage:</span>
            <span>{{ $form->stamp_number }}</span>
        </div>
        <div class="info-item">
            <span class="label">Date de vérification:</span>
            <span>{{ $form->check_date->format('d/m/Y') }}</span>
        </div>
        <div class="info-item">
            <span class="label">Date de soumission:</span>
            <span>{{ $form->submitted_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    @foreach($items as $category => $categoryItems)
        <div class="category">{{ $category }}</div>
        @foreach($categoryItems as $item)
            <div class="item">
                <div class="item-header">
                    <div>
                        <strong>{{ $item->name }}</strong>
                        @if($item->description)
                            <div>{{ $item->description }}</div>
                        @endif
                    </div>
                    <div class="status status-{{ $item->status }}">
                        {{ strtoupper($item->status) }}
                    </div>
                </div>
                @if($item->comment)
                    <div class="comment">{{ $item->comment }}</div>
                @endif
            </div>
        @endforeach
    @endforeach

    @if($form->missing_parts)
        <div class="category">Pièces Manquantes</div>
        <div class="item">{{ $form->missing_parts }}</div>
    @endif

    @if($form->unmounted_parts)
        <div class="category">Pièces non montées</div>
        <div class="item">{{ $form->unmounted_parts }}</div>
    @endif

    <div class="signature-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Performed by:</div>
                <div>{{ $form->signature_performer }}</div>
                @if($form->signature_image)
                    <img src="{{ storage_path('app/public/' . $form->signature_image) }}" 
                         alt="Signature" class="signature-image">
                @endif
            </div>
            <div class="info-item">
                <div class="label">Witnessed by:</div>
                <div>{{ $form->signature_witness }}</div>
            </div>
            <div class="info-item">
                <div class="label">Reviewed by:</div>
                <div>{{ $form->signature_reviewer }}</div>
            </div>
        </div>
    </div>
</body>
</html>
