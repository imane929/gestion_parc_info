<div class="row g-4">
    <!-- Inventory Code -->
    <div class="col-md-4">
        <label class="form-label">Inventory Code <span class="text-danger">*</span></label>
        <input type="text" name="code_inventaire" class="form-control @error('code_inventaire') is-invalid @enderror" 
               value="{{ old('code_inventaire', $actif->code_inventaire ?? '') }}" 
               {{ isset($actif) ? 'readonly' : '' }} required>
        @error('code_inventaire')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <small class="text-muted">Format: INV-XXXXX</small>
    </div>
    
    <!-- Type -->
    <div class="col-md-4">
        <label class="form-label">Type <span class="text-danger">*</span></label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            <option value="">Select...</option>
            <option value="pc" {{ old('type', $actif->type ?? '') == 'pc' ? 'selected' : '' }}>PC</option>
            <option value="serveur" {{ old('type', $actif->type ?? '') == 'serveur' ? 'selected' : '' }}>Server</option>
            <option value="imprimante" {{ old('type', $actif->type ?? '') == 'imprimante' ? 'selected' : '' }}>Printer</option>
            <option value="reseau" {{ old('type', $actif->type ?? '') == 'reseau' ? 'selected' : '' }}>Network Equipment</option>
            <option value="peripherique" {{ old('type', $actif->type ?? '') == 'peripherique' ? 'selected' : '' }}>Peripheral</option>
            <option value="mobile" {{ old('type', $actif->type ?? '') == 'mobile' ? 'selected' : '' }}>Mobile Device</option>
            <option value="autre" {{ old('type', $actif->type ?? '') == 'autre' ? 'selected' : '' }}>Other</option>
        </select>
        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- State -->
    <div class="col-md-4">
        <label class="form-label">State <span class="text-danger">*</span></label>
        <select name="etat" class="form-select @error('etat') is-invalid @enderror" required>
            <option value="">Select...</option>
            <option value="neuf" {{ old('etat', $actif->etat ?? '') == 'neuf' ? 'selected' : '' }}>New</option>
            <option value="bon" {{ old('etat', $actif->etat ?? '') == 'bon' ? 'selected' : '' }}>Good</option>
            <option value="moyen" {{ old('etat', $actif->etat ?? '') == 'moyen' ? 'selected' : '' }}>Average</option>
            <option value="mauvais" {{ old('etat', $actif->etat ?? '') == 'mauvais' ? 'selected' : '' }}>Poor</option>
            <option value="hors_service" {{ old('etat', $actif->etat ?? '') == 'hors_service' ? 'selected' : '' }}>Out of Service</option>
        </select>
        @error('etat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Brand -->
    <div class="col-md-4">
        <label class="form-label">Brand <span class="text-danger">*</span></label>
        <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror" 
               value="{{ old('marque', $actif->marque ?? '') }}" required>
        @error('marque')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Model -->
    <div class="col-md-4">
        <label class="form-label">Model <span class="text-danger">*</span></label>
        <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror" 
               value="{{ old('modele', $actif->modele ?? '') }}" required>
        @error('modele')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Serial Number -->
    <div class="col-md-4">
        <label class="form-label">Serial Number <span class="text-danger">*</span></label>
        <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
               value="{{ old('numero_serie', $actif->numero_serie ?? '') }}" {{ isset($actif) ? 'readonly' : '' }} required>
        @error('numero_serie')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Purchase Date -->
    <div class="col-md-4">
        <label class="form-label">Purchase Date</label>
        <input type="date" name="date_achat" class="form-control @error('date_achat') is-invalid @enderror" 
               value="{{ old('date_achat', isset($actif) && $actif->date_achat ? $actif->date_achat->format('Y-m-d') : '') }}">
        @error('date_achat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Warranty End -->
    <div class="col-md-4">
        <label class="form-label">Warranty End Date</label>
        <input type="date" name="garantie_fin" class="form-control @error('garantie_fin') is-invalid @enderror" 
               value="{{ old('garantie_fin', isset($actif) && $actif->garantie_fin ? $actif->garantie_fin->format('Y-m-d') : '') }}">
        @error('garantie_fin')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Location -->
    <div class="col-md-4">
        <label class="form-label">Location</label>
        <select name="localisation_id" class="form-select select2 @error('localisation_id') is-invalid @enderror">
            <option value="">Select...</option>
            @foreach($localisations as $localisation)
                <option value="{{ $localisation->id }}" {{ old('localisation_id', $actif->localisation_id ?? '') == $localisation->id ? 'selected' : '' }}>
                    {{ $localisation->nom_complet }}
                </option>
            @endforeach
        </select>
        @error('localisation_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    
    <!-- Assignment -->
    @if(!isset($actif) || !$actif->utilisateurAffecte)
    <div class="col-12">
        <hr>
        <h6>Initial Assignment (optional)</h6>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Assign To</label>
        <select name="utilisateur_affecte_id" class="form-select select2">
            <option value="">Not assigned</option>
            @foreach($utilisateurs as $user)
                <option value="{{ $user->id }}" {{ old('utilisateur_affecte_id', $actif->utilisateur_affecte_id ?? '') == $user->id ? 'selected' : '' }}>
                    {{ $user->full_name ?? $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Assignment Date</label>
        <input type="date" name="date_affectation" class="form-control" value="{{ now()->format('Y-m-d') }}">
    </div>
    @endif
    
    <!-- Description / Notes -->
    <div class="col-12">
        <label class="form-label">Notes / Description</label>
        <textarea name="description" class="form-control" rows="4">{{ old('description', $actif->description ?? '') }}</textarea>
    </div>
</div>

