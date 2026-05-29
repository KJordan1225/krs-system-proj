@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="org-page-title">Document Details</h1>

        <a href="{{ route('documents.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header org-card-header">
            {{ $document->title }}
        </div>

        <div class="card-body">
            <dl class="row">
                <dt class="col-md-4">File Name</dt>
                <dd class="col-md-8">{{ $document->file_name }}</dd>

                <dt class="col-md-4">Category</dt>
                <dd class="col-md-8">{{ $document->category ?? 'N/A' }}</dd>

                <dt class="col-md-4">Document Type</dt>
                <dd class="col-md-8">{{ $document->document_type ?? 'N/A' }}</dd>

                <dt class="col-md-4">Tags</dt>
                <dd class="col-md-8">{{ $document->tags ?? 'N/A' }}</dd>

                <dt class="col-md-4">Version</dt>
                <dd class="col-md-8">{{ $document->version }}</dd>

                <dt class="col-md-4">Approval Status</dt>
                <dd class="col-md-8">{{ $document->approval_status }}</dd>

                <dt class="col-md-4">Effective Date</dt>
                <dd class="col-md-8">
                    {{ $document->effective_date?->format('M d, Y') ?? 'N/A' }}
                </dd>

                <dt class="col-md-4">Expiration Date</dt>
                <dd class="col-md-8">
                    {{ $document->expiration_date?->format('M d, Y') ?? 'N/A' }}
                </dd>

                <dt class="col-md-4">Uploaded By</dt>
                <dd class="col-md-8">{{ $document->uploaded_by ?? 'N/A' }}</dd>

                <dt class="col-md-4">File Size</dt>
                <dd class="col-md-8">{{ $document->fileSizeFormatted() }}</dd>

                <dt class="col-md-4">Description</dt>
                <dd class="col-md-8">{{ $document->description ?? 'N/A' }}</dd>
            </dl>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <div>
                <a href="{{ route('documents.download', $document) }}" class="btn btn-success">
                    Download
                </a>

                <a href="{{ route('documents.edit', $document) }}" class="btn btn-org-gold">
                    Edit Document
                </a>
            </div>

            <form action="{{ route('documents.destroy', $document) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this document?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-outline-danger">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
