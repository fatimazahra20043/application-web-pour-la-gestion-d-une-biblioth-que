@extends('layouts.app')

@section('title', 'Résultat de recherche')
@section('page-title', 'Résultat de recherche')

@section('content')
<a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left"></i> Retour aux réservations
</a>

<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-check-circle"></i> Réservation trouvée</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Code de confirmation</h6>
                <code class="fs-3 fw-bold">{{ $reservation->confirmation_code }}</code>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Statut</h6>
                @if($reservation->status === 'confirmed')
                    <span class="badge bg-success fs-5">Confirmée</span>
                @else
                    <span class="badge bg-secondary fs-5">{{ ucfirst($reservation->status) }}</span>
                @endif
            </div>
        </div>
        
        <hr>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <h6 class="text-muted">Utilisateur</h6>
                <p class="fs-5">{{ $reservation->user->name }}</p>
                <p class="text-muted">{{ $reservation->user->email }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Livre</h6>
                <p class="fs-5">{{ $reservation->book->title }}</p>
                <p class="text-muted">Par {{ $reservation->book->author }}</p>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <h6 class="text-muted">Date de début</h6>
                <p>{{ $reservation->start_date ? $reservation->start_date->format('d/m/Y') : '-' }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-muted">Date de fin</h6>
                <p>{{ $reservation->end_date ? $reservation->end_date->format('d/m/Y') : '-' }}</p>
            </div>
            <div class="col-md-4">
                <h6 class="text-muted">Créée le</h6>
                <p>{{ $reservation->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        
        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-primary">
                <i class="bi bi-eye"></i> Voir les détails
            </a>
            @if($reservation->status === 'confirmed')
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#returnModal">
                    <i class="bi bi-box-arrow-in-down"></i> Enregistrer le retour
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Return Modal -->
@if($reservation->status === 'confirmed')
    <div class="modal fade" id="returnModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Enregistrer le retour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('admin.reservations.return', $reservation) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">État du livre *</label>
                            <select name="book_condition" class="form-select" required>
                                <option value="good">Bon état</option>
                                <option value="damaged">Endommagé</option>
                                <option value="lost">Perdu</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes administratives</label>
                            <textarea name="admin_notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer le retour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection
