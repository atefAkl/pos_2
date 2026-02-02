@extends('layouts.app')

@section('content')
<div class="container">

    <x-breadcrumbs :breadcrumbs="[['url' => route('terminals.index'), 'label' => 'Terminals']]" />

    <div class="card mb-3">
        <div class="row">
            <div class="col-md-12 page-heading">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="page-heading-title">
                        My Profile
                    </div>
                    <div class="page-heading-actions">
                        <a href="{{ route('auth.user.profile.edit') }}" class="quick-action-btn"><i
                                class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <button type="button" class="setting-link col-sm-6 col-md-4 col-lg-3" data-bs-toggle="modal" data-bs-target="#openShiftModal">
                    <i class="fa fa-print fa-2x"></i>
                    <span class="link-title fs-6" style="">Start POS Session</span>
                </button>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->role == 'accountant')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="setting-link col-sm-6 col-md-4 col-lg-3">
                <button class="d-block w-100" data-bs-toggle="modal" data-bs-target="#openShiftModal">
                    <i class="fa fa-print fa-2x"></i>
                    <span class="link-title fs-6">Start New Shift</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Start Shift Modal -->
<div class="modal fade" id="openShiftModal" tabindex="-1" aria-labelledby="openShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="openShiftModalLabel">Start New Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="shiftStartForm" class="p-6 bg-white shadow-md rounded-lg" method="POST" action="{{ route('shifts.store') }}">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">

                        <div class="input-group mb-2">
                            <label class="input-group-text">Name:</label>
                            <input type="text" name="name" placeholder="Ex: Morning Shift" required class="form-control border p-2 rounded">
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">Serial Number:</label>
                            <input type="text" id="serial_number" name="serial" readonly class="bg-gray-100 form-control p-2 rounded border">
                            <label id="generate_shift_serial" class="input-group-text"><i class="fa fa-barcode"></i></label>
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">Starts At:</label>
                            <input type="datetime-local" id="starts_at" name="started_at" class="form-control border p-2 rounded">
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">Ends At (Expected):</label>
                            <input type="datetime-local" id="ends_at" name="ended_at" class="form-control border p-2 rounded">
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">Opening Balance:</label>
                            <input type="number" name="opening_balance" value="0" step="0.01" class="form-control border p-2 rounded">
                        </div>

                        <div class="input-group mb-2">
                            <label class="input-group-text">Auto Close:</label>
                            <select name="autoclose" id="autoClose" class="form-select border p-2 rounded">
                                <option value="0">No (Manual close flexible)</option>
                                <option value="1">Yes (Automatic strict close)</option>
                            </select>
                        </div>

                        <div class="form-floating mb-2 ">
                            <textarea name="opening_notes" class="form-control border px-3 pt-4 rounded" style="min-height: 150px" placeholder="">Everything is ok.</textarea>
                            <label class="form-label">Opening Notes</label>
                        </div>

                    </div>
                    <div class="btn-group d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Open Shift</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    // Shift form functionality
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Profile script loaded');

        // Serial number generator function for shift
        function generateShiftSerialNumber() {
            const today = new Date();
            const day = String(today.getDate()).padStart(2, '0');
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const year = today.getFullYear();

            // Format: ddmmyyyy-01
            const serialNumber = `${day}${month}${year}-01`;
            const serialInput = document.getElementById('serial_number');
            if (serialInput) {
                serialInput.value = serialNumber;
            }
        }

        // Set default time values for shift
        function setShiftDefaultTimes() {
            const today = new Date();

            // Set opening time to today at 8:00 AM
            const openingTime = new Date(today);
            openingTime.setHours(8, 0, 0, 0);

            // Set closing time to today at 4:00 PM
            const closingTime = new Date(today);
            closingTime.setHours(16, 0, 0, 0);

            // Format for datetime-local input (YYYY-MM-DDTHH:MM)
            const startsAtInput = document.getElementById('starts_at');
            const endsAtInput = document.getElementById('ends_at');

            if (startsAtInput) {
                startsAtInput.value = openingTime.toISOString().slice(0, 16);
            }
            if (endsAtInput) {
                endsAtInput.value = closingTime.toISOString().slice(0, 16);
            }
        }

        // Attach event listener to generate button
        const generateShiftBtn = document.getElementById('generate_shift_serial');
        if (generateShiftBtn) {
            console.log('Shift generate button found');
            generateShiftBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Shift generate button clicked');
                generateShiftSerialNumber();
            });
        } else {
            console.log('Shift generate button not found');
        }

        // Auto-generate serial number and set default times when modal opens
        const shiftModal = document.getElementById('openShiftModal');
        if (shiftModal) {
            console.log('Shift modal found');
            shiftModal.addEventListener('show.bs.modal', function() {
                console.log('Shift modal opening');
                setTimeout(function() {
                    generateShiftSerialNumber();
                    setShiftDefaultTimes();
                }, 100);
            });
        } else {
            console.log('Shift modal not found');
        }

        // Test function for debugging
        window.testShiftGenerate = function() {
            console.log('Test shift generate called');
            generateShiftSerialNumber();
            setShiftDefaultTimes();
        };
    });
</script>
@endsection