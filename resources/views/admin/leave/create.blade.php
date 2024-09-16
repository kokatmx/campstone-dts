@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.schedule.store') }}" class="form-horizontal">
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
                    <label for="shift" class="col-md-1 col-form-label control-label">Shift</label>
                    <div class="col-md-11">
                        <select name="shift" id="shift" class="form-control">
                            <option value="" disabled selected>-- Pilih Shift --</option>
                            <option value="pagi">Pagi</option>
                            <option value="siang">Siang</option>
                            <option value="malam">Malam</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
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
