@extends('layouts.backend')

 @section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h3 fw-bold mb-1">Payment Methods</h1>
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ url('admin/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Payment Methods
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <!-- Example table for Payment Methods -->
    <div class="block block-rounded">
        <div class="block-header block-header-default d-flex justify-content-between align-items-center">
            <h3 class="block-title">Available Payment Methods</h3>
            <a href="#add-payment" class="btn btn-primary" data-bs-toggle="modal">Add New Method</a>
        </div>
        <div class="block-content table-responsive">
            <table class="table table-striped table-hover table-vcenter">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Steps (Non-Fixed)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentTypes as $paymentType)
                        <tr>
                            <td>
                                @if($paymentType->image)
                                {{-- <img class="cup" alt="img" src="{{ asset('public/images/payment-types/'.$paymentType->image) }}" width="50px"> --}}
                                <img src=" {{ asset('images/payment-types/'.$paymentType->image)  }}" width ="100" alt="{{ $paymentType->name }}">
                                @endif
                            </td>
                            <td>{{ $paymentType->name }}</td>
                            <td>
                                <span class="badge bg-{{ $paymentType->status === 'enabled' ? 'success' : 'danger' }}">
                                    {{ ucfirst($paymentType->status) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    // Filter the steps to get only the non-fixed ones.
                                    $nonFixedSteps = $paymentType->steps ;
                                @endphp
                                @if($nonFixedSteps->isNotEmpty())
                                <p>{{ $nonFixedSteps->count() }}</p>
                                    <ul class="list-unstyled">
                                        {{-- @foreach($nonFixedSteps as $step)
                                            <li>
                                                <strong>{{ $step->title }}</strong>
                                                @if($step->input_type === 'select' && !empty($step->select_options))
                                                    <br>Options: {{ implode(', ', $step->select_options) }}
                                                @endif
                                            </li>
                                        @endforeach --}}
                                    </ul>
                                @else
                                    <em>No non  steps</em>
                                @endif
                                <td>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning" onclick="editPayment({{ $paymentType->id }})">Edit</a>
                                     <button class="btn btn-sm btn-danger" onclick="deletePayment({{ $paymentType->id }})">Delete</button>

                                </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

        <!-- Add Payment Modal -->
        <div class="modal fade" id="add-payment" tabindex="-1" aria-labelledby="addPaymentLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="paymentMethodForm" action="{{ route('admin.payment-types.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- Basic Payment Details -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status">
                                        <option value="enabled" {{ old('status') == 'enabled' ? 'selected' : '' }}>Enabled</option>
                                        <option value="disabled" {{ old('status') == 'disabled' ? 'selected' : '' }}>Disabled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- New Inputs: Description, Image, Created By -->
                            <div class="row g-3 mt-3">
                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Steps Section -->
                            <div class="mt-4">
                                <h5>Steps (Between 2 and 5)</h5>
                                <div id="steps-container">
                                    @if(old('steps'))
                                        @foreach(old('steps') as $index => $step)
                                            <div class="step-item p-3 border rounded mb-3 shadow-sm">
                                                <div class="row g-2 align-items-end">
                                                    <div class="col-md-3">
                                                        <label class="form-label">Step Title</label>
                                                        <input type="text" class="form-control @error('steps.' . $index . '.title') is-invalid @enderror" name="steps[{{ $index }}][title]" value="{{ $step['title'] }}" required>
                                                        @error('steps.' . $index . '.title')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Default Value</label>
                                                        <input type="text" class="form-control @error('steps.' . $index . '.default_value') is-invalid @enderror" name="steps[{{ $index }}][default_value]" value="{{ $step['default_value'] }}">
                                                        @error('steps.' . $index . '.default_value')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Input Type</label>
                                                        <select class="form-select @error('steps.' . $index . '.input_type') is-invalid @enderror" name="steps[{{ $index }}][input_type]" onchange="toggleSelectOptions(this, {{ $index }})">
                                                            <option value="text" {{ $step['input_type'] == 'text' ? 'selected' : '' }}>Text</option>
                                                            <option value="number" {{ $step['input_type'] == 'number' ? 'selected' : '' }}>Number</option>
                                                            {{-- <option value="select" {{ $step['input_type'] == 'select' ? 'selected' : '' }}>Select</option> --}}
                                                            <option value="checkbox" {{ $step['input_type'] == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                                            <option value="radio" {{ $step['input_type'] == 'radio' ? 'selected' : '' }}>Radio</option>
                                                        </select>
                                                        @error('steps.' . $index . '.input_type')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input type="hidden" name="steps[{{ $index }}][is_fixed]" value="0">
                                                            <input type="checkbox" id="is_fixed_{{ $index }}" name="steps[{{ $index }}][is_fixed]" class="form-check-input" value="1" {{ old("steps.$index.is_fixed") ? 'checked' : '' }}>
                                                            <label for="is_fixed_{{ $index }}" class="form-check-label">Fixed</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-check">
                                                            <input type="hidden" name="steps[{{ $index }}][is_required]" value="0">
                                                            <input type="checkbox" id="is_required_{{ $index }}" name="steps[{{ $index }}][is_required]" class="form-check-input" value="1" {{ old("steps.$index.is_required") ? 'checked' : '' }}>
                                                            <label for="is_required_{{ $index }}" class="form-check-label">Required</label>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">×</button>
                                                    </div>
                                                </div>
                                                @if($step['input_type'] == 'select')
                                                    <div class="row g-2 mt-2 select-options" id="select-options-{{ $index }}">
                                                        <div class="col-md-10">
                                                            <label class="form-label">Option</label>
                                                            <input type="text" class="form-control" name="steps[{{ $index }}][select_options][]" placeholder="Option">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="form-label d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-sm btn-success" onclick="addSelectOption({{ $index }})">+ Option</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-success mt-2" onclick="addStep()">+ Add Step</button>
                                <p class="mt-2"><strong>Steps:</strong> <span id="progress-text">{{ old('steps') ? count(old('steps')) : 0 }}</span></p>
                                @error('steps')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Payment Method</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Payment Modal -->

 <!-- Edit Payment Modal -->
<div class="modal fade" id="edit-payment" tabindex="-1" aria-labelledby="editPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Edit Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="edit-modal-content">
                <!-- Form content will be injected here dynamically -->
            </div>
        </div>
    </div>
</div>


         <!-- Scripts for Dynamic Steps and API Call -->
        <script>

       let minSteps = 2;
let maxSteps = 5;
let stepCount = 0;

function editPayment(paymentTypeId) {
    fetch('/admin/payment-types/' + paymentTypeId + '/edit')
        .then(response => response.text())
        .then(html => {
            const editModalContent = document.getElementById('edit-modal-content');
            if (!editModalContent) {
                console.error("Edit modal content element not found");
                return;
            }
            editModalContent.innerHTML = html; // Inject the fetched content

            // Ensure modal initializes after content is injected
            var editModal = new bootstrap.Modal(document.getElementById('edit-payment'), {
                keyboard: false
            });
            editModal.show();

            // **Update step count dynamically**
            stepCount = document.querySelectorAll("#edit-steps-container .step-item").length;
            updateProgress('edit');

        })
        .catch(error => console.error('Error loading edit form:', error));
}
function addStep(context = '') {
    let containerId = context === 'edit' ? 'edit-steps-container' : 'steps-container';

    stepCount = document.querySelectorAll(`#${containerId} .step-item`).length;
    if (stepCount >= 5) {
        alert("You can only add up to 5 steps.");
        return;
    }

    stepCount++;
    updateProgress(context);

    let stepIndex = stepCount;
    const stepsContainer = document.getElementById(containerId);

    const stepDiv = document.createElement('div');
    stepDiv.classList.add('step-item', 'p-3', 'border', 'rounded', 'mb-3', 'shadow-sm');
    stepDiv.innerHTML = `
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Step Title</label>
                <input type="text" class="form-control" name="steps[${stepIndex}][title]" placeholder="Step Title" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Default Value</label>
                <input type="text" class="form-control" name="steps[${stepIndex}][default_value]" placeholder="Default Value">
            </div>
            <div class="col-md-2">
                <label class="form-label">Input Type</label>
                <select class="form-select" name="steps[${stepIndex}][input_type]">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="form-check">
                    <input type="hidden" name="steps[${stepIndex}][is_fixed]" value="0">
                    <input type="checkbox" name="steps[${stepIndex}][is_fixed]" class="form-check-input" value="1">
                    <label class="form-check-label">Fixed</label>
                </div>
            </div>
<div class="col-md-2">
                <div class="form-check">
                    <input type="hidden" name="steps[${stepIndex}][is_required]" value="0">
                    <input type="checkbox" name="steps[${stepIndex}][is_required]" class="form-check-input" value="1">
                    <label class="form-check-label">Required</label>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this, '${context}')">×</button>
            </div>
        </div>
    `;
    stepsContainer.appendChild(stepDiv);
}


function removeStep(button, context = '') {
    button.closest('.step-item').remove();
    stepCount--;
    updateProgress(context);
}

function updateProgress(context = '') {
    let progressTextId = context === 'edit' ? 'edit-progress-text' : 'progress-text';
    let progressTextElement = document.getElementById(progressTextId);

    if (progressTextElement) { // ✅ Ensure the element exists before modifying it
        progressTextElement.innerText = stepCount;
    }
}

function toggleSelectOptions(select, index) {
    const selectOptionsDiv = document.getElementById(`select-options-${index}`);
    if (select.value === "select") {
        selectOptionsDiv.style.display = "flex";
    } else {
        selectOptionsDiv.style.display = "none";
        document.getElementById(`additional-options-${index}`).innerHTML = "";
    }
}

function addSelectOption(stepIndex) {
    const container = document.getElementById(`additional-options-${stepIndex}`);
    const optionDiv = document.createElement('div');
    optionDiv.classList.add('row', 'g-2', 'mt-2');
    optionDiv.innerHTML = `
        <div class="col-md-10">
            <input type="text" class="form-control" name="steps[${stepIndex}][select_options][]" placeholder="Option">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    container.appendChild(optionDiv);
}
     function deletePayment(paymentTypeId) {
        Swal.fire({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                let csrfToken = document.querySelector('meta[name="csrf-token"]');

                // Check if CSRF token is null
                if (!csrfToken) {
                    Swal.fire("Error!", "CSRF token is missing!", "error");
                    return;
                }

                fetch(`/admin/payment-types/${paymentTypeId}/delete`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken.getAttribute("content"),
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Deleted!", "The payment method has been removed.", "success").then(() => {
                            location.reload(); // Reload the page after deletion
                        });
                    } else {
                        Swal.fire("Error!", "Something went wrong. Try again.", "error");
                    }
                })
                .catch(error => {
                    Swal.fire("Error!", "An error occurred. Try again later.", "error");
                    console.error("Error:", error);
                });
            }
        });
    }

      </script>
    @endsection
