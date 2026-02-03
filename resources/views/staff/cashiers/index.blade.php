@extends('layouts.app')

@section('title', 'Cashiers')

@section('content')
    <div class="container">
        <x-breadcrumbs :breadcrumbs="[['url' => '', 'label' => 'Cashiers']]" />

        <div class="card mb-3">
            <div class="row">
                <div class="col-md-12 page-heading">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="page-heading-title">
                            Cashier
                        </div>
                        <div class="page-heading-actions">
                            <a data-bs-toggle="modal" data-bs-target="#newCashier" class="quick-action-btn">
                                <i class="fa fa-plus "></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Created At</th>
                            <th scope="col"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($cashiers as $cashier)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $cashier->name }}</td>
                                <td>{{ $cashier->email }}</td>
                                <td>{{ $cashier->created_at }}</td>
                                <td class="btn-group">
                                    <a href="{{ route('staff.cashiers.profile', $cashier->id) }}" class="btn"><i
                                            class="fa fa-user"></i></a>

                                </td>
                            </tr>

                        @empty
                            <tr class="col-md-12">
                                <td class="alert alert-info">
                                    No Cahiers yet, start adding <a href="{{ route('staff.cashiers.store') }}"
                                        class="text-primary">first one.</a>
                                </td>
                            </tr>
                    </tbody>
                    @endforelse
                </table>
            </div>
        </div>


        <div class="modal fade" id="newCashier" tabindex="-1" aria-labelledby="newCashierLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('staff.cashiers.store') }}" method="post">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="newCashierLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="input-group mb-3">
                                <label for="name" class="input-group-text">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="email" class="input-group-text">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="input-group mb-3">
                                <label for="role" class="input-group-text">role</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option hidden>Select Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="role">Role</option>
                                    <option value="cashier">Cashier</option>
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
    </div>
@endsection
