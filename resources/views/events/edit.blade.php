@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header text-white" style="background:#4b0082;">
            <h5 class="mb-0">Edit Event</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('events.update', $event) }}">
                @csrf
                @method('PUT')

                @include('events.partials.form', ['event' => $event])

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('events.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning fw-bold">
                        Update Event
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
