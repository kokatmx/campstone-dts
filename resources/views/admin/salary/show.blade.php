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
                    <td>{{ $salary->employee->name }}</td>
                </tr>
                <tr>
                    <th>Posisi</th>
                    <td>{{ $salary->employee->position->name }}</td>
                </tr>
                <tr>
                    <th>Nama Departemen</th>
                    <td>{{ $salary->employee->department->name }}</td>
                </tr>
                <tr>
                    <th>Gaji Pokok</th>
                    <td>{{ $salary->basic_salary }}</td>
                </tr>
                <tr>
                    <th>Tunjangan</th>
                    <td>{{ $salary->allowances }}</td>
                </tr>
                <tr>
                    <th>Potongan</th>
                    <td>{{ $salary->deductions }}</td>
                </tr>
                <tr>
                    <th>Total Gaji</th>
                    <td>{{ $salary->total_salary }}</td>
                </tr>
            </table>
            <a href="{{ route('admin.salary.index') }}" class="mt-5 btn btn-sm btn-default">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
