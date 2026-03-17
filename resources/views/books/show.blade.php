@extends('layouts.app')

@section('title', $book->title)
@section('page-title', 'Détails du livre')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Retour au catalogue
        </a>
        
        <div class="card">
            <div class="card-body p-4">
                <!-- Fixed image path to use asset() and check file existence -->
                @if($book->cover_image && file_exists(public_path($book->cover_image)))
                    <div class="text-center mb-4">
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="img-fluid rounded" style="max-height: 400px;">
                    </div>
                @else
                    <div class="text-center mb-4">
                        <div class="book-placeholder-large">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                @endif
                
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <span class="badge bg-primary mb-2">{{ $book->category->name }}</span>
                        <h2 class="fw-bold mb-0">{{ $book->title }}</h2>
                    </div>
                    @if($book->available > 0)
                        <span class="badge bg-success fs-6">Disponible ({{ $book->available }})</span>
                    @else
                        <span class="badge bg-danger fs-6">Indisponible</span>
                    @endif
                </div>
                
                <div class="mb-4">
                    <h5 class="text-muted mb-3">
                        <i class="bi bi-person"></i> Par {{ $book->author }}
                    </h5>
                    <p class="text-muted">
                        <i class="bi bi-upc"></i> ISBN: {{ $book->isbn }}
                    </p>
                </div>
                
                @if($book->description)
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Description</h5>
                        <p class="text-muted">{{ $book->description }}</p>
                    </div>
                @endif
                
                <!-- Added reservation form with dates -->
                <div class="d-flex gap-3 flex-column flex-md-row">
                    @if($book->available > 0)
                        <form method="POST" action="{{ route('reservations.store', $book) }}" class="flex-fill">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Date de début</label>
                                    <input type="date" name="start_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Date de fin</label>
                                    <input type="date" name="end_date" class="form-control" required min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-calendar-check"></i> Réserver ce livre
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="bi bi-x-circle"></i> Livre indisponible
                        </button>
                    @endif
                    
                    @if($book->isFavoritedBy(auth()->id()))
                        <form method="POST" action="{{ route('favorites.destroy', $book) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-heart-fill"></i> Retirer des favoris
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favorites.store', $book) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-heart"></i> Ajouter aux favoris
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
