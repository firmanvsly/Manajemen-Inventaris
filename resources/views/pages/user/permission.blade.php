@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>User</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="active">User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form action="{{ route('user.store.permission') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="card-header">
                                Ubah Permission
                            </div>
                            <div class="card-body card-block">
                                @if ($errors->any())
                                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif
                                @if ($data->role->nama_role == 'Manager')
                                    <div class="row form-group">
                                        <div class="col col-md-3"><label class=" form-control-label">User</label></div>
                                        <div class="col col-md-9">
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <label for="userCreate" class="form-check-label ">
                                                        <input type="checkbox" id="userCreate" name="user_create" value="1"
                                                            class="form-check-input"
                                                            {{ isset($permission['user']) ? (isset($permission['user']['create']) ? ($permission['user']['create'] == 1 ? 'checked' : '') : '') : '' }}>Create
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="userRead" class="form-check-label ">
                                                        <input type="checkbox" id="userRead" name="user_read" value="1"
                                                            class="form-check-input"
                                                            {{ isset($permission['user']) ? (isset($permission['user']['read']) ? ($permission['user']['read'] == 1 ? 'checked' : '') : '') : '' }}>Read
                                                    </label>
                                                </div>
                                                <div class="checkbox">
                                                    <label for="userUpdate" class="form-check-label ">
                                                        <input type="checkbox" id="userUpdate" name="user_update" value="1"
                                                            class="form-check-input"
                                                            {{ isset($permission['user']) ? (isset($permission['user']['update']) ? ($permission['user']['update'] == 1 ? 'checked' : '') : '') : '' }}>Update
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Barang</label></div>
                                    <div class="col col-md-9">
                                        <input type="hidden" name="id_user" value="{{ $data->id }}">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <label for="barangCreate" class="form-check-label ">
                                                    <input type="checkbox" id="barangCreate" name="barang_create" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['barang']) ? (isset($permission['barang']['create']) ? ($permission['barang']['create'] == 1 ? 'checked' : '') : '') : '' }}>Create
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="barangRead" class="form-check-label ">
                                                    <input type="checkbox" id="barangRead" name="barang_read" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['barang']) ? (isset($permission['barang']['read']) ? ($permission['barang']['read'] == 1 ? 'checked' : '') : '') : '' }}>Read
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="barangUpdate" class="form-check-label ">
                                                    <input type="checkbox" id="barangUpdate" name="barang_update" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['barang']) ? (isset($permission['barang']['update']) ? ($permission['barang']['update'] == 1 ? 'checked' : '') : '') : '' }}>Update
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="barangDelete" class="form-check-label ">
                                                    <input type="checkbox" id="barangDelete" name="barang_delete" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['barang']) ? (isset($permission['barang']['delete']) ? ($permission['barang']['delete'] == 1 ? 'checked' : '') : '') : '' }}>Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Ruangan</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <label for="ruanganCreate" class="form-check-label ">
                                                    <input type="checkbox" id="ruanganCreate" name="ruangan_create"
                                                        value="1" class="form-check-input"
                                                        {{ isset($permission['ruangan']) ? (isset($permission['ruangan']['create']) ? ($permission['ruangan']['create'] == 1 ? 'checked' : '') : '') : '' }}>Create
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="ruanganRead" class="form-check-label ">
                                                    <input type="checkbox" id="ruanganRead" name="ruangan_read" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['ruangan']) ? (isset($permission['ruangan']['read']) ? ($permission['ruangan']['read'] == 1 ? 'checked' : '') : '') : '' }}>Read
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="ruanganUpdate" class="form-check-label ">
                                                    <input type="checkbox" id="ruanganUpdate" name="ruangan_update"
                                                        value="1" class="form-check-input"
                                                        {{ isset($permission['ruangan']) ? (isset($permission['ruangan']['update']) ? ($permission['ruangan']['update'] == 1 ? 'checked' : '') : '') : '' }}>Update
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="ruanganDelete" class="form-check-label ">
                                                    <input type="checkbox" id="ruanganDelete" name="ruangan_delete"
                                                        value="1" class="form-check-input"
                                                        {{ isset($permission['ruangan']) ? (isset($permission['ruangan']['delete']) ? ($permission['ruangan']['delete'] == 1 ? 'checked' : '') : '') : '' }}>Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($data->role->nama_role == 'Manager')
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Kategori</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <label for="kategoriCreate" class="form-check-label ">
                                                    <input type="checkbox" id="kategoriCreate" name="kategori_create" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['kategori']) ? (isset($permission['kategori']['create']) ? ($permission['kategori']['create'] == 1 ? 'checked' : '') : '') : '' }}>Create
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="kategoriRead" class="form-check-label ">
                                                    <input type="checkbox" id="kategoriRead" name="kategori_read" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['kategori']) ? (isset($permission['kategori']['read']) ? ($permission['kategori']['read'] == 1 ? 'checked' : '') : '') : '' }}>Read
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="kategoriUpdate" class="form-check-label ">
                                                    <input type="checkbox" id="kategoriUpdate" name="kategori_update" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['kategori']) ? (isset($permission['kategori']['update']) ? ($permission['kategori']['update'] == 1 ? 'checked' : '') : '') : '' }}>Update
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label for="kategoriDelete" class="form-check-label ">
                                                    <input type="checkbox" id="kategoriDelete" name="kategori_delete" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['kategori']) ? (isset($permission['kategori']['delete']) ? ($permission['kategori']['delete'] == 1 ? 'checked' : '') : '') : '' }}>Delete
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Laporan</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check">
                                            <div class="checkbox">
                                                <label for="laporan" class="form-check-label ">
                                                    <input type="checkbox" id="laporan" name="laporan" value="1"
                                                        class="form-check-input"
                                                        {{ isset($permission['laporan']) ? (isset($permission['laporan']['download']) ? ($permission['laporan']['download'] == 1 ? 'checked' : '') : '') : '' }}>Download
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fa fa-dot-circle-o"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div>
@endsection
