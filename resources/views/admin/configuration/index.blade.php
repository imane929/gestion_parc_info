@extends('admin.layouts.admin')

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
                    <form action="{{ route('admin.configuration.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="organization_name" class="form-label">Nom de l'organisation</label>
                            <input type="text" class="form-control" 
                                   id="organization_name" name="organization_name" 
                                   value="{{ old('organization_name', $config['organization_name'] ?? 'Gestion Parc Informatique') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Email de contact</label>
                            <input type="email" class="form-control" 
                                   id="contact_email" name="contact_email" 
                                   value="{{ old('contact_email', $config['contact_email'] ?? 'contact@parc-info.com') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email_notifications" class="form-label">Notifications par email</label>
                            <select class="form-select" id="email_notifications" name="email_notifications" required>
                                <option value="1" {{ (old('email_notifications', $config['email_notifications'] ?? true) ? 'selected' : '') }}>Activées</option>
                                <option value="0" {{ (!old('email_notifications', $config['email_notifications'] ?? true) ? 'selected' : '') }}>Désactivées</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="auto_report" class="form-label">Rapport automatique</label>
                            <select class="form-select" id="auto_report" name="auto_report" required>
                                <option value="daily" {{ (old('auto_report', $config['auto_report'] ?? 'weekly') == 'daily' ? 'selected' : '') }}>Quotidien</option>
                                <option value="weekly" {{ (old('auto_report', $config['auto_report'] ?? 'weekly') == 'weekly' ? 'selected' : '') }}>Hebdomadaire</option>
                                <option value="monthly" {{ (old('auto_report', $config['auto_report'] ?? 'weekly') == 'monthly' ? 'selected' : '') }}>Mensuel</option>
                                <option value="none" {{ (old('auto_report', $config['auto_report'] ?? 'weekly') == 'none' ? 'selected' : '') }}>Aucun</option>
                            </select>
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
@endsection