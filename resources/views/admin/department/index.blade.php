@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('admin.department.create') }}">Tambah</a>
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
                <table class="table table-bordered table-striped table-hover table-sm" id="table_department">
                    <thead>
                        <tr>
                            <th>Nomor</th>
                            <th>Nama Departemen</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

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
            $('#table_department').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.department.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "",
                        orderable: true,
                        searchable: false,
                    }, {
                        data: 'name',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'description',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
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
                        orderable: true,
                        searchable: true
                    },
                    {
                        targets: 1, // Asumsikan kolom nama ada di indeks 1
                        data: 'name',
                        visible: true,
                        orderable: true,
                        searchable: true,
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ],
            });
        });
    </script>
@endpush
