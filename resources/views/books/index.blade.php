@extends('layouts.app')

@section('title', 'Catalogue des livres')

@section('content')
<!-- Added hero section inspired by reference image -->
<div class="hero-section">
    <div class="hero-content">
        <p class="hero-subtitle">Découvrez notre collection</p>
        <h1 class="hero-title">The more that you read,<br>the more things you'll know.</h1>
        <p class="hero-subtitle" style="font-style: italic; margin-top: 1rem;">
            "The more that you learn, the more places you'll go."
        </p>
    </div>
</div>

<!-- Updated search section with new card design -->
<div class="search-section">
    <form method="GET" action="{{ route('books.index') }}">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" 
                       placeholder="🔍 Rechercher un livre par titre..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">📚 Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    Rechercher
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Added category cards section -->
@if(!request('search') && !request('category'))
<div class="mb-5">
    <h2 class="section-title">Explore Categories</h2>
    <p class="section-subtitle">Browse books by category</p>
    
    <div class="category-grid">
        @foreach($categories->take(6) as $category)
            <a href="{{ route('books.index', ['category' => $category->id]) }}" class="text-decoration-none">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="bi bi-bookmark-fill"></i>
                    </div>
                    <p class="category-name">{{ $category->name }}</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif

<!-- Updated books display with new card design -->
<div class="mb-4">
    <h2 class="section-title">{{ request('search') || request('category') ? 'Résultats de recherche' : 'What Will You Discover?' }}</h2>
    <p class="section-subtitle">{{ $books->total() }} livre(s) disponible(s)</p>
</div>

<div class="books-grid">
    @forelse($books as $book)
        <div class="book-card">
            <!-- Replace missing book images with book icon -->
            <div class="book-cover">
                @if($book->cover_image && file_exists(public_path($book->cover_image)))
                    <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid">
                @else
                    <div class="book-placeholder">
                        <i class="bi bi-book"></i>
                    </div>
                @endif
            </div>
            
            <div class="book-info">
                <div class="book-badges">
                    <span class="badge bg-primary">{{ $book->category->name }}</span>
                    @if($book->available > 0)
                        <span class="badge bg-success">Disponible</span>
                    @else
                        <span class="badge bg-danger">Indisponible</span>
                    @endif
                </div>
                
                <h5 class="book-title">{{ Str::limit($book->title, 40) }}</h5>
                <p class="book-author">
                    <i class="bi bi-person-fill"></i> {{ $book->author }}
                </p>
                
                @if($book->description)
                    <p class="book-description">
                        {{ Str::limit($book->description, 80) }}
                    </p>
                @endif
                
                <div class="book-actions">
                    <a href="{{ route('books.show', $book) }}" class="btn btn-outline-primary btn-sm flex-fill">
                        <i class="bi bi-eye"></i> Détails
                    </a>
                    
                    @if($book->isFavoritedBy(auth()->id()))
                        <form method="POST" action="{{ route('favorites.destroy', $book) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-heart-fill"></i>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorites.store', $book) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-heart"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> Aucun livre trouvé pour votre recherche.
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $books->links() }}
</div>
@endsection
