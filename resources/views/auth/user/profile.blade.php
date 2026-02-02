@extends('layouts.app')

@section('content')
    <div class="container">
        <x-breadcrumbs :breadcrumbs="[['url' => route('cashiers.index'), 'label' => 'أجهزة الكاشير']]" />

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
                    <a href="{{ route('pos-sessions.open') }}" class="setting-link col-sm-6 col-md-4 col-lg-3">
                        <i class="fa fa-print fa-2x"></i>
                        <span class="link-title fs-6" style="">Start POS Session</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
