<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliothèque')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    @auth
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.querySelector('.mobile-menu-toggle');
        const menu = document.querySelector('.navbar-menu');

        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                menu.classList.toggle('show');
});
}
});
</script>

        <!-- Updated navbar with correct CSS classes -->
        <nav class="top-navbar">
            <div class="navbar-container">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('books.index') }}" class="navbar-brand">
                    <i class="bi bi-book-fill"></i>
                    <span>Bibliothèque</span>
                </a>

                <ul class="navbar-menu">
                    @if(auth()->user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a></li>
                        <li><a href="{{ route('admin.books.index') }}" class="{{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                            <i class="bi bi-book"></i> Livres
                        </a></li>
                        
                        <li><a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-check"></i> Réservations
                        </a></li>
                        <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="bi bi-people"></i> Utilisateurs
                        </a></li>
                    @else
                        <li><a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'active' : '' }}">
                            <i class="bi bi-book"></i> Catalogue
                        </a></li>
                        <li><a href="{{ route('reservations.index') }}" class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-check"></i> Mes Réservations
                        </a></li>
                        <li><a href="{{ route('favorites.index') }}" class="{{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                            <i class="bi bi-heart-fill"></i> Favoris
                        </a></li>
                        <li><a href="{{ route('notifications.index') }}" class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                            <i class="bi bi-bell-fill"></i> Notifications
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="badge bg-danger rounded-pill ms-1">{{ auth()->user()->unreadNotifications()->count() }}</span>
                            @endif
                        </a></li>
                    @endif
                </ul>

                <div class="user-dropdown dropdown">
                    <div class="user-trigger" data-bs-toggle="dropdown">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <button class="mobile-menu-toggle">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </nav>
    @endauth

    <!-- Main container -->
    <div class="main-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Added footer section -->
    @auth
        <footer class="app-footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h4 class="footer-title"><i class="bi bi-book-fill"></i> Bibliothèque</h4>
                        <p class="footer-text">Votre système de gestion de bibliothèque moderne et efficace.</p>
                    </div>
                    
                    <div class="footer-section">
                        <h5 class="footer-heading">Navigation</h5>
                        <ul class="footer-links">
                            @if(auth()->user()->role === 'admin')
                                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('admin.books.index') }}">Livres</a></li>
                                <li><a href="{{ route('admin.reservations.index') }}">Réservations</a></li>
                            @else
                                <li><a href="{{ route('books.index') }}">Catalogue</a></li>
                                <li><a href="{{ route('reservations.index') }}">Mes Réservations</a></li>
                                <li><a href="{{ route('favorites.index') }}">Favoris</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h5 class="footer-heading">Contact</h5>
                        <ul class="footer-contact">
                            <li><i class="bi bi-envelope"></i> contact@bibliotheque.com</li>
                            <li><i class="bi bi-telephone"></i> +212 123 456 789</li>
                            <li><i class="bi bi-geo-alt"></i> Casablanca, Maroc</li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Bibliothèque. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
