@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.position.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-md-1 control-label col-form-label">Nama Posisi</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="name" name="name" required>
                        @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="description" class="col-md-1 control-label col-form-label">Deskripsi</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="description" name="description" required>
                        @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Gaji Pokok</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary" required>
                        @error('basic_salary')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
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
