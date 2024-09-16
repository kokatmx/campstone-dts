@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($employee)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ route('admin.employee.index') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ route('admin.employee.update', $employee->id_employee) }}"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ $employee->name }}" required>
                            @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Email</label>
                        <div class="col-11">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $employee->email }}" required>
                            @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Alamat</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ $employee->address }}" required>
                            @error('address')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Jenis Kelamin</label>
                        <div class="col-11">
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ $employee->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                </option>
                                <option value="Perempuan" {{ $employee->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                </option>
                            </select>
                            @error('gender')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">No HP</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="no_hp" name="no_hp"
                                value="{{ $employee->no_hp }}" required>
                            @error('no_hp')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Posisi</label>
                        <div class="col-11">
                            <select class="form-control" id="id_position" name="id_position" required>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id_position }}"
                                        {{ $employee->id_position == $position->id_position ? 'selected' : '' }}>
                                        {{ $position->name }}</option>
                                @endforeach
                            </select>
                            @error('id_position')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Departemen</label>
                        <div class="col-11">
                            <select class="form-control" id="id_department" name="id_department" required>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id_department }}"
                                        {{ $employee->id_department == $department->id_department ? 'selected' : '' }}>
                                        {{ $department->name }}</option>
                                @endforeach
                            </select>
                            @error('id_department')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Update Data</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.employee.index') }}">Kembali</a </div>
                        </div>
                </form>
            @endempty
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush
