@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.salary.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label for="employee" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="id_employee" class="form-control">
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('id_department')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        <small class="form-text text-muted">Please select a employee name</small>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Gaji Pokok</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                            value="{{ old('basic_salary') }}" required>
                        @error('basic_salary')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Tunjangan</label>
                    <div class="col-11">
                        <input type="number" class="form-control" id="allowances" name="allowances"
                            value="{{ old('allowances') }}" required>
                        @error('allowances')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Potongan</label>
                    <div class="col-11">
                        <input type="number" class="form-control" id="deductions" name="deductions"
                            value="{{ old('deductions') }}">
                        @error('deductions')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label"></label>
                    <div class="col-11">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.salary.index') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
