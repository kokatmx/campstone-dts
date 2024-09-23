@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('admin.attendance.create') }}">Tambah</a>
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
                <table class="table table-bordered table-striped table-hover table-sm" id="table_attendance">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Karyawan</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Jam Masuk</th>
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
            $('#table_attendance').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.attendance.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'employee.name',
                        name: 'employee.name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
                        render: function(data) {
                            if (data) {
                                var date = new Date(data);
                                var day = ("0" + date.getDate()).slice(-2);
                                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear();
                                return day + '/' + month + '/' + year;
                            }
                            return data;
                        }
                    },
                    {
                        data: 'shift',
                        name: 'shift',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'time_in',
                        name: 'time_in',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    search: "🔍 Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries"
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endpush
