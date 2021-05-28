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
                        <li><a href="#">Dashboard</a></li>
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
                        <form action="{{ route('user.store') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="card-header">
                                Tambah User
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
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Nama</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="text-input" name="name"
                                            placeholder="Nama" class="form-control" value="{{ old('name') }}" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Username</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="text-input" name="username"
                                            placeholder="Username" class="form-control" value="{{ old('username') }}"
                                            required></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password-input"
                                            class=" form-control-label">Password</label></div>
                                    <div class="col-12 col-md-9"><input type="password" id="password" name="password"
                                            placeholder="Password" class="form-control" required></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="password-input"
                                            class=" form-control-label">Password Confirmation</label></div>
                                    <div class="col-12 col-md-9"><input type="password" id="password_confirmation"
                                            name="password_confirmation" placeholder="Password Confirmation"
                                            class="form-control" required></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="select" class=" form-control-label">Role</label>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <select name="id_role" id="select" class="form-control" required>
                                            <option>Select Role</option>
                                            @foreach ($role as $r)
                                                <option value="{{ $r->id }}"
                                                    {{ old('id_role') == $r->id ? 'selected' : '' }}>{{ $r->nama_role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
