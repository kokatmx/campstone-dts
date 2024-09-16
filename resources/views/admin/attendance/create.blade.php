@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.attendance.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label for="id_employee" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="id_employee" class="form-control">
                            <option value="" disabled selected>-- Pilih Nama --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @error('id_employee')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="date" class="col-md-1 col-form-label control-label">Tanggal</label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" id="date" name="date" required>
                        @error('date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="time_in" class="col-md-1 col-form-label control-label">Jam Masuk</label>
                    <div class="col-md-11">
                        <input type="time" class="form-control" id="time_in" name="time_in" required>
                        @error('time_in')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="time_out" class="col-md-1 col-form-label control-label">Jam Keluar</label>
                    <div class="col-md-11">
                        <input type="time" class="form-control" id="time_out" name="time_out" required>
                        @error('time_out')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>


                <div class="form-group row">
                    <label for="status" class="col-md-1 col-form-label control-label">Status</label>
                    <div class="col-md-11">
                        <select name="status" id="status" class="form-control">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="in_process">In Process</option>
                        </select>
                        @error('status')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="notes" class="col-md-1 col-form-label control-label">Catatan</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="notes" name="notes">
                        @error('note')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        <small class="form-text text-muted">Boleh tidak diisi</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.attendance.index') }}">Kembali</a>
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
