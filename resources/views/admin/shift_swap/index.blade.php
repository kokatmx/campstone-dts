@extends('layouts.template')

@section('content')
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-4">Pergantian Shift</h2>

        <form action="{{ route('shift-changes.store') }}" method="POST" class="mb-6">
            @csrf
            <div class="mb-4 flex">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="w-1/2 mr-2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_schedule_from">
                        Jadwal Asal
                    </label>
                    <select name="id_schedule_from" id="id_schedule_from"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->id_schedule }}">
                                {{ $schedule->employee->name }} - {{ $schedule->start_date }} to {{ $schedule->end_date }}
                                ({{ ucfirst($schedule->shift) }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/2">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="id_schedule_to">
                        Jadwal Tujuan
                    </label>
                    <select name="id_schedule_to" id="id_schedule_to"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->id_schedule }}">
                                {{ $schedule->employee->name }} - {{ $schedule->start_date }} to {{ $schedule->end_date }}
                                ({{ ucfirst($schedule->shift) }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Ajukan Pergantian Shift
                </button>
            </div>
        </form>

        <table class="w-full">
            <thead>
                <tr>
                    <th class="px-4 py-2">Dari</th>
                    <th class="px-4 py-2">Ke</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shiftChanges as $shiftChange)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $shiftChange->scheduleFrom->employee->name }} -
                            {{ $shiftChange->scheduleFrom->start_date }} to {{ $shiftChange->scheduleFrom->end_date }}
                            ({{ ucfirst($shiftChange->scheduleFrom->shift) }})
                        </td>
                        <td class="border px-4 py-2">
                            {{ $shiftChange->scheduleTo->employee->name }} -
                            {{ $shiftChange->scheduleTo->start_date }} to {{ $shiftChange->scheduleTo->end_date }}
                            ({{ ucfirst($shiftChange->scheduleTo->shift) }})
                        </td>
                        <td class="border px-4 py-2">{{ ucfirst($shiftChange->status) }}</td>
                        <td class="border px-4 py-2">
                            @if ($shiftChange->status === 'diproses')
                                <form action="{{ route('shift-changes.approve', $shiftChange) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-green-500 hover:text-green-700">Setujui</button>
                                </form>
                                |
                                <form action="{{ route('shift-changes.reject', $shiftChange) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Tolak</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@push('css')
@endpush
@push('js')
    {{-- <script>
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
                        orderable: true,
                        searchable: false,
                    }, {
                        data: 'employee.name',
                        name: 'employee.name',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'date',
                        name: 'date',
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
                        data: 'shift',
                        name: 'shift',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'time_in',
                        name: 'time_in',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'time_out',
                        name: 'time_out',
                        className: "",
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: "",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
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
