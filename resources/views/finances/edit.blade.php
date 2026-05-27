@extends('layouts.app')

@section('title', 'Edit Financial Transaction')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header text-white" style="background:#4b0082;">
            <h5 class="mb-0">Edit Financial Transaction</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('finances.update', $finance) }}">
                @csrf
                @method('PUT')

                @include('finances.partials.form', ['finance' => $finance])

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('finances.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning fw-bold">
                        Update Transaction
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
