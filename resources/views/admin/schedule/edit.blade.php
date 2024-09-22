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
                    <label for="name" class="col-md-2 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-10">
                        <select name="id_employee" id="name" class="form-control">
                            <option value="" disabled selected>-- Pilih Nama --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}"
                                    {{ $schedule->id_employee == $employee->id_employee ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <small class="form-text text-muted">Silakan pilih nama karyawan</small> --}}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Tanggal Mulai</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" id="start_date" name="start_date"
                            value="{{ old('start_date', $schedule->start_date) }}" required>
                        @error('start_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Tanggal Berakhir</label>
                    <div class="col-md-10">
                        <input type="date" class="form-control" id="end_date" name="end_date"
                            value="{{ old('end_date', $schedule->end_date) }}" required>
                        @error('end_date')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="shift" class="col-md-2 col-form-label control-label">Shift</label>
                    <div class="col-md-10">
                        <select name="shift" id="shift" class="form-control">
                            <option value="" disabled selected>-- Pilih Shift --</option>
                            <option value="pagi" {{ $schedule->shift == 'pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="siang" {{ $schedule->shift == 'siang' ? 'selected' : '' }}>Siang</option>
                            <option value="malam" {{ $schedule->shift == 'malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                        {{-- <small class="form-text text-muted">Silakan pilih shift</small> --}}
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Catatan</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="note" name="note"
                            value="{{ old('note', $schedule->note) }}" required>
                        @error('note')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label"></label>
                    <div class="col-md-10">
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
