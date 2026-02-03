@extends('layouts.app')

@section('title', 'Shifts')

@section('content')
    <style>
        fieldset {
            position: relative;
            margin: 1rem 1rem 1.5rem;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            padding: 1.5rem 1rem 0;
        }

        legend {
            border: 1px solid #dee2e6;
            position: absolute;
            top: -1rem;
            margin-inline-start: 1.2rem;
            height: 2rem;
            width: auto;
            padding: 0.25rem 0.5rem;
            font: Bolder 1.2rem /1.2 'Cairo', sans-serif;
            color: #555;
            background-color: #fff;
            border-radius: 0.75rem;
        }

        .shift-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1rem;
            background-color: #fff;
        }

        .badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 12px;
        }

        .timer {
            font-family: 'Courier New', monospace;
            font-size: 1rem;
            color: #6c757d;
        }
    </style>

    <div class="container">
        <x-breadcrumbs :breadcrumbs="[['url' => '', 'label' => 'Shifts']]" />

        <div class="card mb-4">
            <div class="row">
                <div class="col-md-12 page-heading">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="page-heading-title">
                            Shifts
                        </div>
                        <div class="page-heading-actions">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="quick-action-btn"><i
                                    class="fa fa-plus fa-2x"></i></button>
                            <button onclick="testGenerate()" class="btn btn-sm btn-info ms-2">Test Script</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <fieldset>
            <legend>Current Shift</legend>
            <div class="row">
                <!-- Shift #0231 - Current -->
                @forelse ($shifts as $shift)
                    @if ($shift->ended_at != null && $shift->ended_at > now())
                        <div class="col-md-12 mb-3">
                            <div class="shift-card" style="background-color: #b7f1c885">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5>{{ $shift->name }}</h5>
                                    <span class="badge bg-success">Current Shift</span>
                                </div>
                                <p><i class="bi bi-clock"></i> Started {{ $shift->started_at }} </p>
                                <p class="timer">Remaining: 02:15:33</p>
                            </div>
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </fieldset>
        <fieldset>
            <legend>Current Shift</legend>
            <div class="row">
                @forelse ($shifts as $shifts)
                    <div class="col-md-6 mb-3">
                        <div class="shift-card">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>{{ $shift->name }}</h5>
                                <span class="badge bg-secondary">old Shift</span>
                            </div>
                            <p><i class="bi bi-clock"></i> Started {{ $shift->started_at }} </p>
                            <p class="timer">Ended At: {{ $shift->ended_at }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 mb-3">
                        <div class="alert alert-info">
                            No shifts yet, start your first one.
                        </div>
                    </div>
                @endforelse
            </div>
        </fieldset>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('shifts.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="input-group mb-3">
                            <label for="name" class="input-group-text">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <label for="s_number" class="input-group-text">Serial No.</label>
                            <input type="text" class="form-control" id="s_number" name="s_number">
                            <button type="button" class="btn btn-outline-secondary" id="generate_serial">
                                <i class="fas fa-sync-alt"></i> Generate
                            </button>
                        </div>
                        <div class="input-group mb-3">
                            <label for="printer" class="input-group-text">Printer.</label>
                            <select type="text" class="form-control" id="printer" name="printer">
                                <option value="Printer 1">Printer 1</option>
                                <option value="Printer 2">Printer 2</option>
                                <option value="Printer 3">Printer 3</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label for="pos_device" class="input-group-text">POS Device.</label>
                            <select type="text" class="form-control" id="pos_device" name="pos_device">
                                <option value="POS Device 1">POS Device 1</option>
                                <option value="POS Device 2">POS Device 2</option>
                                <option value="POS Device 3">POS Device 3</option>
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label for="opening_time" class="input-group-text">Opening Time</label>
                            <input type="time" class="form-control" id="opening_time" name="opening_time" value="08:00">
                        </div>
                        <div class="input-group mb-3">
                            <label for="closing_time" class="input-group-text">Closing Time</label>
                            <input type="time" class="form-control" id="closing_time" name="closing_time"
                                value="16:00">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

<script>
    // Serial number generator function
    function generateSerialNumber() {
        const today = new Date();
        const day = String(today.getDate()).padStart(2, '0');
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const year = today.getFullYear();

        // Format: ddmmyyyy-01
        const serialNumber = `${day}${month}${year}-01`;
        const serialInput = document.getElementById('s_number');
        if (serialInput) {
            serialInput.value = serialNumber;
        }
    }

    // Set default time values
    function setDefaultTimes() {
        const openingTimeInput = document.getElementById('opening_time');
        const closingTimeInput = document.getElementById('closing_time');

        if (openingTimeInput) {
            openingTimeInput.value = '08:00';
        }
        if (closingTimeInput) {
            closingTimeInput.value = '16:00';
        }
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Cashiers script loaded');

        // Test function
        window.testGenerate = function() {
            console.log('Test generate called');
            generateSerialNumber();
            setDefaultTimes();
        };

        // Attach event listener to generate button
        const generateBtn = document.getElementById('generate_serial');
        if (generateBtn) {
            console.log('Generate button found');
            generateBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Generate button clicked');
                generateSerialNumber();
            });
        } else {
            console.log('Generate button not found');
        }

        // Auto-generate serial number and set default times when modal opens
        const modal = document.getElementById('exampleModal');
        if (modal) {
            console.log('Modal found');
            modal.addEventListener('show.bs.modal', function() {
                console.log('Modal opening');
                setTimeout(function() {
                    generateSerialNumber();
                    setDefaultTimes();
                }, 100);
            });
        } else {
            console.log('Modal not found');
        }

        // Also set defaults on page load
        setDefaultTimes();
    });
</script>
