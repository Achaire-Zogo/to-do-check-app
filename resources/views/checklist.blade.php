<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checklist Matériel G05</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<style>
.logo {
    max-width: 150px;
    margin: 0 auto;
    display: block;
}
        .logo-container {
    text-align: center;
    margin-bottom: 20px;
}
    </style>
<body class="bg-gray-100">

    <div id="app" class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="logo-container">
        <img src="{{ asset('images/logo.png') }}" style="border-radius:50%"  alt="Company Logo" class="logo">
    </div>
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Vérification du Matériel G05</h1>

            <!-- Informations utilisateur -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Informations</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- User Name Field -->
    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="userName">
            Votre nom
        </label>
        <input 
            type="text" 
            id="userName" 
            v-model="userName"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Entrez votre nom"
        >
    </div>

    <!-- Recipient Email Field -->
    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="recipientEmail">
            Email du destinataire
        </label>
        <input 
            type="email" 
            id="recipientEmail" 
            v-model="recipientEmail"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="email@example.com"
        >
    </div>

    <!-- Machine Name Field -->
    <div>
        <label class="block text-gray-700 text-sm font-bold mb-2" for="machineName">
            Nom de la machine
        </label>
        <input 
            type="text" 
            id="machineName" 
            v-model="machineName"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Entrez le nom de la machine"
        >
    </div>
