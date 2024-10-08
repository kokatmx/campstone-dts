@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.department.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Nama Departemen</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label">Deskripsi</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" id="description" name="description" required>
                        @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 control-label col-form-label"></label>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.department.index') }}">Kembali</a>
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
