@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Updated with new stat card design matching coral theme -->
<div class="mb-5">
    <h2 class="section-title">Dashboard Administrateur</h2>
    <p class="section-subtitle">Vue d'ensemble de votre bibliothèque</p>
</div>

<div class="row mb-5">
    <div class="col-md-3 mb-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total_books'] }}</div>
            <div class="stat-label"><i class="bi bi-book-fill"></i> Total Livres</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: #2ecc71;">
            <div class="stat-value" style="color: #2ecc71;">{{ $stats['total_users'] }}</div>
            <div class="stat-label"><i class="bi bi-people-fill"></i> Utilisateurs</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: var(--orange);">
            <div class="stat-value" style="color: var(--orange);">{{ $stats['pending_reservations'] }}</div>
            <div class="stat-label"><i class="bi bi-clock-fill"></i> En attente</div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="stat-card" style="border-left-color: var(--navy-light);">
            <div class="stat-value" style="color: var(--navy-light);">{{ $stats['active_reservations'] }}</div>
            <div class="stat-label"><i class="bi bi-check-circle-fill"></i> Actives</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <i class="bi bi-calendar-check"></i> Réservations récentes
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Livre</th>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_reservations as $reservation)
                        <tr>
                            <td><strong>{{ $reservation->user->name }}</strong></td>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($reservation->status === 'pending')
                                    <span class="badge bg-warning">En attente</span>
                                @elseif($reservation->status === 'confirmed')
                                    <span class="badge bg-success">Confirmée</span>
                                @else
                                    <span class="badge bg-danger">Annulée</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Aucune réservation récente</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
