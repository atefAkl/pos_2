@extends('layouts.app')

@section('title', 'أجهزة الكاشير')

@section('content')
    <div class="container">
        <x-breadcrumbs :breadcrumbs="[['url' => route('cashiers.index'), 'label' => 'أجهزة الكاشير']]" />

        <div class="card mb-3">
            <div class="row">
                <div class="col-md-12 page-heading">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="page-heading-title">
                            Cashier Devices
                        </div>
                        <div class="page-heading-actions">
                            <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="quick-action-btn"><i
                                    class="fa fa-plus fa-2x"></i></button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($cashiers as $cashier)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cashier->name }}</h5>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-info">
                        لا توجد أجهزة كاشير
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('cashiers.store') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="input-group mb-3">
                            <label for="name" class="input-group-text">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="input-group mb-3">
                            <label for="s_number" class="input-group-text">Serial No.</label>
                            <input type="text" class="form-control" id="s_number" name="s_number">
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
