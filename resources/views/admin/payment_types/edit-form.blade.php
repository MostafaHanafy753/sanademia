<form id="editPaymentMethodForm" action="{{ route('admin.payment-types.update', $paymentType->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $paymentType->name }}" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" name="status">
                <option value="enabled" {{ $paymentType->status === 'enabled' ? 'selected' : '' }}>Enabled</option>
                <option value="disabled" {{ $paymentType->status === 'disabled' ? 'selected' : '' }}>Disabled</option>
            </select>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="3">{{ $paymentType->description }}</textarea>
        </div>
        <div class="col-md-12">
            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="image" accept="image/*">
            @if($paymentType->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $paymentType->image) }}" width="100" alt="{{ $paymentType->name }}">
                </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <h5>Steps (Between 2 and 5)</h5>
        <div id="edit-steps-container">
            @foreach($paymentType->steps as $index => $step)
                <div class="step-item p-3 border rounded mb-3 shadow-sm">
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Step Title</label>
                            <input type="text" class="form-control" name="steps[{{ $index }}][title]" value="{{ $step->title }}" required>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Default Value</label>
                            <input type="text" class="form-control" name="steps[{{ $index }}][default_value]" value="{{ $step->default_value }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Input Type</label>
                            <select class="form-select" name="steps[{{ $index }}][input_type]" onchange="toggleSelectOptions(this, {{ $index }}, 'edit')">
                                <option value="text" {{ $step->input_type == 'text' ? 'selected' : '' }}>Text</option>
                                <option value="number" {{ $step->input_type == 'number' ? 'selected' : '' }}>Number</option>
                                <option value="select" {{ $step->input_type == 'select' ? 'selected' : '' }}>Select</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="hidden" name="steps[{{ $index }}][is_fixed]" value="0">
                                <input type="checkbox" name="steps[{{ $index }}][is_fixed]" class="form-check-input" value="1" {{ $step->is_fixed ? 'checked' : '' }}>
                                <label class="form-check-label">Fixed</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">×</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-success mt-2" onclick="addStep('edit')">+ Add Step</button>
    </div>

    <div class="mt-4 text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Update Payment Method</button>
    </div>
</form>
