@extends('layouts.app')

@section('title', 'Gestion des réservations')
@section('page-title', 'Gestion des réservations')

@section('content')
<!-- Added search by code form -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">
                    <i class="bi bi-search"></i> Rechercher par code
                </h5>
                <form method="POST" action="{{ route('admin.reservations.search') }}" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="code" class="form-control" placeholder="Entrer le code de réservation" maxlength="8" required>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Chercher
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Livre</th>
                        <th>Date réservation</th>
                        <th>Période</th>
                        <th>Statut</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>
                                <a href="{{ route('admin.users.show', $reservation->user) }}" class="text-decoration-none">
                                    {{ $reservation->user->name }}
                                </a>
                            </td>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                            <td>
                                @if($reservation->start_date && $reservation->end_date)
                                    {{ $reservation->start_date->format('d/m/Y') }} - {{ $reservation->end_date->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($reservation->status === 'confirmed')
                                    <span class="badge bg-success">Confirmée</span>
                                    @if($reservation->isLate())
                                        <span class="badge bg-danger ms-1">En retard ({{ $reservation->getDaysLate() }}j)</span>
                                    @endif
                                @elseif($reservation->status === 'cancelled')
                                    <span class="badge bg-danger">Annulée</span>
                                @else
                                    <span class="badge bg-secondary">Retournée</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->confirmation_code)
                                    <code class="fw-bold">{{ $reservation->confirmation_code }}</code>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($reservation->status === 'pending')
                                        <form method="POST" action="{{ route('admin.reservations.confirm', $reservation) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $reservation->id }}">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    @elseif($reservation->status === 'confirmed')
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#returnModal{{ $reservation->id }}">
                                            <i class="bi bi-box-arrow-in-down"></i> Retour
                                        </button>
                                    @endif
                                </div>
                                
                                <!-- Cancel Modal -->
                                @if($reservation->status === 'pending')
                                    <div class="modal fade" id="cancelModal{{ $reservation->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Refuser la réservation</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form method="POST" action="{{ route('admin.reservations.cancel', $reservation) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Motif de refus *</label>
                                                            <select name="refusal_reason" class="form-select" required>
                                                                <option value="">Sélectionner un motif</option>
                                                                <option value="Retards fréquents de l'utilisateur">Retards fréquents de l'utilisateur</option>
                                                                <option value="Livres rendus en mauvais état">Livres rendus en mauvais état</option>
                                                                <option value="Livre temporairement indisponible">Livre temporairement indisponible</option>
                                                                <option value="Livre définitivement indisponible">Livre définitivement indisponible</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Notes administratives</label>
                                                            <textarea name="admin_notes" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger">Refuser</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Return Modal -->
                                @if($reservation->status === 'confirmed')
                                    <div class="modal fade" id="returnModal{{ $reservation->id }}" tabindex="-1">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Aucune réservation trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $reservations->links() }}
</div>
@endsection
