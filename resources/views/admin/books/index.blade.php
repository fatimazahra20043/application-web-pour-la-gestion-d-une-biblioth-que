@extends('layouts.app')

@section('title', 'Gestion des livres')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fw-bold mb-0"><i class="bi bi-book"></i> Gestion des livres</h1>
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Ajouter un livre
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>ISBN</th>
                        <th>Catégorie</th>
                        <th>Quantité</th>
                        <th>Disponible</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="fw-semibold">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td><code>{{ $book->isbn }}</code></td>
                            <td><span class="badge bg-primary">{{ $book->category->name }}</span></td>
                            <td>{{ $book->quantity }}</td>
                            <td>
                                @if($book->available > 0)
                                    <span class="badge bg-success">{{ $book->available }}</span>
                                @else
                                    <span class="badge bg-danger">0</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('admin.books.destroy', $book) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucun livre trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $books->links() }}
</div>
@endsection
