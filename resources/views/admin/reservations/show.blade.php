@extends('layouts.app')

@section('title', 'Détails de la réservation')
@section('page-title', 'Détails de la réservation')

@section('content')
<div class="row">
    <div class="col-md-8">
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left"></i> Retour aux réservations
        </a>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informations de la réservation</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Livre:</strong><br>
                        {{ $reservation->book->title }}
                    </div>
                    <div class="col-md-6">
                        <strong>Utilisateur:</strong><br>
                        <a href="{{ route('admin.users.show', $reservation->user) }}">
                            {{ $reservation->user->name }}
                        </a>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Date réservation:</strong><br>
                        {{ $reservation->reservation_date->format('d/m/Y') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Date début:</strong><br>
                        {{ $reservation->start_date ? $reservation->start_date->format('d/m/Y') : '-' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Date fin:</strong><br>
                        {{ $reservation->end_date ? $reservation->end_date->format('d/m/Y') : '-' }}
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Statut:</strong><br>
                        @if($reservation->status === 'pending')
                            <span class="badge bg-warning">En attente</span>
                        @elseif($reservation->status === 'confirmed')
                            <span class="badge bg-success">Confirmée</span>
                        @elseif($reservation->status === 'cancelled')
                            <span class="badge bg-danger">Annulée</span>
                        @else
                            <span class="badge bg-secondary">Retournée</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <strong>Code de confirmation:</strong><br>
                        @if($reservation->confirmation_code)
                            <code class="fs-5 fw-bold">{{ $reservation->confirmation_code }}</code>
                        @else
                            -
                        @endif
                    </div>
                </div>
                
                @if($reservation->refusal_reason)
                    <div class="alert alert-danger">
                        <strong>Motif de refus:</strong> {{ $reservation->refusal_reason }}
                    </div>
                @endif
                
                @if($reservation->book_condition)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Date retour effectif:</strong><br>
                            {{ $reservation->actual_return_date ? $reservation->actual_return_date->format('d/m/Y') : '-' }}
                        </div>
                        <div class="col-md-6">
                            <strong>État du livre:</strong><br>
                            @if($reservation->book_condition === 'good')
                                <span class="badge bg-success">Bon état</span>
                            @elseif($reservation->book_condition === 'damaged')
                                <span class="badge bg-warning">Endommagé</span>
                            @else
                                <span class="badge bg-danger">Perdu</span>
                            @endif
                        </div>
                    </div>
                @endif
                
                @if($reservation->admin_notes)
                    <div class="mb-3">
                        <strong>Notes administratives:</strong>
                        <div class="bg-light p-3 rounded mt-2">
                            {!! nl2br(e($reservation->admin_notes)) !!}
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('admin.reservations.note', $reservation) }}" class="mt-4">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Ajouter une note</label>
                        <textarea name="admin_notes" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter la note
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Statistiques utilisateur</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Total réservations:</strong><br>
                    <span class="fs-4">{{ $userStats['total_reservations'] }}</span>
                </div>
                <div class="mb-3">
                    <strong>Retours à temps:</strong><br>
                    <span class="text-success fs-4">{{ $userStats['on_time_returns'] }}</span>
                </div>
                <div class="mb-3">
                    <strong>Retours en retard:</strong><br>
                    <span class="text-warning fs-4">{{ $userStats['late_returns'] }}</span>
                </div>
                <div class="mb-3">
                    <strong>Livres endommagés:</strong><br>
                    <span class="text-danger fs-4">{{ $userStats['damaged_books'] }}</span>
                </div>
                
                
                <hr>
                
                <h6 class="mb-3">Historique récent</h6>
                <div class="list-group">
                    @foreach($userStats['recent_reservations'] as $res)
                        <div class="list-group-item list-group-item-action p-2">
                            <small>{{ $res->book->title }}</small><br>
                            <small class="text-muted">{{ $res->created_at->format('d/m/Y') }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
