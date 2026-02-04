@extends('layouts.app')

@section('title', 'Shifts')

@section('content')
    <style>
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
        <fieldset class="mt-4">
            <legend>Application Shifts</legend>
            <div class="d-flex justify-content-between align-items-center">
                <div class="page-heading-title">
                    <x-breadcrumbs :breadcrumbs="[['url' => '', 'label' => 'Shifts']]" />
                </div>
                <div class="page-heading-actions">
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="quick-action-btn"><i
                            data-bs-toggle="tooltip" data-bs-title="Add New Shift" class="fa fa-plus fa-2x"></i></button>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Current Shift</legend>
            <div class="row">
                <!-- Shift #0231 - Current -->
                @if ($currentShift)
                    <div class="col-md-12 mb-3">
                        <div class="card shift-card" style="background-color: #b7f1c885">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5>{{ $currentShift->name }}</h5>
                                <span class="badge bg-success">Current Shift</span>
                            </div>
                            <p><i class="bi bi-clock"></i> Started {{ $currentShift->started_at }} </p>
                            <p class="timer">Remaining: <span data-end-time="{{ $currentShift->ended_at }}"
                                    id="countdown">00:00:00</span></p>
                            <div class="d-flex justify-content-end">
                                <a onclick="endShift(this)" data-end-action="{{ route('shifts.end', $currentShift->id) }}"
                                    class="btn py-0 btn-outline-danger">End Shift</a>
                                <a href="{{ route('shifts.edit', $currentShift->id) }}"
                                    class="btn py-0 btn-outline-primary">Edit Shift</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 mb-3"> No active shifts yet, start adding &nbsp; <button data-bs-toggle="modal"
                            data-bs-target="#openShiftModal" class="btn btn-outline-primary py-0"><i
                                data-bs-toggle="tooltip" data-bs-title="Add New Shift" class="fa fa-plus"></i> new
                            shifts</button> &nbsp; for this day.
                    </div>
                @endif
            </div>
        </fieldset>

        <!-- Search Form -->
        <fieldset>
            <legend>Search Shifts</legend>
            <form>
                <div class="row mb-3">
                    <div class="icol col-5">
                        <div class="input-group">
                            <label for="after" class="input-group-text">After:</label>
                            <input type="date" class="form-control" name="after" id="after"
                                value="{{ request('after') }}">
                        </div>
                    </div>
                    <div class="icol col-5">
                        <div class="input-group">
                            <label for="before" class="input-group-text">Before:</label>
                            <input type="date" class="form-control" name="before" id="before"
                                value="{{ request('before') }}">
                        </div>
                    </div>
                    <div class="col col-2">
                        <div class="input-group">
                            <button type="submit" class="input-group-text">Filter</button>
                            <a href="{{ route('shifts.index') }}" class="input-group-text">Clear</a>
                        </div>
                    </div>
                </div>
            </form>
        </fieldset>

        <!-- Rendering Old Shifts -->
        <fieldset>
            <legend>Old Shifts</legend>

            <table class="table table-striped w-100 table-hover">
                <thead>
                    <tr>
                        <th scope="col"><i class="fa fa-list-ol"></i></th>
                        <th scope="col">Shift Name</th>
                        <th scope="col">Timing</th>
                        <th scope="col">Ended At</th>
                        <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shifts as $shift)
                        @if ($shift->isCurrent())
                            @continue
                        @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $shift->name }}</strong><br>
                                <div class="badge text-bg-secondary">{{ $shift->serial }}</div>
                                <div class="badge text-bg-success">{{ $shift->sessions->count() }}</div>
                            </td>
                            <td>
                                <p class="m-0"><i class="fa fa-clock"></i> Started {{ $shift->started_at }}</p>
                                <p class="m-0"><i class="fa fa-clock"></i> Ended {{ $shift->ended_at }}</p>
                            </td>


                            <td>
                                <form action="{{ route('shifts.destroy', $shift) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('shifts.show', $shift->id) }}" class="btn"><i
                                            class="fa fa-display"></i></a>
                                    <button type="submit" class="btn text-danger"><i data-bs-toggle="tooltip"
                                            data-bs-title="Delete Shift"" class="fa fa-trash-can"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No shifts yet, start your first one.</td>
                        </tr>
                    @endforelse
                    </tr>
                </tbody>
            </table>

            <div class="p-3">
                {{ $shifts->links() }}
            </div>
        </fieldset>
    </div>

    <!-- Start Shift Modal -->
    <div class="modal fade" id="openShiftModal" tabindex="-1" aria-labelledby="openShiftModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="openShiftModalLabel">Start New Shift</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shiftStartForm" class="p-6 bg-white shadow-md rounded-lg" method="POST"
                        action="{{ route('shifts.store') }}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">

                            <div class="input-group mb-2">
                                <label class="input-group-text">Name:</label>
                                <input type="text" name="name" placeholder="Ex: Morning Shift" required
                                    class="form-control border p-2 rounded">
                            </div>

                            <div class="input-group mb-2">
                                <label class="input-group-text">Serial Number:</label>
                                <input type="text" id="serial_number" name="serial" readonly
                                    class="bg-gray-100 form-control p-2 rounded border">
                                <label id="generate_shift_serial" class="input-group-text"><i
                                        class="fa fa-barcode"></i></label>
                            </div>

                            <div class="input-group mb-2">
                                <label class="input-group-text">Starts At:</label>
                                <input type="datetime-local" id="starts_at" name="started_at"
                                    class="form-control border p-2 rounded">
                            </div>

                            <div class="input-group mb-2">
                                <label class="input-group-text">Ends At (Expected):</label>
                                <input type="datetime-local" id="ends_at" name="ended_at"
                                    class="form-control border p-2 rounded">
                            </div>

                            <div class="input-group mb-2">
                                <label class="input-group-text">Opening Balance:</label>
                                <input type="number" name="opening_balance" value="0" step="0.01"
                                    class="form-control border p-2 rounded">
                            </div>

                            <div class="input-group mb-2">
                                <label class="input-group-text">Auto Close:</label>
                                <select name="autoclose" id="autoClose" class="form-select border p-2 rounded">
                                    <option value="0">No (Manual close flexible)</option>
                                    <option value="1">Yes (Automatic strict close)</option>
                                </select>
                            </div>

                            <div class="form-floating mb-2 ">
                                <textarea name="opening_notes" class="form-control border px-3 pt-4 rounded" style="min-height: 150px"
                                    placeholder="">Everything is ok.</textarea>
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

            // Ending Shift Event Handler

            function endShift(button) {
                button.addEventListener('click', function() {
                    const url = this.getAttribute('data-end-action');
                    // You can add a confirmation dialog here if needed

                    window.location.href = url;
                });
            }

            function countDown(el) {
                const raw = el.getAttribute('data-end-time'); // e.g. "2026-02-03 04:00:00"
                const iso = raw.replace(' ', 'T'); // "2026-02-03T04:00:00"
                let end = new Date(iso);
                console.log('End time: ' + raw);
                console.log('End time Parsed: ' + end);

                setInterval(() => {
                    const now = new Date();

                    // if end is in the past but you still want "next day at same time"
                    if (end < now) {
                        // add 1 day
                        end = new Date(end.getTime() + 24 * 60 * 60 * 1000);
                    }

                    const diff = diffDate(now, end);
                    el.textContent = now < end ? 'Shift Ended at: ' + end.toLocaleString() : diff;
                }, 1000);
            }

            function diffDate(d1, d2) {
                let diff = (d2 - d1) / 1000;
                if (diff < 0) diff = 0;

                const hours = Math.floor(diff / 3600);
                const minutes = Math.floor((diff % 3600) / 60);
                const seconds = Math.floor(diff % 60);

                return (
                    (hours - 12).toString().padStart(2, '0') + ':' +
                    minutes.toString().padStart(2, '0') + ':' +
                    seconds.toString().padStart(2, '0')
                );
            }

            // make sure this matches your HTML
            const remainingElement = document.getElementById('countdown');
            if (remainingElement) {
                countDown(remainingElement);
            }

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

            // Set default time values for shift, considering time zone offset {+3 Hours}
            function setShiftDefaultTimes() {
                const today = new Date();

                // Set opening time to today at 8:00 AM, considering time zone offset {+3 Hours}
                const openingTime = new Date(today);
                const offsetHours = 3;
                openingTime.setHours(8 + offsetHours, 0, 0, 0);

                // Set closing time to today at 4:00 PM, considering time zone offset {+3 Hours}
                const closingTime = new Date(today);
                closingTime.setHours(16 + offsetHours, 0, 0, 0);

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
