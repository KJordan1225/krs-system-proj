@php
    $types = ['income', 'expense'];
    $statuses = ['draft', 'finalized'];
    $categories = [
        'Dues',
        'Donation',
        'Fundraiser',
        'Event Revenue',
        'Supplies',
        'Food',
        'Venue',
        'Travel',
        'Technology',
        'Administrative',
        'Other',
    ];
@endphp

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Transaction Type</label>
        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
            @foreach($types as $type)
                <option value="{{ $type }}"
                    @selected(old('type', $finance->type ?? 'income') === $type)>
                    {{ ucfirst($type) }}
                </option>
            @endforeach
        </select>

        @error('type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category" class="form-select @error('category') is-invalid @enderror" required>
            <option value="">Select Category</option>

            @foreach($categories as $category)
                <option value="{{ $category }}"
                    @selected(old('category', $finance->category ?? '') === $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        @error('category')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label class="form-label">Title</label>
        <input type="text" name="title"
               value="{{ old('title', $finance->title ?? '') }}"
               class="form-control @error('title') is-invalid @enderror"
               required>

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Amount</label>
        <input type="number" step="0.01" name="amount"
               value="{{ old('amount', $finance->amount ?? '') }}"
               class="form-control @error('amount') is-invalid @enderror"
               required>

        @error('amount')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Transaction Date</label>
        <input type="date" name="transaction_date"
               value="{{ old('transaction_date', isset($finance->transaction_date) ? $finance->transaction_date->format('Y-m-d') : '') }}"
               class="form-control @error('transaction_date') is-invalid @enderror"
               required>

        @error('transaction_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Payment Method</label>
        <input type="text" name="payment_method"
               value="{{ old('payment_method', $finance->payment_method ?? '') }}"
               class="form-control"
               placeholder="Cash, Check, Card, Zelle">
    </div>

    <div class="col-md-4">
        <label class="form-label">Reference Number</label>
        <input type="text" name="reference_number"
               value="{{ old('reference_number', $finance->reference_number ?? '') }}"
               class="form-control"
               placeholder="Receipt, check, or confirmation #">
    </div>

    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach($statuses as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $finance->status ?? 'draft') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <small class="text-muted">
            Finalized records become locked and cannot be edited or deleted.
        </small>
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control">{{ old('description', $finance->description ?? '') }}</textarea>
    </div>

</div>
