@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nama Karyawan</th>
                    <td>{{ $leave->employee->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Mulai</th>
                    <td>{{ $leave->start_date }}</td>
                </tr>
                <tr>
                    <th>Tanggal Berakhir</th>
                    <td>{{ $leave->end_date }}</td>
                </tr>
                <tr>
                    <th>Alasan</th>
                    <td>{{ $leave->reason }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $leave->status }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.leave.index') }}" class="mt-5 btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
