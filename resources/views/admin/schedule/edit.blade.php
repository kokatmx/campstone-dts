@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.schedule.update', $schedule->id_schedule) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label for="name" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="name" class="form-control">
                            <option value="" disabled selected>-- Pilih Nama --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}"
                                    {{ $schedule->id_employee == $employee->id_employee ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Silakan pilih nama karyawan</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Tanggal</label>
                    <div class="col-md-11">
                        <input type="date" class="form-control" id="date" name="date"
                            value="{{ old('date', $schedule->date) }}" required>
                        @error('date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="shift" class="col-md-1 col-form-label control-label">Shift</label>
                    <div class="col-md-11">
                        <select name="shift" id="shift" class="form-control">
                            <option value="" disabled selected>-- Pilih Shift --</option>
                            <option value="pagi" {{ $schedule->shift == 'pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="siang" {{ $schedule->shift == 'siang' ? 'selected' : '' }}>Siang</option>
                            <option value="malam" {{ $schedule->shift == 'malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                        <small class="form-text text-muted">Silakan pilih shift</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Update Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.schedule.index') }}">Kembali</a>
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
