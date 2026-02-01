@extends('layouts.app')

@section('title', 'أجهزة الكاشير')

@section('content')
<x-breadcrumbs :breadcrumbs="[['url' => route('cashiers.index'), 'label' => 'أجهزة الكاشير']]" />

<div class="row">
    <div class="col-md-12">
        <h2>أجهزة الكاشير</h2>
    </div>
</div>
@endsection