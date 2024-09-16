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
                    <td>{{ $schedule->employee->name }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ $schedule->date }}</td>
                </tr>
                <tr>
                    <th>Shift</th>
                    <td>{{ $schedule->shift }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.schedule.index') }}" class="mt-5 btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
