@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.employee.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Nama</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Email</label>
                    <div class="col-md-10">
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required>
                        @error('email')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Alamat</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="address" name="address"
                            value="{{ old('address') }}" required>
                        @error('address')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Jenis Kelamin</label>
                    <div class="col-md-10">
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('gender')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">No HP</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                            required>
                        @error('no_hp')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Posisi</label>
                    <div class="col-md-10">
                        <select class="form-control" id="id_position" name="id_position" required>
                            <option value="" disabled selected>-- Pilih Posisi --</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id_position }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                        @error('id_position')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        {{-- <small class="form-text text-muted">Tolong pilih posisi</small> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Departemen</label>
                    <div class="col-md-10">
                        <select class="form-control" id="id_department" name="id_department" required>
                            <option value="" disabled selected>-- Pilih Departemen --</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id_department }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('id_department')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                        {{-- <small class="form-text text-muted">Tolong pilih departemen</small> --}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label"></label>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.employee.index') }}">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .phone-input-container {
            display: flex;
            align-items: center;
            border: 1px solid black;
            padding: 5px;
            width: 300px;
        }

        .country-code {
            font-size: 24px;
            margin-right: 10px;
        }

        .phone-input {
            border: none;
            outline: none;
            flex-grow: 1;
            font-size: 24px;
        }
    </style>
@endpush

@push('js')
@endpush
