@extends('layouts.app')

@section('title', 'Détails de l\'utilisateur')

@section('content')
<div class="content-header mb-4">
    <div>
        <h1 class="page-title"><i class="bi bi-person-circle"></i> {{ $user->name }}</h1>
        <p class="text-muted">{{ $user->email }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-navy">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row g-4">
    <!-- User Statistics Card -->
    <div class="col-lg-8">
        <div class="modern-card mb-4">
            <h3 class="card-title"><i class="bi bi-graph-up"></i> Statistiques de l'utilisateur</h3>
            
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <p class="stat-label">Total réservations</p>
                            <h4 class="stat-value">{{ $userStats['total_reservations'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <p class="stat-label">Retours à temps</p>
                            <h4 class="stat-value">{{ $userStats['on_time_returns'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-box">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div>
                            <p class="stat-label">Retours en retard</p>
                            <h4 class="stat-value">{{ $userStats['late_returns'] }}</h4>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="stat-box">
                        <div class="stat-icon bg-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div>
                            <p class="stat-label">Livres endommagés</p>
                            <h4 class="stat-value">{{ $userStats['damaged_books'] }}</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-box">
                        <div class="stat-icon bg-dark">
                            <i class="bi bi-x-octagon"></i>
                        </div>
                        <div>
                            <p class="stat-label">Livres perdus</p>
                            <h4 class="stat-value">{{ $userStats['lost_books'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Statistics Button -->
            <button type="button" class="btn-coral mt-4" data-bs-toggle="modal" data-bs-target="#editStatisticsModal">
                <i class="bi bi-pencil"></i> Modifier les statistiques
            </button>
        </div>

        <!-- Reservation History -->
        <div class="modern-card">
            <h3 class="card-title"><i class="bi bi-clock-history"></i> Historique des réservations</h3>
            
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Livre</th>
                            <th>Code</th>
                            <th>Date réservation</th>
                            <th>Dates emprunt</th>
                            <th>Statut</th>
                            <th>État retour</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->book->title }}</td>
                                <td>
                                    @if($reservation->confirmation_code)
                                        <code class="badge-navy">{{ $reservation->confirmation_code }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($reservation->start_date && $reservation->end_date)
                                        {{ $reservation->start_date->format('d/m/Y') }} - {{ $reservation->end_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Non défini</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reservation->status === 'pending')
                                        <span class="badge-warning">En attente</span>
                                    @elseif($reservation->status === 'confirmed')
                                        <span class="badge-success">Confirmée</span>
                                    @elseif($reservation->status === 'returned')
                                        <span class="badge-navy">Retournée</span>
                                    @else
                                        <span class="badge-danger">Annulée</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reservation->book_condition === 'good')
                                        <span class="badge-success">Bon état</span>
                                    @elseif($reservation->book_condition === 'damaged')
                                        <span class="badge-danger">Endommagé</span>
                                    @elseif($reservation->book_condition === 'lost')
                                        <span class="badge-dark">Perdu</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($reservation->admin_notes)
                                        <button type="button" class="btn-sm btn-outline-secondary" 
                                                data-bs-toggle="tooltip" 
                                                title="{{ $reservation->admin_notes }}">
                                            <i class="bi bi-file-text"></i>
                                        </button>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Aucune réservation</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- User Notes Card -->
    <div class="col-lg-4">
        <div class="modern-card">
            <h3 class="card-title"><i class="bi bi-journal-text"></i> Notes administratives</h3>
            
            <div class="notes-container mb-3">
                @if($user->notes)
                    <div class="alert alert-info" style="white-space: pre-line;">{{ $user->notes }}</div>
                @else
                    <p class="text-muted">Aucune note pour cet utilisateur.</p>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.users.updateNotes', $user) }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Ajouter une note</label>
                    <textarea name="notes" class="form-control" rows="4" placeholder="Entrez votre note ici..."></textarea>
                </div>
                <button type="submit" class="btn-coral w-100">
                    <i class="bi bi-plus-circle"></i> Ajouter la note
                </button>
            </form>
        </div>

        <!-- User Info Card -->
        <div class="modern-card mt-4">
            <h3 class="card-title"><i class="bi bi-info-circle"></i> Informations</h3>
            
            <div class="mb-3">
                <p class="text-muted mb-1">Rôle</p>
                <p class="fw-semibold">
                    @if($user->role === 'admin')
                        <span class="badge-danger">Administrateur</span>
                    @else
                        <span class="badge-navy">Utilisateur</span>
                    @endif
                </p>
            </div>

            <div class="mb-3">
                <p class="text-muted mb-1">Membre depuis</p>
                <p class="fw-semibold">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>

            <div class="mb-3">
                <p class="text-muted mb-1">Réservations en cours</p>
                <p class="fw-semibold">{{ $userStats['confirmed_reservations'] }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-navy flex-fill">
                    <i class="bi bi-pencil"></i> Modifier
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Edit Statistics Modal -->
<div class="modal fade" id="editStatisticsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.updateStatistics', $user) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Modifier les statistiques</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Total réservations</label>
                        <input type="number" name="total_reservations" class="form-control" 
                               value="{{ $user->total_reservations }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Retours à temps</label>
                        <input type="number" name="on_time_returns" class="form-control" 
                               value="{{ $user->on_time_returns }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Retours en retard</label>
                        <input type="number" name="late_returns" class="form-control" 
                               value="{{ $user->late_returns }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Livres endommagés</label>
                        <input type="number" name="damaged_books" class="form-control" 
                               value="{{ $user->damaged_books }}" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Livres perdus</label>
                        <input type="number" name="lost_books" class="form-control" 
                               value="{{ $user->lost_books }}" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-coral">Sauvegarder</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
)