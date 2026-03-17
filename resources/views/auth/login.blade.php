@extends('layouts.app')

@section('title', 'Connexion - Fluipedia')

@section('content')
<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="bi bi-book-fill"></i>
                    <span>UniversityBooks</span>
                </div>
                <h2 class="auth-title">Bienvenue</h2>
                <p class="auth-subtitle">Connectez-vous pour accéder à votre bibliothèque</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="votre@email.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-4">
                    <i class="bi bi-box-arrow-in-right"></i> Se connecter
                </button>

                <div class="text-center">
                    <p class="mb-0" style="color: var(--text-secondary);">
                        Pas encore de compte ? 
                        <a href="{{ route('register') }}" class="auth-link">S'inscrire</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
