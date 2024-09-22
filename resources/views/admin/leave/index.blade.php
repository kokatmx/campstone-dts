@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('admin.leave.create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="table_leave">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    <script>
        $(document).ready(function() {
            $('#table_leave').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.leave.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: "text-center",
                        orderable: true,
                        searchable: false,
                    }, {
                        data: 'employee.name',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'start_date',
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            // Format tanggal menjadi dd/mm/yy
                            if (data) {
                                var date = new Date(data);
                                var day = ("0" + date.getDate()).slice(-2);
                                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear(); // Ambil 2 digit terakhir dari tahun
                                // var year = date.getFullYear().toString().slice(-
                                // 2); // Ambil 2 digit terakhir dari tahun
                                return day + '/' + month + '/' + year;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'end_date',
                        className: "",
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            // Format tanggal menjadi dd/mm/yy
                            if (data) {
                                var date = new Date(data);
                                var day = ("0" + date.getDate()).slice(-2);
                                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear(); // Ambil 2 digit terakhir dari tahun
                                // var year = date.getFullYear().toString().slice(-
                                // 2); // Ambil 2 digit terakhir dari tahun
                                return day + '/' + month + '/' + year;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'reason',
                        className: "",
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'status',
                        className: "",
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'aksi',
                        className: "",
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    search: "🔍 Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                },
                columnDefs: [{
                        targets: 0,
                        title: 'Nomor',
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: 1, // Asumsikan kolom nama ada di indeks 1
                        data: 'employee.name',
                        visible: true,
                        orderable: true,
                        searchable: true,
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endpush
