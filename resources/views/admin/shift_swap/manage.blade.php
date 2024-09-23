@extends('layouts.template')

@section('content')
    {{-- <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ route('admin.schedule.create') }}">Tambah</a>
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
                <table class="table table-bordered table-striped table-hover table-sm" id="table_schedule">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee From</th>
                            <th>Employee To</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shiftChanges as $change)
                            <tr>
                                <td>{{ $change->id_change }}</td>
                                <td>{{ $change->fromSchedule->employee->name }} ({{ $change->fromSchedule->shift }})</td>
                                <td>{{ $change->toSchedule->employee->name }} ({{ $change->toSchedule->shift }})</td>
                                <td>{{ ucfirst($change->status) }}</td>
                                <td>
                                    @if ($change->status == 'pending')
                                        <form action="{{ url('/shift-swap/approve/' . $change->id_change) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <form action="{{ url('/shift-swap/reject/' . $change->id_change) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-muted">No action available</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Employee From</th>
                <th>Employee To</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shiftChanges as $change)
                <tr>
                    <td>{{ $change->id_change }}</td>
                    <td>{{ $change->fromSchedule->employee->name }} ({{ $change->fromSchedule->shift }})</td>
                    <td>{{ $change->toSchedule->employee->name }} ({{ $change->toSchedule->shift }})</td>
                    <td>{{ ucfirst($change->status) }}</td>
                    <td>
                        @if ($change->status == 'pending')
                            <form action="{{ url('/shift-swap/approve/' . $change->id_change) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ url('/shift-swap/reject/' . $change->id_change) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">No action available</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@push('css')
@endpush
@push('js')
    {{-- <script>
        $(document).ready(function() {
            $('#table_schedule').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.schedule.list') }}",
                    type: "POST",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        className: "",
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
                        orderable: false,
                        searchable: false,
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
                        orderable: false,
                        searchable: false,
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
                        data: 'shift',
                        className: "",
                        orderable: false,
                        searchable: false
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
    </script> --}}
@endpush
