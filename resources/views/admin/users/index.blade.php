@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="content-header">
    <h1 class="page-title"><i class="bi bi-people"></i> Gestion des utilisateurs</h1>
    <a href="{{ route('admin.users.create') }}" class="btn-coral">
        <i class="bi bi-plus-lg"></i> Ajouter un utilisateur
    </a>
</div>

<div class="modern-card">
    <div class="table-responsive">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statistiques</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge-danger">Administrateur</span>
                            @else
                                <span class="badge-navy">Utilisateur</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $user->total_reservations }} réservations | 
                                {{ $user->late_returns }} retards
                            </small>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <!-- Added view button to see user details -->
                                <a href="{{ route('admin.users.show', $user) }}" class="btn-navy-sm" title="Voir détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn-warning-sm" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-sm" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun utilisateur trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $users->links() }}
</div>
@endsection
