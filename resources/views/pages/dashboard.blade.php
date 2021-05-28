@extends('layouts.app')

@section('title', 'Dashboard')

    @push('css-plugin')
    @endpush

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">

        <div class="col-sm-12">
            <div class="alert alert-success" role="alert">
                Selamat datang <strong>{{ ucwords(Auth::user()->name) }}</strong> di Aplikasi <strong>Manajemen
                    Inventaris<strong>
            </div>
        </div>

    </div>
@endsection

@push('js-plugin')
@endpush
