@extends('layouts.app')

@section('title', 'Inscription - Fluipedia')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="bi bi-book-fill"></i>
                    <span>UniversityBooks</span>
                </div>
                <h2 class="auth-title">Créer un compte</h2>
                <p class="auth-subtitle">Rejoignez notre bibliothèque en ligne</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nom complet</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Jean Dupont" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="votre@email.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" 
                           id="password_confirmation" name="password_confirmation" 
                           placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-4">
                    <i class="bi bi-check-circle"></i> Créer mon compte
                </button>

                <div class="text-center">
                    <p class="mb-0" style="color: var(--text-secondary);">
                        Déjà inscrit ? 
                        <a href="{{ route('login') }}" class="auth-link">Se connecter</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
