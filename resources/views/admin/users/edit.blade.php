@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="{{ route('admin.users.index') }}" class="btn-outline mb-3">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        
        <div class="modern-card">
            <div class="card-header-modern">
                <h4 class="mb-0">Modifier l'utilisateur</h4>
            </div>
            <div class="p-4">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group-modern">
                        <label for="name" class="form-label-modern">Nom *</label>
                        <input type="text" class="form-input-modern @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="email" class="form-label-modern">Email *</label>
                        <input type="email" class="form-input-modern @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="password" class="form-label-modern">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                        <input type="password" class="form-input-modern @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="password_confirmation" class="form-label-modern">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-input-modern" 
                               id="password_confirmation" name="password_confirmation">
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="role" class="form-label-modern">Rôle *</label>
                        <select class="form-input-modern @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn-coral">
                        <i class="bi bi-check-lg"></i> Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
