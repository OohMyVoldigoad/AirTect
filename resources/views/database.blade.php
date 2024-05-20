<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome</h1>
    @if(session('stations'))
        <h2>Search results:</h2>
        <table>
            <thead>
                <tr>
                    <th>Station Name</th>
                    <th>AQI</th>
                    <th>Time</th>
                    <th>Humidity</th>
                    <th>Temperature</th>
                    <th>Atmospheric Pressure</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('stations') as $station)
                    <tr>
                        <td>{{ $station->station_name }}</td>
                        <td>{{ $station->aqi }}</td>
                        <td>{{ $station->time }}</td>
                        <td>{{ $station->humidity }}%</td>
                        <td>{{ $station->temperature }}°C</td>
                        <td>{{ $station->atmospheric_pressure }} hPa</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No data available.</p>
    @endif
</body>
</html>
