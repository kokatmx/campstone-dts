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
                    <td>{{ $employee->user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $employee->user->email }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $employee->address }}</td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td>{{ $employee->gender }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $employee->no_hp }}</td>
                </tr>
                <tr>
                    <th>Posisi</th>
                    <td>{{ $employee->position->name }}</td>
                </tr>
                <tr>
                    <th>Departemen</th>
                    <td>{{ $employee->department->name }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.employee.index') }}" class="mt-5 btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
