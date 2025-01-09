<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist Reception Machine</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="flex items-center mb-6">
                <img src="{{ asset('images/mikron-logo.png') }}" alt="Mikron Logo" class="h-12">
                <div class="ml-4">
                    <h1 class="text-2xl font-bold">Project Management</h1>
                    <h2 class="text-xl">Etec Standard G05</h2>
                    <h3>Wiring Prerequisites Checklist</h3>
                </div>
            </div>

            <form id="checklistForm" class="space-y-6" method="POST" action="{{ route('checklist.store') }}">
                @csrf
                
                <!-- Project Information -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Projet</label>
                        <input type="text" name="project" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date du Check</label>
                        <input type="date" name="check_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Check Numéro de timbrage</label>
                        <input type="text" name="stamp_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>

                <!-- Tabs -->
                <div class="mb-4">
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                            <button type="button" class="tab-button border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="armoires">
                                Armoires
                            </button>
                            <button type="button" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="hmi">
                                HMI
                            </button>
                            <button type="button" class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm" data-tab="verine">
                                Vérine
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Tab Contents -->
                <div id="tab-contents">
                    <!-- Armoires Tab -->
                    <div class="tab-content" id="armoires-content">
                        <div class="space-y-4">
                            @foreach($vis_control_ar as $item)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium">{{ $item['name'] }}</h3>
                                        <p class="text-sm text-gray-500">{{ $item['description'] }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status_{{ $loop->index }}" value="present" class="form-radio" {{ $item['is_present'] ? 'checked' : '' }}>
                                            <span class="ml-2">Présent</span>
                                        </label>
                                        <label class="inline-flex items-center">
                                            <input type="radio" name="status_{{ $loop->index }}" value="non_present" class="form-radio" {{ !$item['is_present'] ? 'checked' : '' }}>
                                            <span class="ml-2">Non Présent</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700">Commentaire</label>
                                    <textarea name="comment_{{ $loop->index }}" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- HMI Tab -->
                    <div class="tab-content hidden" id="hmi-content">
                        <!-- HMI content will be added -->
                    </div>

                    <!-- Vérine Tab -->
                    <div class="tab-content hidden" id="verine-content">
                        <!-- Vérine content will be added -->
                    </div>
                </div>

                <!-- Signatures -->
                <div class="mt-8 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Performed by</label>
                        <div class="border rounded-lg p-2 mt-1">
                            <canvas id="signature-pad-performer" class="border rounded" width="400" height="200"></canvas>
                        </div>
                        <input type="hidden" name="signature_performer" id="signature-performer-data">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Witnessed by</label>
                        <div class="border rounded-lg p-2 mt-1">
                            <canvas id="signature-pad-witness" class="border rounded" width="400" height="200"></canvas>
                        </div>
                        <input type="hidden" name="signature_witness" id="signature-witness-data">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reviewed by</label>
                        <div class="border rounded-lg p-2 mt-1">
                            <canvas id="signature-pad-reviewer" class="border rounded" width="400" height="200"></canvas>
                        </div>
                        <input type="hidden" name="signature_reviewer" id="signature-reviewer-data">
                    </div>
                </div>

                <!-- Email for Report -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Email pour le rapport</label>
                    <input type="email" name="report_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Soumettre le formulaire
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabName = button.dataset.tab;
                    
                    // Update button states
                    tabButtons.forEach(btn => {
                        btn.classList.remove('border-indigo-500', 'text-indigo-600');
                        btn.classList.add('border-transparent', 'text-gray-500');
                    });
                    button.classList.remove('border-transparent', 'text-gray-500');
                    button.classList.add('border-indigo-500', 'text-indigo-600');

                    // Update content visibility
                    tabContents.forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.getElementById(`${tabName}-content`).classList.remove('hidden');
                });
            });

            // Initialize signature pads
            const signaturePadPerformer = new SignaturePad(document.getElementById('signature-pad-performer'));
            const signaturePadWitness = new SignaturePad(document.getElementById('signature-pad-witness'));
            const signaturePadReviewer = new SignaturePad(document.getElementById('signature-pad-reviewer'));

            // Handle form submission
            document.getElementById('checklistForm').addEventListener('submit', function(e) {
                // Save signatures to hidden inputs
                document.getElementById('signature-performer-data').value = signaturePadPerformer.toDataURL();
                document.getElementById('signature-witness-data').value = signaturePadWitness.toDataURL();
                document.getElementById('signature-reviewer-data').value = signaturePadReviewer.toDataURL();
            });
        });
    </script>
</body>
</html>