</div>

            </div>

            <!-- Statistiques -->
            <div class="mb-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="text-sm text-blue-600">Total des composants</div>
                    <div class="text-2xl font-bold text-blue-800">@{{ items.length }}</div>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-sm text-green-600">Composants présents</div>
                    <div class="text-2xl font-bold text-green-800">@{{ presentCount }}</div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-sm text-red-600">Composants manquants</div>
                    <div class="text-2xl font-bold text-red-800">@{{ items.length - presentCount }}</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-sm text-yellow-600">Avec commentaires</div>
                    <div class="text-2xl font-bold text-yellow-800">@{{ commentCount }}</div>
                </div>
            </div>


            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 bg-gray-50 p-3 rounded">Controle visuel des armoires</h3>
                <div class="space-y-4">
                    @foreach($vis_control_ar as $key => $vca)
                    <div 
                         class="{'bg-white border rounded-lg p-4 hover:shadow-md transition-shadow': true,
                                 'border-green-500 bg-green-50'}">
                        <div class="flex items-start space-x-4">
                            
                            <div class="flex-grow">
                                <div class="font-semibold text-gray-800">{{ $vca['name'] }}</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $vca['description'] }}</div>
                                <textarea 
                                    name="commentAr[]"
                                    placeholder="Commentaire"
                                    class="mt-2 w-full p-2 border rounded text-sm focus:outline-none focus:ring-1 focus:ring-green-500 border-green-200"
                                    rows="2"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>


            <!-- Liste des composants par catégorie -->
            <div v-for="category in categories" :key="category" class="mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 bg-gray-50 p-3 rounded">@{{ category }}</h3>
                <div class="space-y-4">
                    <div v-for="item in itemsByCategory(category)" :key="item.name" 
                         :class="{'bg-white border rounded-lg p-4 hover:shadow-md transition-shadow': true,
                                 'border-green-500 bg-green-50': item.is_present && item.comment,
                                 'border-red-300': !item.is_present && item.comment}">
                        <div class="flex items-start space-x-4">
                            <div class="flex-none w-24">
                                <button 
                                    @click="item.is_present = !item.is_present"
                                    :class="{'px-3 py-1 rounded text-sm font-semibold': true,
                                            'bg-green-100 text-green-800': item.is_present,
                                            'bg-red-100 text-red-800': !item.is_present}"
                                >
                                    @{{ item.is_present ? 'Présent' : 'Non présent' }}
                                </button>
                            </div>
                            <div class="flex-grow">
                                <div class="font-semibold text-gray-800">@{{ item.name }}</div>
                                <div class="text-sm text-gray-600 mt-1">@{{ item.description }}</div>
                                <textarea 
                                    v-if="!item.is_present"
                                    v-model="item.comment"
                                    placeholder="Expliquez pourquoi ce composant est manquant..."
                                    class="mt-2 w-full p-2 border rounded text-sm focus:outline-none focus:ring-1 focus:ring-red-500 border-red-200"
                                    rows="2"
                                ></textarea>
                                <textarea 
                                    v-if="item.is_present"
                                    v-model="item.comment"
                                    placeholder="Un commentaire sur cet élément?"
                                    class="mt-2 w-full p-2 border rounded text-sm focus:outline-none focus:ring-1 focus:ring-green-500 border-green-200"
                                    rows="2"
                                ></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bouton de soumission -->
            <div class="mt-8 flex flex-col items-center space-y-4">
                <button 
                    @click="submitChecklist"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:shadow-outline disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isFormValid || isSubmitting"
                >
                    <span v-if="!isSubmitting">Envoyer la checklist</span>
                    <span v-else class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Envoi en cours...
                    </span>
                </button>
                
                <!-- Message de succès -->
                <div v-if="submitStatus.success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Succès!</strong>
                    <span class="block sm:inline" v-text="submitStatus.message"></span>
                    <div v-if="submitStatus.statistics" class="mt-2">
                        <div class="font-semibold">Statistiques :</div>
                        <ul class="list-disc list-inside">
                            <li>Total : <span v-text="submitStatus.statistics.total"></span></li>
                            <li>Présents : <span v-text="submitStatus.statistics.present"></span></li>
                            <li>Manquants : <span v-text="submitStatus.statistics.missing"></span></li>
                            <li>Avec commentaires : <span v-text="submitStatus.statistics.with_comments"></span></li>
                        </ul>
                    </div>
                </div>

                <!-- Message d'erreur -->
                <div v-if="submitStatus.error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Erreur!</strong>
                    <span class="block sm:inline" v-text="submitStatus.error"></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Configuration d'Axios pour le CSRF
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const { createApp } = Vue

        createApp({
            data() {
                return {
                    userName: '',
                    recipientEmail: '',
                    items: @json($items),
                    isSubmitting: false,
                    submitStatus: {
                        success: false,
                        error: null,
                        message: '',
                        statistics: null
                    }
                }
            },
            computed: {
                isFormValid() {
                    return this.userName && 
                           this.recipientEmail && 
                           this.recipientEmail.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
                },
                categories() {
                    return [...new Set(this.items.map(item => item.category))];
                },
                presentCount() {
                    return this.items.filter(item => item.is_present).length;
                },
                commentCount() {
                    return this.items.filter(item => item.comment && item.comment.trim()).length;
                }
            },
            methods: {
                itemsByCategory(category) {
                    return this.items.filter(item => item.category === category);
                },
                resetSubmitStatus() {
                    this.submitStatus = {
                        success: false,
                        error: null,
                        message: '',
                        statistics: null
                    };
                },
                async submitChecklist() {
                    this.resetSubmitStatus();
                    this.isSubmitting = true;

                    try {
                        // Vérification des données requises
                        if (!this.userName.trim()) {
                            throw new Error('Veuillez entrer votre nom');
                        }
                        if (!this.recipientEmail.trim()) {
                            throw new Error('Veuillez entrer l\'email du destinataire');
                        }
                        if (!this.recipientEmail.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                            throw new Error('Veuillez entrer une adresse email valide');
                        }

                        // Préparation des données
                        const formData = {
                            user_name: this.userName,
                            recipient_email: this.recipientEmail,
                            items: this.items,
                            machineName: this.machineName,
                            commentAr: Array.from(document.querySelectorAll('textarea[name="commentAr[]"]')).map(textarea => textarea.value) // Collects all commentAr[] values
                        };

                        // Envoi de la requête
                        const response = await axios.post('/api/checklist', formData);

                        // Traitement de la réponse
                        this.submitStatus.success = true;
                        this.submitStatus.message = response.data.message;
                        this.submitStatus.statistics = response.data.statistics;

                        // Scroll vers le message de succès
                        setTimeout(() => {
                            window.scrollTo({
                                top: document.documentElement.scrollHeight,
                                behavior: 'smooth'
                            });
                        }, 100);

                    } catch (error) {
                        this.submitStatus.error = error.response?.data?.message || error.message || 'Une erreur est survenue lors de l\'envoi';
                        console.error('Erreur:', error);
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            }
        }).mount('#app')
    </script>
</body>
</html>
