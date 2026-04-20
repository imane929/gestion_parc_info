<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Contact | AssetFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-10 w-auto">
                <span class="text-xl font-bold text-blue-600">AssetFlow</span>
            </a>
            <a href="/" class="text-sm text-gray-500 hover:text-blue-600 transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Retour à l'accueil
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-8 py-16">
        <div class="grid lg:grid-cols-2 gap-16">
            <!-- Left Side - Info -->
            <div class="space-y-8">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Contactez-nous</h1>
                    <p class="text-lg text-gray-600">Vous avez une question ou besoin d'aide ? Remplissez le formulaire et nous vous répondrons dans les plus brefs délais.</p>
                </div>

                <div class="space-y-6">
                    <div class="flex items-start gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">assetflow.app@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 shrink-0">
                            <span class="material-symbols-outlined text-xl">phone</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Téléphone</h3>
                            <a href="tel:+212617824540" class="text-gray-600 hover:text-blue-600 transition-colors">+212 6 17 82 45 40</a>
                            <p class="text-sm text-gray-400 mt-1">Lun-Sam 9h-18h GMT</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 shrink-0">
                            <span class="material-symbols-outlined text-xl">location_on</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Adresse</h3>
                            <p class="text-gray-600">Casablanca Technopark</p>
                            <p class="text-gray-600">Casablanca, Maroc</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white rounded-3xl p-8 md:p-10 shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Envoyez-nous un message</h2>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3 text-green-700">
                        <span class="material-symbols-outlined">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3 text-red-700">
                        <span class="material-symbols-outlined">error</span>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center gap-3 text-red-700 mb-2">
                            <span class="material-symbols-outlined">error</span>
                            <span class="font-semibold">Erreur</span>
                        </div>
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Votre nom</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined">person</span>
                                </span>
                                <input type="text" name="nom" value="{{ old('nom') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition-all" placeholder="Votre nom complet"/>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Votre email</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined">email</span>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition-all" placeholder="votre@email.com"/>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Sujet</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <span class="material-symbols-outlined">subject</span>
                            </span>
                            <input type="text" name="sujet" value="{{ old('sujet') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition-all" placeholder="Objet de votre message"/>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Message</label>
                        <div class="relative">
                            <textarea name="message" rows="5" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-500/10 transition-all resize-none" placeholder="Décrivez votre demande ou question...">{{ old('message') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-blue-600 text-white font-semibold rounded-xl shadow-lg hover:bg-blue-700 hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span>
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-8 text-center">
            <p class="text-sm text-gray-500">© {{ date('Y') }} AssetFlow. Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>
