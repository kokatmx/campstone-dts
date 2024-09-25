@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.salary.store') }}" class="form-horizontal">
                @csrf
                <div class="form-group row">
                    <label for="id_employee" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="id_employee" class="form-control">
                            <option value="" disabled selected>-- Pilih Nama Karyawan --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id_employee }}">{{ $employee->user->name }}</option>
                            @endforeach
                        </select>
                        @error('id_employee')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror

                    </div>
                </div>

                <div class="form-group row">
                    <label for="position" class="col-md-1 col-form-label control-label">Posisi</label>
                    <div class="col-md-11">
                        <select name="id_position" id="id_position" class="form-control">
                            <option value="" disabled selected>-- Pilih Posisi --</option>

                            @foreach ($positions as $position)
                                <option value="{{ $position->id_position }}"
                                    data-basic-salary="{{ $position->basic_salary }}">
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_position')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Gaji Pokok</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary" required readonly>
                        @error('basic_salary')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Tunjangan</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="allowances" name="allowances" required>
                        @error('allowances')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Potongan</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="deductions" name="deductions" required>
                        @error('deductions')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label"></label>
                    <div class="col-md-11">
                        <button type="submit" class="btn btn-primary btn-sm">Tambah Data</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ route('admin.salary.index') }}">Kembali</a>
                    </div>
                </div>
            </form>

            {{-- ini kenapa --}}
            {{-- <form method="POST" action="{{ route('admin.salary.store') }}" class="form-horizontal">
                @csrf
                <input type="hidden" id="id_position" name="id_position">

                <div class="form-group row">
                    <label for="employee" class="col-md-1 col-form-label control-label">Nama Karyawan</label>
                    <div class="col-md-11">
                        <select name="id_employee" id="id_employee" class="form-control">
                            <option value="">Pilih Karyawan</option>
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
                    <label class="col-md-1 control-label col-form-label">Posisi</label>
                    <div class="col-md-11">
                        <input type="text" class="form-control" id="position" name="id_position" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Gaji Pokok</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="basic_salary" name="basic_salary" readonly>
                        @error('basic_salary')
                            <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Tunjangan</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="allowances" name="allowances"
                            value="{{ old('allowances') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-1 control-label col-form-label">Potongan</label>
                    <div class="col-md-11">
                        <input type="number" class="form-control" id="deductions" name="deductions"
                            value="{{ old('deductions') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-11 offset-md-1">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                        <a href="{{ route('admin.salary.index') }}" class="btn btn-secondary ml-1">Kembali</a>
                    </div>
                </div>
            </form> --}}
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        document.getElementById('id_position').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var basicSalary = selectedOption.getAttribute('data-basic-salary');

            // Mengisi input basic_salary dengan nilai dari posisi yang dipilih
            document.getElementById('basic_salary').value = basicSalary;
        });

        // $('#id_employee').change(function() {
        //     var id_employee = $(this).val();

        //     if (id_employee) {
        //         $.ajax({
        //             url: '/employee-position/' + id_employee,
        //             type: 'GET',
        //             success: function(data) {
        //                 if (data.position) {
        //                     $('#position').val(data.position);
        //                     $('#basic_salary').val(data.basic_salary);
        //                     $('#id_position').val(data.id_position); // Set hidden field for id_position
        //                 } else {
        //                     $('#position').val('');
        //                     $('#basic_salary').val('');
        //                     $('#id_position').val('');
        //                 }
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error(xhr.responseText);
        //             }
        //         });
        //     } else {
        //         $('#position').val('');
        //         $('#basic_salary').val('');
        //         $('#id_position').val('');
        //     }
        // });
    </script>
@endpush
