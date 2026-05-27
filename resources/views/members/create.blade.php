@extends('layouts.app')

@section('title', 'Create Member')

@section('content')
<div class="container py-4">

    <div class="card border-0 shadow-sm">
        <div class="card-header text-white" style="background:#4b0082;">
            <h5 class="mb-0">Create Member</h5>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('members.store') }}">
                @csrf

                @include('members.partials.form', ['member' => null])

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning fw-bold">
                        Save Member
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
