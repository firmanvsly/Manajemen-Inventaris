@extends('layouts.app')

@section('title', 'Dashboard')

    @push('css-plugin')
    @endpush

@section('content')
    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Kategori</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="active">Kategori</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <strong class="card-title">Laporan</strong>
                        </div>
                        <div class="card-body">
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
                            <form method="post" id="formLaporan">
                                @csrf
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nf-email" class=" form-control-label">Inventaris</label>
                                            <select name="type" class="form-control" required>
                                                <option value="">Select Inventaris</option>
                                                <option value="barang">Barang</option>
                                                <option value="ruangan">Ruangan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nf-email" class=" form-control-label">Tahun</label>
                                            <select name="tahun" class="form-control">
                                                <option value="">Semua</option>
                                                @php
                                                    $tahun = date('Y');
                                                @endphp
                                                @for ($i = $tahun; $i >= 2021; $i--)
                                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nf-email" class=" form-control-label">Bulan</label>
                                            <select name="bulan" class="form-control">
                                                <option value="">Semua</option>
                                                @php
                                                    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                                @endphp
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}">{{ $bulan[$i] }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-center">
                                        <button type="button" id="btnPDF" class="btn btn-danger">Download PDF</button>
                                        <button type="button" id="btnExcel" class="btn btn-success ml-1">Download
                                            Excel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div>
@endsection

@push('js-plugin')
    <script>
        (function($) {
            $('#btnExcel').click(function(e) {
                e.preventDefault();
                $('#formLaporan').attr('action', '{{ route('laporan.excel') }}');
                $('#formLaporan').submit();
            });

            $('#btnPDF').click(function(e) {
                e.preventDefault();;
                $('#formLaporan').attr('action', '{{ route('laporan.pdf') }}');
                $('#formLaporan').submit();
            });
        })(jQuery);

    </script>
@endpush
