<div class="container">
    <h2>Jadwal Anda</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->date }}</td>
                    <td>{{ $schedule->shift }}</td>
                    <td>{{ $schedule->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
