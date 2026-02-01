@extends('layouts.admin')

@section('title', 'Configuration du Système')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Configuration du Système</h5>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif
                    
                    <form action="{{ route('admin.configuration.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Nom de l'organisation</label>
                            <input type="text" class="form-control @error('organization_name') is-invalid @enderror" 
                                   id="organization_name" name="organization_name" 
                                   value="{{ old('organization_name', $config['organization_name'] ?? 'Gestion Parc Informatique') }}" required>
                            @error('organization_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Email de contact</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                   id="contact_email" name="contact_email" 
                                   value="{{ old('contact_email', $config['contact_email'] ?? 'contact@parc-info.com') }}" required>
                            @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email_notifications" class="form-label">Notifications par email</label>
                            <select class="form-select @error('email_notifications') is-invalid @enderror" 
                                    id="email_notifications" name="email_notifications" required>
                                <option value="1" {{ (old('email_notifications', $config['email_notifications'] ?? true) == '1' || old('email_notifications', $config['email_notifications'] ?? true) == true) ? 'selected' : '' }}>Activées</option>
                                <option value="0" {{ (old('email_notifications', $config['email_notifications'] ?? true) == '0' || old('email_notifications', $config['email_notifications'] ?? true) == false) ? 'selected' : '' }}>Désactivées</option>
                            </select>
                            @error('email_notifications')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="auto_report" class="form-label">Rapport automatique</label>
                            <select class="form-select @error('auto_report') is-invalid @enderror" 
                                    id="auto_report" name="auto_report" required>
                                <option value="daily" {{ old('auto_report', $config['auto_report'] ?? 'weekly') == 'daily' ? 'selected' : '' }}>Quotidien</option>
                                <option value="weekly" {{ old('auto_report', $config['auto_report'] ?? 'weekly') == 'weekly' ? 'selected' : '' }} selected>Hebdomadaire</option>
                                <option value="monthly" {{ old('auto_report', $config['auto_report'] ?? 'weekly') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                <option value="none" {{ old('auto_report', $config['auto_report'] ?? 'weekly') == 'none' ? 'selected' : '' }}>Aucun</option>
                            </select>
                            @error('auto_report')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection