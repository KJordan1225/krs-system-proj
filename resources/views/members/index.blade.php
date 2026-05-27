@extends('layouts.app')

@section('title', 'Members')

@section('content')
<style>
    .purple-gold-header {
        background: linear-gradient(135deg, #4b0082, #2d004d);
        color: #fff;
        border-radius: 1rem;
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

    .text-gold {
        color: #d4af37;
    }

    .badge-purple {
        background: #4b0082;
    }
</style>

<div class="container-fluid py-4">

    <div class="purple-gold-header p-4 mb-4 shadow-sm">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Member Management</h1>
                <p class="mb-0 text-gold">Manage registration, profiles, contact info, status, officers, committees, and history.</p>
            </div>

            <a href="{{ route('members.create') }}" class="btn btn-warning fw-bold">
                Add Member
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
            <h5 class="mb-0">Members</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Officer Position</th>
                            <th>Committee</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($members as $member)
                            <tr>
                                <td class="fw-semibold">{{ $member->full_name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>
                                    <span class="badge badge-purple">
                                        {{ ucfirst($member->membership_status) }}
                                    </span>
                                </td>
                                <td>{{ $member->officer_position ?? 'N/A' }}</td>
                                <td>{{ $member->committee ?? 'N/A' }}</td>
                                <td class="text-end">
                                    <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-secondary">
                                        View
                                    </a>

                                    <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-purple">
                                        Edit
                                    </a>

                                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this member?');">
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
                                <td colspan="6" class="text-center py-4">
                                    No members found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer bg-white">
            {{ $members->links() }}
        </div>
    </div>

</div>
@endsection
