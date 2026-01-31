<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - Gestion Parc Informatique</title>

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
            max-width: 1000px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        
        .info-section {
            color: white;
            padding: 40px;
        }
        
        .info-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .info-section p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }
        
        .benefits {
            list-style: none;
            margin-top: 30px;
        }
        
        .benefits li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }
        
        .benefits li i {
            color: #10b981;
            margin-right: 15px;
            font-size: 1.2rem;
        }
        
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .register-header {
            background: linear-gradient(to right, #10b981, #3b82f6);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .register-header .logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2rem;
        }
        
        .register-body {
            padding: 30px;
        }
        
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1rem;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .select-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s;
            background: white;
            cursor: pointer;
        }
        
        .select-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(to right, #10b981, #3b82f6);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        }
        
        .btn-register i {
            margin-right: 10px;
        }
        
        .password-strength {
            margin-top: 5px;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background-color 0.3s;
        }
        
        .strength-text {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }
        
        .terms {
            display: flex;
            align-items: flex-start;
            margin: 20px 0;
        }
        
        .terms input {
            margin-top: 3px;
            margin-right: 10px;
        }
        
        .terms label {
            font-size: 14px;
            color: #4b5563;
        }
        
        .terms a {
            color: #3b82f6;
            text-decoration: none;
        }
        
        .terms a:hover {
            text-decoration: underline;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        
        .login-link a {
            color: #3b82f6;
            font-weight: 600;
            text-decoration: none;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #ef4444;
            font-size: 12px;
            margin-top: 5px;
            display: flex;
            align-items: center;
        }
        
        .error-message i {
            margin-right: 5px;
        }
        
        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            
            .info-section {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <!-- Info Section -->
        <div class="info-section">
            <div class="logo-container mb-6">
                <div style="width: 80px; height: 80px; background: rgba(255, 255, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i class="fas fa-user-plus text-3xl"></i>
                </div>
            </div>
            
            <h1>Rejoignez notre plateforme</h1>
            <p>Créez votre compte pour accéder au système de gestion de parc informatique. Gérez vos équipements, suivez les maintenances et optimisez vos ressources.</p>
            
            <ul class="benefits">
                <li><i class="fas fa-check-circle"></i> Gestion simplifiée des équipements</li>
                <li><i class="fas fa-check-circle"></i> Suivi en temps réel des tickets</li>
                <li><i class="fas fa-check-circle"></i> Historique complet des interventions</li>
                <li><i class="fas fa-check-circle"></i> Rapports détaillés exportables</li>
                <li><i class="fas fa-check-circle"></i> Support technique dédié</li>
            </ul>
            
            <div class="mt-8 p-4 bg-white/10 rounded-xl">
                <p class="text-lg font-semibold mb-2">🏆 Solution primée</p>
                <p class="opacity-90">Reconnue comme la meilleure solution de gestion de parc informatique pour les PME.</p>
            </div>
        </div>
        
        <!-- Register Card -->
        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2 class="text-xl font-bold">Créer un compte</h2>
                <p class="opacity-90 mt-1">Commencez dès maintenant</p>
            </div>
            
            <!-- Form -->
            <div class="register-body">
                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded-lg">
                        <div class="flex items-center mb-1">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span class="font-semibold">Erreurs de validation :</span>
                        </div>
                        <ul class="list-disc list-inside text-sm ml-6">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <!-- Name -->
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               class="form-input" 
                               placeholder="Nom complet"
                               value="{{ old('name') }}"
                               required 
                               autofocus>
                    </div>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Email -->
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               class="form-input" 
                               placeholder="Adresse email"
                               value="{{ old('email') }}"
                               required>
                    </div>
                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Role -->
                    <div class="input-group">
                        <select name="role" id="role" class="select-input" required>
                            <option value="">Sélectionnez votre rôle</option>
                            <option value="technicien" {{ old('role') == 'technicien' ? 'selected' : '' }}>Technicien</option>
                            <option value="utilisateur" {{ old('role') == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                        </select>
                    </div>
                    <p class="text-xs text-gray-500 mb-4">Note : Le rôle "Administrateur" ne peut être attribué que par un admin existant</p>
                    
                    <!-- Password -->
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password" 
                               id="password" 
                               class="form-input" 
                               placeholder="Mot de passe (min. 8 caractères)"
                               required 
                               autocomplete="new-password">
                    </div>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-text" id="strengthText">Faible</div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Confirm Password -->
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation" 
                               class="form-input" 
                               placeholder="Confirmer le mot de passe"
                               required 
                               autocomplete="new-password">
                    </div>
                    
                    <!-- Terms -->
                    <div class="terms">
                        <input type="checkbox" 
                               name="terms" 
                               id="terms"
                               required>
                        <label for="terms">
                            J'accepte les <a href="#">conditions d'utilisation</a> et la <a href="#">politique de confidentialité</a>
                        </label>
                    </div>
                    @error('terms')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>{{ $message }}
                        </div>
                    @enderror
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i>Créer mon compte
                    </button>
                </form>
                
                <!-- Login Link -->
                <div class="login-link">
                    <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 20;
                if (password.length >= 12) strength += 10;
                
                // Mixed case check
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 20;
                
                // Numbers check
                if (/\d/.test(password)) strength += 20;
                
                // Special characters check
                if (/[^A-Za-z0-9]/.test(password)) strength += 20;
                
                // Multiple numbers/special chars
                if ((password.match(/\d/g) || []).length >= 2) strength += 10;
                if ((password.match(/[^A-Za-z0-9]/g) || []).length >= 2) strength += 10;
                
                // Cap at 100
                strength = Math.min(strength, 100);
                
                // Update UI
                strengthBar.style.width = strength + '%';
                
                // Set color and text
                if (strength < 30) {
                    strengthBar.style.backgroundColor = '#ef4444';
                    strengthText.textContent = 'Faible';
                    strengthText.style.color = '#ef4444';
                } else if (strength < 70) {
                    strengthBar.style.backgroundColor = '#f59e0b';
                    strengthText.textContent = 'Moyen';
                    strengthText.style.color = '#f59e0b';
                } else {
                    strengthBar.style.backgroundColor = '#10b981';
                    strengthText.textContent = 'Fort';
                    strengthText.style.color = '#10b981';
                }
            });
            
            // Confirm password validation
            const confirmPasswordInput = document.getElementById('password_confirmation');
            
            function validatePasswordMatch() {
                if (passwordInput.value && confirmPasswordInput.value) {
                    if (passwordInput.value !== confirmPasswordInput.value) {
                        confirmPasswordInput.style.borderColor = '#ef4444';
                    } else {
                        confirmPasswordInput.style.borderColor = '#10b981';
                    }
                }
            }
            
            passwordInput.addEventListener('input', validatePasswordMatch);
            confirmPasswordInput.addEventListener('input', validatePasswordMatch);
            
            // Email validation
            const emailInput = document.getElementById('email');
            
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
        });
    </script>
</body>
</html>