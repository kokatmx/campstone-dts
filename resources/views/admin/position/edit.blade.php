@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.position.update', $position->id_position) }}" class="form-horizontal">
                @csrf
                @method('PUT')

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Nama Posisi</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $position->name) }}" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Deskripsi</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="description" name="description"
                            value="{{ old('description', $position->description) }}" required>
                        @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Deskripsi</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary"
                            value="{{ old('basic_salary', $position->basic_salary) }}" required>
                        @error('basic_salary')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Update Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.position.index') }}">Kembali</a>
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
