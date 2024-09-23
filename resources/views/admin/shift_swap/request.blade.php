@section('content')
    {{-- <div class="container">
        <h2>Request Shift Swap</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ url('/shift-swap/request') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_schedule_from">Your Current Shift</label>
                <select name="id_schedule_from" class="form-control" required>
                    <option value="">Select Your Shift</option>
                    @foreach ($mySchedules as $schedule)
                        <option value="{{ $schedule->id_schedule }}">
                            {{ $schedule->shift }} ({{ $schedule->date }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_schedule_to">Swap With Shift</label>
                <select name="id_schedule_to" class="form-control" required>
                    <option value="">Select Swap Shift</option>
                    @foreach ($otherSchedules as $schedule)
                        <option value="{{ $schedule->id_schedule }}">
                            {{ $schedule->shift }} ({{ $schedule->date }})
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Request Swap</button>
        </form>
    </div> --}}
    <form action="{{ url('/shift-swap/request') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_schedule_from">Your Current Shift</label>
            <select name="id_schedule_from" class="form-control" required>
                <option value="">Select Your Shift</option>
                @foreach ($mySchedules as $schedule)
                    <option value="{{ $schedule->id_schedule }}">
                        {{ $schedule->shift }} ({{ $schedule->date }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="id_schedule_to">Swap With Shift</label>
            <select name="id_schedule_to" class="form-control" required>
                <option value="">Select Swap Shift</option>
                @foreach ($otherSchedules as $schedule)
                    <option value="{{ $schedule->id_schedule }}">
                        {{ $schedule->shift }} ({{ $schedule->date }})
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Request Swap</button>
    </form>
@endsection
