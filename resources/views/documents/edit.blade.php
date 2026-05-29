@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">Edit Document</h1>

    <form action="{{ route('documents.update', $document) }}"
          method="POST"
          enctype="multipart/form-data"
          class="card border-0 shadow-sm mt-3">

        @csrf
        @method('PUT')

        <div class="card-header org-card-header">
            Update Document
        </div>

        <div class="card-body row g-3">
            <div class="col-md-6">
                <label class="form-label">Document Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $document->title) }}" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" value="{{ old('category', $document->category) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Document Type</label>
                <input type="text" name="document_type" class="form-control" value="{{ old('document_type', $document->document_type) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Tags</label>
                <input type="text" name="tags" class="form-control" value="{{ old('tags', $document->tags) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Version</label>
                <input type="text" name="version" class="form-control" value="{{ old('version', $document->version) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Approval Status</label>
                <select name="approval_status" class="form-select" required>
                    <option value="Draft" @selected(old('approval_status', $document->approval_status) === 'Draft')>Draft</option>
                    <option value="Pending Review" @selected(old('approval_status', $document->approval_status) === 'Pending Review')>Pending Review</option>
                    <option value="Approved" @selected(old('approval_status', $document->approval_status) === 'Approved')>Approved</option>
                    <option value="Archived" @selected(old('approval_status', $document->approval_status) === 'Archived')>Archived</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Effective Date</label>
                <input type="date"
                       name="effective_date"
                       class="form-control"
                       value="{{ old('effective_date', optional($document->effective_date)->format('Y-m-d')) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Expiration Date</label>
                <input type="date"
                       name="expiration_date"
                       class="form-control"
                       value="{{ old('expiration_date', optional($document->expiration_date)->format('Y-m-d')) }}">
            </div>

            <div class="col-12">
                <label class="form-label">Replace File</label>
                <input type="file" name="document_file" class="form-control">
                <small class="text-muted">
                    Current file: {{ $document->file_name }}. Leave blank to keep it.
                </small>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $document->description) }}</textarea>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('documents.index') }}" class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn btn-org-gold">
                Update Document
            </button>
        </div>
    </form>
</div>
@endsection
