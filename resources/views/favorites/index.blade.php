@extends('layouts.app')

@section('title', 'Mes favoris')

@section('content')
<h1 class="page-title mb-4"><i class="bi bi-heart-fill"></i> Mes favoris</h1>

<div class="books-grid">
    @forelse($favorites as $favorite)
        <div class="book-card">
            <!-- Fixed image path to use asset() and check file existence -->
            <div class="book-cover">
                @if($favorite->book->cover_image && file_exists(public_path($favorite->book->cover_image)))
                    <img src="{{ asset($favorite->book->cover_image) }}" alt="{{ $favorite->book->title }}" class="img-fluid">
                @else
                    <div class="book-placeholder">
                        <i class="bi bi-book"></i>
                    </div>
                @endif
            </div>
            <div class="book-info">
                <div class="book-badges">
                    <span class="badge-navy">{{ $favorite->book->category->name }}</span>
                </div>
                
                <h5 class="book-title">{{ $favorite->book->title }}</h5>
                <p class="book-author">
                    <i class="bi bi-person"></i> {{ $favorite->book->author }}
                </p>
                
                <div class="book-actions">
                    <a href="{{ route('books.show', $favorite->book) }}" class="btn btn-primary btn-sm flex-fill">
                        <i class="bi bi-eye"></i> Voir
                    </a>
                    
                    <form method="POST" action="{{ route('favorites.destroy', $favorite->book) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Vous n'avez pas encore de livres favoris.
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $favorites->links() }}
</div>
@endsection
