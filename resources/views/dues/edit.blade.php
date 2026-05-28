@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="org-page-title">
        Edit Dues Payment
    </h1>

    <form action="{{ route('dues.update', $due) }}"
          method="POST"
          class="card border-0 shadow-sm mt-3">

        @csrf
        @method('PUT')

        <div class="card-header org-card-header">
            Update Payment
        </div>

        <div class="card-body row g-3">

            <div class="col-md-6">
                <label class="form-label">
                    Financial Period
                </label>

                <select name="dues_period_id"
                        class="form-select"
                        required>

                    @foreach($periods as $period)
                        <option value="{{ $period->id }}"
                            @selected(old('dues_period_id', $due->dues_period_id) == $period->id)>

                            {{ $period->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Member Name
                </label>

                <input type="text"
                       name="member_name"
                       class="form-control"
                       value="{{ old('member_name', $due->member_name) }}"
                       required>
            </div>

            <div class="col-md-6">
                <label class="form-label">
                    Member Email
                </label>

                <input type="email"
                       name="member_email"
                       class="form-control"
                       value="{{ old('member_email', $due->member_email) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Amount Due
                </label>

                <input type="number"
                       step="0.01"
                       name="amount_due"
                       class="form-control"
                       value="{{ old('amount_due', $due->amount_due) }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">
                    Amount Paid
                </label>

                <input type="number"
                       step="0.01"
                       name="amount_paid"
                       class="form-control"
                       value="{{ old('amount_paid', $due->amount_paid) }}"
                       required>
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Paid On
                </label>

                <input type="date"
                       name="paid_on"
                       class="form-control"
                       value="{{ old('paid_on', optional($due->paid_on)->format('Y-m-d')) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Payment Method
                </label>

                <input type="text"
                       name="payment_method"
                       class="form-control"
                       value="{{ old('payment_method', $due->payment_method) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">
                    Reference Number
                </label>

                <input type="text"
                       name="reference_number"
                       class="form-control"
                       value="{{ old('reference_number', $due->reference_number) }}">

                @error('reference_number')
                    <div class="text-danger small">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label">
                    Notes
                </label>

                <textarea name="notes"
                          class="form-control"
                          rows="4">{{ old('notes', $due->notes) }}</textarea>
            </div>

        </div>

        <div class="card-footer d-flex justify-content-between">
            <a href="{{ route('dues.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

            <button type="submit"
                    class="btn btn-org-gold">
                Update Payment
            </button>
        </div>
    </form>
</div>
@endsection