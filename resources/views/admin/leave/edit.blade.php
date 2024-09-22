@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.leave.update', $leave->id_leave) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="name" class="form-control">
                            <option value="" disabled selected>-- Pilih Nama --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}"
                                    {{ $leave->id_employee == $employee->id_employee ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Silakan pilih nama karyawan</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Tanggal Mulai</label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date', $leave->start_date) }}" required>
                        @error('start_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Tanggal Berakhir</label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ old('end_date', $leave->end_date) }}" required>
                        @error('end_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Alasan</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="reason" name="reason"
                            value="{{ old('reason', $leave->reason) }}" required>
                        @error('reason')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-md-1 col-form-label control-label">Status</label>
                    <div class="col-md-11">
                        <select name="status" id="status" class="form-control">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="approved" {{ $leave->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $leave->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="in_process" {{ $leave->status == 'in_process' ? 'selected' : '' }}>In Process
                            </option>
                        </select>
                        <small class="form-text text-muted">Silakan pilih status</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Update Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.leave.index') }}">Kembali</a>
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
