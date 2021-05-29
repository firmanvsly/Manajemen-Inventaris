@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Ruangan</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="active">Ruangan</li>
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
                        <form action="{{ route('ruangan.store') }}" method="post" class="form-horizontal">
                            @csrf
                            <div class="card-header">
                                Tambah Ruangan
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
                                    <div class="col-12 col-md-9">
                                        <input type="hidden" id="text-input" name="type" placeholder="ruangan"
                                            class="form-control" value="ruangan" required>
                                        <input type="text" id="text-input" name="nama" placeholder="Nama"
                                            class="form-control" value="{{ old('nama') }}" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Kategori</label></div>
                                    <div class="col-12 col-md-9">
                                        @if ($kategori->count())
                                            <div class="form-check">
                                                @foreach ($kategori as $k)
                                                    <div class="checkbox">
                                                        <label for="kategori{{ $k->id }}" class="form-check-label ">
                                                            <input type="checkbox" id="kategori{{ $k->id }}"
                                                                name="kategori[]" value="{{ $k->id }}"
                                                                class="form-check-input">{{ $k->nama_kategori }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p>Tidak Ada Kategori</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Jumlah</label></div>
                                    <div class="col-12 col-md-9"><input type="number" id="text-input" name="jumlah"
                                            placeholder="Jumlah" class="form-control" value="{{ old('jumlah') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Kondisi</label></div>
                                    <div class="col-12 col-md-9">
                                        <div class="form-check">
                                            <div class="radio">
                                                <label for="radioBaik" class="form-check-label ">
                                                    <input type="radio" id="radioBaik" name="kondisi" value="baik"
                                                        class="form-check-input"
                                                        {{ old('kondisi') == 'baik' ? 'checked' : '' }}>Baik
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="radioKurang" class="form-check-label ">
                                                    <input type="radio" id="radioKurang" name="kondisi" value="kurang"
                                                        class="form-check-input"
                                                        {{ old('kondisi') == 'kurang' ? 'checked' : '' }}>Kurang
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label for="radioRusak" class="form-check-label ">
                                                    <input type="radio" id="radioRusak" name="kondisi" value="rusak"
                                                        class="form-check-input"
                                                        {{ old('kondisi') == 'rusak' ? 'checked' : '' }}>Rusak
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input"
                                            class=" form-control-label">Keterangan</label></div>
                                    <div class="col-12 col-md-9"><textarea rows="4" name="keterangan"
                                            placeholder="Keterangan"
                                            class="form-control">{{ old('keterangan') }}</textarea>
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
