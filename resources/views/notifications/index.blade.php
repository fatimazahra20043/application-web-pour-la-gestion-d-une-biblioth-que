@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Mes notifications')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">
        <i class="bi bi-bell-fill"></i> Notifications
    </h2>
    @if($notifications->where('read_at', null)->count() > 0)
        <form method="POST" action="{{ route('notifications.readAll') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-check-all"></i> Tout marquer comme lu
            </button>
        </form>
    @endif
</div>

<div class="row">
    <div class="col-md-10 mx-auto">
        @forelse($notifications as $notification)
            <div class="card mb-3 {{ $notification->isUnread() ? 'border-primary' : '' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-fill">
                            <h5 class="card-title mb-2">
                                @if($notification->type === 'reservation_confirmed')
                                    <i class="bi bi-check-circle text-success"></i>
                                @elseif($notification->type === 'reservation_refused')
                                    <i class="bi bi-x-circle text-danger"></i>
                                @elseif($notification->type === 'return_reminder')
                                    <i class="bi bi-clock text-warning"></i>
                                @elseif($notification->type === 'return_overdue')
                                    <i class="bi bi-exclamation-triangle text-danger"></i>
                                @endif
                                {{ $notification->title }}
                                @if($notification->isUnread())
                                    <span class="badge bg-primary ms-2">Nouveau</span>
                                @endif
                            </h5>
                            <p class="card-text mb-2">{{ $notification->message }}</p>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                        @if($notification->isUnread())
                            <form method="POST" action="{{ route('notifications.read', $notification) }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-check"></i> Marquer comme lu
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                <i class="bi bi-bell-slash" style="font-size: 4rem;"></i>
                <p class="mt-3">Aucune notification</p>
            </div>
        @endforelse
        
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection
