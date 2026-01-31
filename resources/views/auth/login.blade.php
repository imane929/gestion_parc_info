<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Gestion Parc Informatique</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Figtree', sans-serif;
        }
        
        .auth-container {
            width: 100%;
            max-width: 1200px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        
        .welcome-section {
            color: white;
            padding: 40px;
        }
        
        .welcome-section h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .welcome-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .features-list {
            list-style: none;
            margin-top: 30px;
        }
        
        .features-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 1.1rem;
        }
        
        .features-list li i {
            color: #10b981;
            margin-right: 15px;
            font-size: 1.3rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .login-header {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            padding: 40px;
            text-align: center;
            color: white;
        }
        
        .login-header .logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2.5rem;
        }
        
        .login-body {
            padding: 40px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 25px;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1.1rem;
        }
        
        .form-input {
            width: 100%;
            padding: 15px 15px 15px 50px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s;
            background: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }
        
        .btn-login i {
            margin-right: 10px;
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            font-size: 14px;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 5px;
        }
        
        .demo-credentials {
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(to right, #f0f9ff, #fef7ff);
            border-radius: 12px;
            border-left: 4px solid #8b5cf6;
        }
        
        .demo-credentials h4 {
            color: #6d28d9;
            margin-bottom: 10px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        
        .demo-credentials h4 i {
            margin-right: 8px;
        }
        
        .credential-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        
        .credential-role {
            font-weight: 600;
            color: #4b5563;
        }
        
        .credential-details {
            color: #6b7280;
        }
        
        @media (max-width: 968px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            
            .welcome-section {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="logo-container mb-8">
                <div style="width: 100px; height: 100px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i class="fas fa-laptop-house text-4xl"></i>
                </div>
            </div>
            
            <h1>Gestion Parc Informatique</h1>
            <p>Système complet de gestion des équipements informatiques, maintenance et utilisateurs pour votre organisation.</p>
            
            <ul class="features-list">
                <li><i class="fas fa-check-circle"></i> Gestion centralisée des équipements</li>
                <li><i class="fas fa-check-circle"></i> Suivi des tickets de maintenance</li>
                <li><i class="fas fa-check-circle"></i> Historique des interventions</li>
                <li><i class="fas fa-check-circle"></i> Rapports et statistiques</li>
                <li><i class="fas fa-check-circle"></i> Multi-rôles (Admin, Technicien, Utilisateur)</li>
            </ul>
            
            <div class="mt-8 p-4 bg-white/10 rounded-xl">
                <p class="text-lg font-semibold mb-2">📊 100+ équipements gérés</p>
                <p class="opacity-90">Rejoignez les organisations qui optimisent leur parc informatique avec notre solution.</p>
            </div>
        </div>
        
        <!-- Login Card -->
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <h2 class="text-2xl font-bold">Connexion</h2>
                <p class="opacity-90 mt-2">Accédez à votre espace</p>
            </div>
            
            <!-- Form -->
            <div class="login-body">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('status') }}
                    </div>
                @endif
                
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="font-semibold">Veuillez corriger les erreurs suivantes :</span>
                        </div>
                        <ul class="list-disc list-inside text-sm ml-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-input" 
                               placeholder="Adresse email professionnelle"
                               value="{{ old('email') }}"
                               required 
                               autofocus>
                    </div>
                    
                    <!-- Password -->
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-input" 
                               placeholder="Mot de passe"
                               required 
                               autocomplete="current-password">
                    </div>
                    
                    <!-- Remember Me & Forgot Password -->
                    <div class="form-footer">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="remember" 
                                   id="remember"
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">Se souvenir de moi</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn-login mt-6">
                        <i class="fas fa-sign-in-alt"></i>Se connecter
                    </button>
                </form>
                
                <!-- Demo Credentials -->
                <div class="demo-credentials">
                    <h4><i class="fas fa-key"></i> Accès de démonstration</h4>
                    <div class="credential-item">
                        <span class="credential-role">Administrateur :</span>
                        <span class="credential-details">admin@parc.com / password</span>
                    </div>
                    <div class="credential-item">
                        <span class="credential-role">Technicien :</span>
                        <span class="credential-details">tech@parc.com / password</span>
                    </div>
                    <div class="credential-item">
                        <span class="credential-role">Utilisateur :</span>
                        <span class="credential-details">user@parc.com / password</span>
                    </div>
                </div>
                
                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-gray-600">
                        Pas encore de compte ?
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-semibold ml-1">
                            Créer un compte
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus on email field
            document.getElementById('email').focus();
            
            // Add real-time validation
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }
            
            emailInput.addEventListener('blur', function() {
                if (this.value && !validateEmail(this.value)) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#e5e7eb';
                }
            });
            
            // Show/hide password
            const showPasswordBtn = document.createElement('button');
            showPasswordBtn.type = 'button';
            showPasswordBtn.innerHTML = '<i class="fas fa-eye"></i>';
            showPasswordBtn.style.cssText = `
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #6b7280;
                cursor: pointer;
            `;
            
            passwordInput.parentNode.appendChild(showPasswordBtn);
            
            showPasswordBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            });
        });
    </script>
</body>
</html>