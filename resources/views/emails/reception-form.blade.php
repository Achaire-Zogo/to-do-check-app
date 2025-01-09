<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin-bottom: 30px; }
        .footer { text-align: center; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Formulaire de Réception</h1>
        </div>

        <div class="content">
            <p>Bonjour,</p>
            
            <p>Vous trouverez ci-joint le formulaire de réception pour le projet : <strong>{{ $form->project }}</strong>.</p>
            
            <p>Détails du formulaire :</p>
            <ul>
                <li>Projet : {{ $form->project }}</li>
                <li>Numéro de timbrage : {{ $form->stamp_number }}</li>
                <li>Date de soumission : {{ $form->submitted_at->format('d/m/Y H:i') }}</li>
                <li>Effectué par : {{ $form->signature_performer }}</li>
            </ul>

            <p>Le document PDF en pièce jointe contient tous les détails du formulaire de réception, y compris la liste complète des éléments vérifiés et les signatures.</p>
        </div>

        <div class="footer">
            <p>Ceci est un email automatique, merci de ne pas y répondre.</p>
        </div>
    </div>
</body>
</html>
