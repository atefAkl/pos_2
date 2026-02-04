@extends('layouts.app')

@section('title', 'Shift')

@section('content')

    </style>
    <div class="container">
        <fieldset class="mt-4">
            <legend>{{ $shift->name }}</legend>
            <div class="d-flex justify-content-between align-items-center">
                <div class="page-heading-title">
                    <x-breadcrumbs :breadcrumbs="[
                        ['url' => route('shifts.index'), 'label' => 'Shifts'],
                        ['url' => '', 'label' => 'Show ' . $shift->name . ' Info'],
                    ]" />
                </div>
                <div class="">
                    <form action="{{ route('shifts.destroy', $shift) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn px-1"><i data-bs-toggle="tooltip" data-bs-title="Delete Shift"
                                class="fa fa-trash-can"></i></button>
                        <button class="btn px-1"><i data-bs-toggle="tooltip" data-bs-title="Start Shift"
                                class="fa fa-play-circle"></i></button>
                        <button class="btn px-1"><i data-bs-toggle="tooltip" data-bs-title="Pause Shift"
                                class="fa fa-pause-circle"></i></button>
                        <button class="btn px-1"><i data-bs-toggle="tooltip" data-bs-title="End Shift"
                                class="fa fa-circle-stop"></i></button>
                    </form>
                </div>
            </div>
        </fieldset>


        <!-- Rendering Old Shifts -->
        <fieldset>
            <legend>Shift Info</legend>

            <h5 class="mb-0">{{ $shift->name }} | {{ $shift->serial }}</h5>
            <small class="text-muted">
                <strong>Started: </strong><span>{{ $shift->started_at }}</span> &nbsp;
                <strong>Ended: </strong><span>{{ $shift->ended_at }}</span>
            </small>
            <hr>

            <h5>Sessions</h5>
            <table class="table table-striped w-100 table-hover">
                <thead>

                    <tr>
                        <th scope="col"><i class="fa fa-list-ol"></i></th>
                        <th scope="col">Terminal</th>
                        <th scope="col">Opening Balance</th>
                        <th scope="col">Closing Balance</th>
                        <th scope="col">Cashier</th>
                        <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shift->sessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $session->terminal->name }}</td>
                            <td>{{ $session->opening_balance }}</td>
                            <td>{{ $session->closing_balance }}</td>
                            <td>{{ $session->cashier->name }}</td>
                            <td>
                                <a><i data-bs-toggle="tooltip" data-bs-title="View Session" class="fas fa-expand"></i></a>
                                <a><i data-bs-toggle="tooltip" data-bs-title="Start Session" class="fas fa-play"></i></a>
                                <a><i data-bs-toggle="tooltip" data-bs-title="Pause Session" class="fas fa-pause"></i></a>
                                <a>
                                    <i data-bs-toggle="tooltip" data-bs-title="End Session" class="fas fa-stop"></i>
                                </a>
                                <a><i data-bs-toggle="tooltip" data-bs-title="Delete Session"
                                        class="fas fa-trash-alt"></i></a>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No shift sessions yet, <a data-bs-toggle="modal"
                                    data-bs-target="#OpenSession" class="text-primary">start session.</a></td>
                        </tr>
                    @endforelse
                    </tr>
                </tbody>
            </table>

        </fieldset>
    </div>

    {{-- Modals --}}
    <div class="modal fade" id="OpenSession" tabindex="-1" aria-labelledby="OpenSessionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="OpenSessionLabel">Open New POS Session</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pos-sessions.open') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="shift_id" value="{{ $shift->id }}">
                        <div class="input-group mb-3">
                            <label for="name" class="input-group-text">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <label for="terminal" class="input-group-text">Terminal</label>
                            <select class="form-select" id="terminal" name="terminal" required>
                                @foreach ($terminals as $terminal)
                                    <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label for="user_id" class="input-group-text">Cashier</label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                @foreach ($cashiers as $cashier)
                                    <option value="{{ $cashier->id }}">{{ $cashier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group mb-3">
                            <label for="opening_balance" class="input-group-text">Opening Balance:</label>
                            <input type="text" class="form-control" id="opening_balance" name="opening_balance"
                                required>
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
