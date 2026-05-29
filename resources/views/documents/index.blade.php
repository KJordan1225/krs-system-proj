@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="org-page-title">Documents</h1>
            <p class="text-muted mb-0">
                Manage bylaws, minutes, reports, applications, financial records, and organizational files.
            </p>
        </div>

        <a href="{{ route('documents.create') }}" class="btn btn-org-gold">
            Upload Document
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Total Documents</span>
                <h3>{{ $summary['total_documents'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Approved</span>
                <h3>{{ $summary['approved'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Drafts</span>
                <h3>{{ $summary['drafts'] }}</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="org-summary-card">
                <span>Expired</span>
                <h3>{{ $summary['expired'] }}</h3>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('documents.index') }}" class="card border-0 shadow-sm mb-4">
        <div class="card-body row g-3">
            <div class="col-md-6">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search title, type, category, or tags"
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>

                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-org-gold w-100">
                    Search
                </button>
            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            Document Library
        </div>

        <div class="card-body table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Document</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Size</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($documents as $document)
                        <tr>
                            <td>
                                <strong>{{ $document->title }}</strong><br>
                                <small class="text-muted">
                                    {{ $document->file_name }}
                                </small>
                            </td>

                            <td>{{ $document->category ?? 'N/A' }}</td>

                            <td>{{ $document->document_type ?? 'N/A' }}</td>

                            <td>
                                @if($document->approval_status === 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($document->approval_status === 'Pending Review')
                                    <span class="badge bg-warning text-dark">Pending Review</span>
                                @elseif($document->approval_status === 'Archived')
                                    <span class="badge bg-secondary">Archived</span>
                                @else
                                    <span class="badge bg-info text-dark">Draft</span>
                                @endif
                            </td>

                            <td>
                                @if($document->expiration_date)
                                    @if($document->isExpired())
                                        <span class="badge bg-danger">
                                            {{ $document->expiration_date->format('M d, Y') }}
                                        </span>
                                    @else
                                        {{ $document->expiration_date->format('M d, Y') }}
                                    @endif
                                @else
                                    N/A
                                @endif
                            </td>

                            <td>{{ $document->fileSizeFormatted() }}</td>

                            <td class="text-end">
                                <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-success">
                                    Download
                                </a>

                                <a href="{{ route('documents.edit', $document) }}" class="btn btn-sm btn-outline-primary">
                                    Edit
                                </a>

                                <form action="{{ route('documents.destroy', $document) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this document?');">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                No documents found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
