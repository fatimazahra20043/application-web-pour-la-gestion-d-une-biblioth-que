<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book.com - Find Your Next Read</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(180deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    
}
/* FIX navbar link red color on click / visited */
.container a,
.container a:visited,
.container a:active,
.container a:focus {
    color: var(--text-on-dark) !important;
    text-decoration: none;
    outline: none;
    box-shadow: none;
}

/* Hover & active state */
.container a:hover,
.container a.active {
    color: var(--coral) !important;
}

.container a onclick{
   text-decoration: none;
    
}

/* Header Styles */
.header {
    padding: 20px 0;
    background: transparent;
}

.header .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #1a1a1a;
}

.nav {
    display: flex;
    gap: 30px;
}

.nav-link {
    text-decoration: none;
    color: #6c757d;
    font-size: 15px;
    transition: color 0.3s;
}

.nav-link:hover {
    color: #1a1a1a;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.login-link {
    text-decoration: none;
    color: #1a1a1a;
    font-weight: 500;
}

.btn-primary {
    background: #f2eeeeff;
    
    color: black;
    border: none;
    padding: 12px 28px;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Hero Section */
.hero {
    padding: 60px 0;
}

.hero-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 60px;
}

.hero-content {
    flex: 1;
    max-width: 500px;
}

.hero-title {
    font-size: 52px;
    font-weight: bold;
    color: #1a1a1a;
    line-height: 1.2;
    margin-bottom: 20px;
}

.hero-subtitle {
    font-size: 16px;
    color: #6c757d;
    margin-bottom: 40px;
}

.search-box {
    display: flex;
    gap: 0;
    background: white;
    border-radius: 30px;
    padding: 6px 6px 6px 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.search-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 15px;
    padding: 10px 0;
    color: #1a1a1a;
}

.search-input::placeholder {
    color: #adb5bd;
}

.search-btn {
    background: #90c896;
    color: white;
    border: none;
    padding: 12px 32px;
    border-radius: 25px;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
}

.search-btn:hover {
    background: #7ab680;
}

/* Hero Image */
.hero-image {
    flex: 1;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 500px;
}

.book-image {
    max-width: 450px;
    width: 100%;
    height: auto;
    filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.15));
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* Floating Icons */
.floating-icon {
    position: absolute;
    width: 70px;
    height: 70px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    animation: bounce 2s ease-in-out infinite;
}

.icon-brain {
    background: #90c896;
    top: 10%;
    left: 20%;
    animation-delay: 0s;
}

.icon-target {
    background: #f4a261;
    bottom: 25%;
    left: 10%;
    animation-delay: 0.5s;
}

.icon-award {
    background: #b8b8d8;
    top: 20%;
    right: 15%;
    animation-delay: 1s;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-15px);
    }
}

/* Responsive Design */
@media (max-width: 968px) {
    .nav {
        display: none;
    }
    
    .hero-container {
        flex-direction: column;
        text-align: center;
    }
    
    .hero-content {
        max-width: 100%;
    }
    
    .hero-title {
        font-size: 38px;
    }
    
    .book-image {
        max-width: 350px;
    }
    
    .floating-icon {
        width: 60px;
        height: 60px;
    }
}

@media (max-width: 576px) {
    .hero-title {
        font-size: 32px;
    }
    
    .search-box {
        flex-direction: column;
        padding: 12px;
        gap: 10px;
    }
    
    .search-btn {
        width: 100%;
    }
}
    </style>
    </head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">UniversityBooks</div>
            <nav class="nav">
                <a href="<?php echo e(route('login')); ?>" class="nav-link">Book Type</a>
                <a href="<?php echo e(route('login')); ?>" class="nav-link">ReserveBook</a>
                <a href="<?php echo e(route('login')); ?>" class="nav-link">seeBooks</a>
                
            </nav>
            <div class="header-actions">
                <a href="<?php echo e(route('login')); ?>" class="login-link">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="btn-primary">Sign Up</a>
                
            </div>
        </div>
    </header>

    <main class="hero">
        <div class="container hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Find the book you're looking for easier to read.</h1>
                <p class="hero-subtitle">The most appropriate book site to reach books</p>
                <div class="search-box">
                    <input type="text" placeholder="Find your favorite book here..." class="search-input">
                    <button class="search-btn"><a href="<?php echo e(route('login')); ?>">Search</a></button>
                </div>
            </div>

            <div class="hero-image">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image_2025-12-20_220603397-removebg-preview-tgTtiuqFUwDT9AY3s97bw5XG1oRrDe.png" alt="Open Book" class="book-image">
                
                <div class="floating-icon icon-brain">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M20 10C15 10 12 13 12 16C12 19 15 22 20 22C25 22 28 19 28 16C28 13 25 10 20 10Z" fill="white"/>
                        <circle cx="16" cy="18" r="1.5" fill="white"/>
                        <circle cx="24" cy="18" r="1.5" fill="white"/>
                    </svg>
                </div>
                
                <div class="floating-icon icon-target">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="20" r="8" stroke="white" stroke-width="2" fill="none"/>
                        <circle cx="20" cy="20" r="4" fill="white"/>
                    </svg>
                </div>
                
                <div class="floating-icon icon-award">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <circle cx="20" cy="18" r="7" stroke="white" stroke-width="2" fill="none"/>
                        <path d="M15 22L13 30L20 26L27 30L25 22" stroke="white" stroke-width="2" fill="none"/>
                    </svg>
                </div>
            </div>
        </div>
    </main>
</body>
</html><?php /**PATH C:\laravel_projects\v1\resources\views/welcome.blade.php ENDPATH**/ ?>