@extends('layouts.app')

@section('title', 'Events')

@section('content')
<style>
    .org-hero {
        background: linear-gradient(135deg, #4b0082, #2d004d);
        color: #fff;
        border-radius: 1rem;
    }

    .text-gold {
        color: #d4af37;
    }

    .btn-purple {
        background: #4b0082;
        border-color: #4b0082;
        color: #fff;
    }

    .btn-purple:hover {
        background: #3a0066;
        border-color: #3a0066;
        color: #fff;
    }

    .badge-purple {
        background: #4b0082;
    }
</style>

<div class="container-fluid py-4">

    <div class="org-hero p-4 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Events Module</h1>
                <p class="mb-0 text-gold">
                    Manage event scheduling, RSVPs, attendance, budgeting, revenue, speakers, sponsors, vendors, and history.
                </p>
            </div>

            <a href="{{ route('events.create') }}" class="btn btn-warning fw-bold">
                Create Event
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">Upcoming & Historical Events</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Event</th>
                            <th>Category</th>
                            <th>Starts</th>
                            <th>Status</th>
                            <th>Visibility</th>
                            <th>Revenue</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td>
                                    <strong>{{ $event->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $event->location ?? 'No location listed' }}</small>
                                </td>

                                <td>{{ $event->category ?? 'N/A' }}</td>

                                <td>{{ $event->starts_at->format('M d, Y g:i A') }}</td>

                                <td>
                                    <span class="badge badge-purple">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>

                                <td>{{ ucfirst($event->visibility) }}</td>

                                <td>${{ number_format($event->revenue, 2) }}</td>

                                <td class="text-end">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>

                                    <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-purple">
                                        Edit
                                    </a>

                                    <form action="{{ route('events.destroy', $event) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this event?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No events found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
