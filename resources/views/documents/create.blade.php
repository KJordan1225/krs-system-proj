@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Upload Document</h1>

    <form action="{{ route('documents.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="card border-0 shadow-sm mt-3">

        @csrf

        <div class="card-header org-card-header">
            Document Details
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Document Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Bylaws, Minutes, Finance">
            </div>

            <div class="col-md-3">
                <label class="form-label">Document Type</label>
                <input type="text" name="document_type" class="form-control" value="{{ old('document_type') }}" placeholder="PDF, Report, Contract">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tags</label>
                <input type="text" name="tags" class="form-control" value="{{ old('tags') }}" placeholder="minutes, finance, audit">
            </div>

            <div class="col-md-3">
                <label class="form-label">Version</label>
                <input type="text" name="version" class="form-control" value="{{ old('version', '1.0') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Approval Status</label>
                <select name="approval_status" class="form-select" required>
                    <option value="Draft">Draft</option>
                    <option value="Pending Review">Pending Review</option>
                    <option value="Approved">Approved</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Effective Date</label>
                <input type="date" name="effective_date" class="form-control" value="{{ old('effective_date') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Expiration Date</label>
                <input type="date" name="expiration_date" class="form-control" value="{{ old('expiration_date') }}">
            </div>

            <div class="col-12">
                <label class="form-label">Upload File</label>
                <input type="file" name="document_file" class="form-control" required>
                <small class="text-muted">
                    Allowed: PDF, Word, Excel, images, TXT, CSV. Max size: 10MB.
                </small>
                @error('document_file') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-org-gold">
                Save Document
            </button>
        </div>
    </form>
</div>
@endsection
