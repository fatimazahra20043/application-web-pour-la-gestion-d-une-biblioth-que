@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
<h1 class="page-title mb-4"><i class="bi bi-calendar-check"></i> Mes réservations</h1>

<div class="modern-card">
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Auteur</th>
                    <th>Date de réservation</th>
                    <th>Statut</th>
                    <th>Code de confirmation</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>
                            <a href="{{ route('books.show', $reservation->book) }}" class="text-decoration-none fw-semibold" style="color: var(--coral);">
                                {{ $reservation->book->title }}
                            </a>
                        </td>
                        <td>{{ $reservation->book->author }}</td>
                        <td>{{ $reservation->reservation_date->format('d/m/Y') }}</td>
                        <td>
                            @if($reservation->status === 'pending')
                                <span class="badge bg-warning">En attente</span>
                            @elseif($reservation->status === 'confirmed')
                                <span class="badge-success">Confirmée</span>
                            @elseif($reservation->status === 'cancelled')
                                <span class="badge-danger">Annulée</span>
                            @else
                                <span class="badge bg-secondary">Retournée</span>
                            @endif
                        </td>
                        <td>
                            @if($reservation->confirmation_code)
                                <code class="code-badge" style="font-size: 1rem;">
                                    {{ $reservation->confirmation_code }}
                                </code>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Aucune réservation trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $reservations->links() }}
</div>
@endsection
