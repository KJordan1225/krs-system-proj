@php
    $statuses = ['draft', 'scheduled', 'active', 'completed', 'cancelled'];
    $visibilities = ['private', 'public'];
@endphp

<div class="row g-3">

    <div class="col-md-8">
        <label class="form-label">Event Title</label>
        <input type="text" name="title"
               value="{{ old('title', $event->title ?? '') }}"
               class="form-control @error('title') is-invalid @enderror"
               required>

        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            @foreach($statuses as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $event->status ?? 'draft') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Category</label>
        <input type="text" name="category"
               value="{{ old('category', $event->category ?? '') }}"
               class="form-control"
               placeholder="Fundraiser, Banquet, Meeting, Outreach">
    </div>

    <div class="col-md-6">
        <label class="form-label">Event Type</label>
        <input type="text" name="event_type"
               value="{{ old('event_type', $event->event_type ?? '') }}"
               class="form-control"
               placeholder="Conference, Gala, Chapter Meeting">
    </div>

    <div class="col-md-6">
        <label class="form-label">Start Date/Time</label>
        <input type="datetime-local" name="starts_at"
               value="{{ old('starts_at', isset($event->starts_at) ? $event->starts_at->format('Y-m-d\TH:i') : '') }}"
               class="form-control @error('starts_at') is-invalid @enderror"
               required>

        @error('starts_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">End Date/Time</label>
        <input type="datetime-local" name="ends_at"
               value="{{ old('ends_at', isset($event->ends_at) ? $event->ends_at->format('Y-m-d\TH:i') : '') }}"
               class="form-control @error('ends_at') is-invalid @enderror">

        @error('ends_at')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Location/Venue</label>
        <input type="text" name="location"
               value="{{ old('location', $event->location ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Virtual Meeting Link</label>
        <input type="url" name="virtual_link"
               value="{{ old('virtual_link', $event->virtual_link ?? '') }}"
               class="form-control"
               placeholder="https://zoom.us/...">
    </div>

    <div class="col-md-4">
        <label class="form-label">Visibility</label>
        <select name="visibility" class="form-select">
            @foreach($visibilities as $visibility)
                <option value="{{ $visibility }}"
                    @selected(old('visibility', $event->visibility ?? 'private') === $visibility)>
                    {{ ucfirst($visibility) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-4">
        <label class="form-label">Capacity</label>
        <input type="number" name="capacity"
               value="{{ old('capacity', $event->capacity ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Registration Fee</label>
        <input type="number" step="0.01" name="registration_fee"
               value="{{ old('registration_fee', $event->registration_fee ?? 0) }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <div class="form-check mt-2">
            <input type="hidden" name="is_multi_day" value="0">
            <input class="form-check-input" type="checkbox" name="is_multi_day" value="1"
                   id="is_multi_day"
                   @checked(old('is_multi_day', $event->is_multi_day ?? false))>

            <label class="form-check-label" for="is_multi_day">
                Multi-Day Event
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-check mt-2">
            <input type="hidden" name="is_recurring" value="0">
            <input class="form-check-input" type="checkbox" name="is_recurring" value="1"
                   id="is_recurring"
                   @checked(old('is_recurring', $event->is_recurring ?? false))>

            <label class="form-check-label" for="is_recurring">
                Recurring Event
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <label class="form-label">Host Committee</label>
        <input type="text" name="host_committee"
               value="{{ old('host_committee', $event->host_committee ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label">Assigned Officer</label>
        <input type="text" name="assigned_officer"
               value="{{ old('assigned_officer', $event->assigned_officer ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Speaker/Presenter</label>
        <input type="text" name="speaker"
               value="{{ old('speaker', $event->speaker ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Sponsor</label>
        <input type="text" name="sponsor"
               value="{{ old('sponsor', $event->sponsor ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-4">
        <label class="form-label">Vendor</label>
        <input type="text" name="vendor"
               value="{{ old('vendor', $event->vendor ?? '') }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Budget</label>
        <input type="number" step="0.01" name="budget"
               value="{{ old('budget', $event->budget ?? 0) }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Expenses</label>
        <input type="number" step="0.01" name="expenses"
               value="{{ old('expenses', $event->expenses ?? 0) }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Revenue</label>
        <input type="number" step="0.01" name="revenue"
               value="{{ old('revenue', $event->revenue ?? 0) }}"
               class="form-control">
    </div>

    <div class="col-md-3">
        <label class="form-label">Donations</label>
        <input type="number" step="0.01" name="donations"
               value="{{ old('donations', $event->donations ?? 0) }}"
               class="form-control">
    </div>

    <div class="col-md-12">
        <label class="form-label">Description</label>
        <textarea name="description" rows="4" class="form-control">{{ old('description', $event->description ?? '') }}</textarea>
    </div>

    <div class="col-md-12">
        <label class="form-label">Agenda</label>
        <textarea name="agenda" rows="4" class="form-control">{{ old('agenda', $event->agenda ?? '') }}</textarea>
    </div>

    <div class="col-md-12">
        <label class="form-label">Notes</label>
        <textarea name="notes" rows="4" class="form-control">{{ old('notes', $event->notes ?? '') }}</textarea>
    </div>

</div>
