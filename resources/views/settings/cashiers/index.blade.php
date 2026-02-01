@extends('layouts.app')

@section('title', 'أجهزة الكاشير')

@section('content')
    <x-breadcrumbs :breadcrumbs="[['url' => route('cashiers.index'), 'label' => 'أجهزة الكاشير']]" />

    <div class="row">
        <div class="col-md-12">
            <h2>أجهزة الكاشير</h2>
        </div>
        @forelse ($cashiers as $cashier)
            <div class="col-md-4">
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
@endsection
