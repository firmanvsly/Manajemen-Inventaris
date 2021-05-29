@extends('layouts.app')

@section('title', 'Dashboard')

    @push('css-plugin')
        <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/sweet-alert/css/sweetalert2.css') }}">
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
                            <strong class="card-title">Kategori</strong>
                            @if (Auth::user()->hasPermission('kategori', 'create'))
                                <a href="{{ route('kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
                            @endif
                        </div>
                        <div class="card-body">
                            @if (Session::has('success'))
                                <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                    {{ Session::get('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @elseif (Session::has('info'))
                                <div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                                    {{ Session::get('info') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @elseif (Session::has('error'))
                                <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                                    {{ Session::get('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                            @endif
                            <table id="kategoriTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div><!-- .animated -->
    </div>
@endsection

@push('js-plugin')
    <script src="{{ asset('assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/init-scripts/data-table/datatables-init.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweet-alert/js/sweetalert.min.js') }}"></script>
    <script>
        (function($) {
            let kategoriTable = $('#kategoriTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('kategori.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kategori',
                        name: 'nama_kategori'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#kategoriTable').on('click', '.btn-delete', function() {
                let id = $(this).data('id')
                delConfirm(id)
            });

            function delConfirm(id) {
                console.log(id);
                swal({
                        title: 'Apakah anda yakin?',
                        text: 'Apakah anda yakin menghapus data ini?',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((result) => {
                        if (result) {
                            jQuery.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                                },
                                type: "DELETE",
                                url: '/kategori/' + id,
                                success: function() {
                                    swal('Berhasil', 'kategori berhasil dihapus!', 'success');
                                    kategoriTable.ajax.reload();
                                },
                                error: function() {
                                    swal('Gagal', 'kategori gagal dihapus!', 'error');
                                }
                            });
                        }
                    });
            }
        })(jQuery);

    </script>
@endpush
