@php
    $statuses = ['active', 'inactive', 'pending', 'suspended', 'alumni'];
@endphp

<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name"
               value="{{ old('first_name', $member->first_name ?? '') }}"
               class="form-control @error('first_name') is-invalid @enderror"
               required>

        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name"
               value="{{ old('last_name', $member->last_name ?? '') }}"
               class="form-control @error('last_name') is-invalid @enderror"
               required>

        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email"
               value="{{ old('email', $member->email ?? '') }}"
               class="form-control @error('email') is-invalid @enderror"
               required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone"
               value="{{ old('phone', $member->phone ?? '') }}"
               class="form-control @error('phone') is-invalid @enderror">

        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12">
        <label class="form-label">Address</label>
        <input type="text" name="address"
               value="{{ old('address', $member->address ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">City</label>
        <input type="text" name="city"
               value="{{ old('city', $member->city ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">State</label>
        <input type="text" name="state" maxlength="2"
               value="{{ old('state', $member->state ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">ZIP Code</label>
        <input type="text" name="zip_code"
               value="{{ old('zip_code', $member->zip_code ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Membership Status</label>
        <select name="membership_status" class="form-select">
            @foreach($statuses as $status)
                <option value="{{ $status }}"
                    @selected(old('membership_status', $member->membership_status ?? 'active') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Officer Position</label>
        <input type="text" name="officer_position"
               value="{{ old('officer_position', $member->officer_position ?? '') }}"
               class="form-control"
               placeholder="President, Secretary, Treasurer, etc.">
    </div>

    <div class="col-md-6">
        <label class="form-label">Committee</label>
        <input type="text" name="committee"
               value="{{ old('committee', $member->committee ?? '') }}"
               class="form-control"
               placeholder="Finance, Events, Membership, etc.">
    </div>

    <div class="col-md-6">
        <label class="form-label">Role Tracking</label>
        <input type="text" name="role_tracking"
               value="{{ old('role_tracking', $member->role_tracking ?? '') }}"
               class="form-control"
               placeholder="General Member, Chairperson, Officer, etc.">
    </div>

    <div class="col-md-6">
        <label class="form-label">Joined Date</label>
        <input type="date" name="joined_at"
               value="{{ old('joined_at', isset($member->joined_at) ? $member->joined_at->format('Y-m-d') : '') }}"
               class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Membership History</label>
        <textarea name="membership_history" rows="4" class="form-control">{{ old('membership_history', $member->membership_history ?? '') }}</textarea>
    </div>

    <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="4" class="form-control">{{ old('notes', $member->notes ?? '') }}</textarea>
    </div>

</div>
