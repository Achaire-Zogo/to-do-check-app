<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .loader-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            display: none;
        }
        .loader {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #3498db;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Loader -->
    <div class="loader-container" id="loader">
        <div class="loader"></div>
    </div>
    <div id="receptionForm" class="container px-4 py-8 mx-auto">
        <div class="p-6 mb-8 bg-white rounded-lg shadow-lg">
            <!-- En-tête -->
            <div class="flex justify-between items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
                <div class="text-right">
                    <h2 class="text-xl font-bold">DP 07.3-12e</h2>
                    <p>V1.0</p>
                </div>
            </div>

            <h1 class="mb-8 text-2xl font-bold text-center">{{ $title }}</h1>

            <form id="reception-form">
                <!-- Informations du projet -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Projet:</label>
                            <input type="text" name="project" class="flex-1 p-2 rounded border" required>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Date du Check:</label>
                            <input type="date" name="check_date" class="flex-1 p-2 rounded border" required>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Check Roadmap:</label>
                            <select name="check_roadmap" class="flex-1 p-2 rounded border" required>
                                <option value="">Sélectionner...</option>
                                <option value="OK">OK</option>
                                <option value="NOK">NOK</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Email du receveur:</label>
                            <input type="email" name="receiver_email" class="flex-1 p-2 rounded border" required>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Numéro de timbrage:</label>
                            <input type="text" name="stamp_number" class="flex-1 p-2 rounded border" required>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Check Schémas Eplan:</label>
                            <select name="check_schemas" class="flex-1 p-2 rounded border" required>
                                <option value="">Sélectionner...</option>
                                <option value="OK">OK</option>
                                <option value="NOK">NOK</option>
                            </select>
                        </div>
                        <div class="flex items-center space-x-2">
                            <label class="w-40 font-semibold">Check Étiquette standard:</label>
                            <select name="check_etiquette" class="flex-1 p-2 rounded border" required>
                                <option value="">Sélectionner...</option>
                                <option value="OK">OK</option>
                                <option value="NOK">NOK</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Liste des items -->
                <div id="items-container">
                    @foreach($items as $category => $categoryItems)
                        <div class="mb-8">
                            <h3 class="p-3 mb-4 text-xl font-semibold text-gray-700 bg-gray-50 rounded">{{ $category }}</h3>
                            <div class="space-y-4">
                                @foreach($categoryItems as $item)
                                    <div class="p-4 bg-white rounded-lg border transition-shadow hover:shadow-md">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <p class="font-medium">{{ $item['name'] }}</p>
                                                @if(!empty($item['description']))
                                                    <p class="text-sm text-gray-600">{{ $item['description'] }}</p>
                                                @endif
                                                <textarea name="items[{{ $loop->parent->index }}_{{ $loop->index }}][comment]"
                                                    class="p-2 mt-2 w-full text-sm rounded border"
                                                    placeholder="Commentaire (optionnel)"
                                                    rows="2"></textarea>
                                                <input type="hidden" name="items[{{ $loop->parent->index }}_{{ $loop->index }}][category]" value="{{ $category }}">
                                                <input type="hidden" name="items[{{ $loop->parent->index }}_{{ $loop->index }}][name]" value="{{ $item['name'] }}">
                                            </div>
                                            <div class="flex space-x-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio"
                                                        name="items[{{ $loop->parent->index }}_{{ $loop->index }}][status]"
                                                        value="ok"
                                                        required
                                                        class="text-blue-600 form-radio">
                                                    <span class="ml-2">OK</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio"
                                                        name="items[{{ $loop->parent->index }}_{{ $loop->index }}][status]"
                                                        value="nok"
                                                        class="text-red-600 form-radio">
                                                    <span class="ml-2">NOK</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pièces manquantes et non montées -->
                <div class="mb-8 space-y-6">
                    <div>
                        <label class="block mb-2 font-semibold">Check Pièces Manquantes:</label>
                        <textarea name="missing_parts" class="p-2 w-full rounded border" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block mb-2 font-semibold">Check Pièces non montées:</label>
                        <textarea name="unmounted_parts" class="p-2 w-full rounded border" rows="3"></textarea>
                    </div>
                </div>

                <!-- Signatures -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
                    <div>
                        <label class="block mb-2 font-semibold">Performed by:</label>
                        <input type="text" name="signature_performer" class="p-2 mb-2 w-full rounded border" required>
                        <div class="p-4 text-center rounded-lg border-2 border-gray-300 border-dashed">
                            <input type="file"
                                id="signature-input"
                                accept="image/*"
                                class="hidden">
                            <button type="button"
                                id="upload-signature"
                                class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600">
                                Ajouter une signature
                            </button>
                            <img id="signature-preview"
                                class="hidden mx-auto mt-2 max-h-32">
                            <input type="hidden" name="signature_image" id="signature-data">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 font-semibold">Witnessed by:</label>
                        <input type="text" name="signature_witness" class="p-2 w-full rounded border">
                    </div>
                    <div>
                        <label class="block mb-2 font-semibold">Reviewed by:</label>
                        <input type="text" name="signature_reviewer" class="p-2 w-full rounded border">
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="flex justify-center">
                    <button type="submit"
                            class="px-6 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Configuration de l'en-tête CSRF pour toutes les requêtes AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Gestion du téléchargement de la signature
            $('#upload-signature').click(function() {
                $('#signature-input').click();
            });

            $('#signature-input').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#signature-preview')
                            .attr('src', e.target.result)
                            .removeClass('hidden');
                        $('#signature-data').val(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Soumission du formulaire
            $('#reception-form').submit(function(e) {
                e.preventDefault();

                // Afficher le loader
                $('#loader').show();

                // Récupération des données du formulaire
                const formData = new FormData(this);

                // Conversion des données en objet pour l'envoi
                const jsonData = {};
                const items = [];

                formData.forEach((value, key) => {
                    if (key.startsWith('items[')) {
                        const matches = key.match(/items\[(\d+)_(\d+)\]\[(\w+)\]/);
                        if (matches) {
                            const [_, categoryIndex, itemIndex, field] = matches;
                            const itemKey = `${categoryIndex}_${itemIndex}`;

                            if (!items[itemKey]) {
                                items[itemKey] = {};
                            }
                            items[itemKey][field] = value;
                        }
                    } else {
                        jsonData[key] = value;
                    }
                });

                // Nettoyage et formatage des items
                jsonData.items = Object.values(items);

                // Envoi des données
                $.ajax({
                    url: '/reception/store',
                    method: 'POST',
                    data: JSON.stringify(jsonData),
                    contentType: 'application/json',
                    success: function(response) {
                        // Cacher le loader
                        $('#loader').hide();
                        alert('Formulaire enregistré avec succès!');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Cacher le loader
                        $('#loader').hide();
                        alert('Erreur lors de l\'enregistrement du formulaire: ' + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
