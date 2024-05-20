<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #222831;
            color: #EEEEEE;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .card {
            max-width: 50rem;
            background-color: #31363F;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            z-index: 1;
        }

        .progress-circle {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #76ABAE;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px;
        }

        .progress-text {
            font-size: 14px;
            color: #EEEEEE;
            text-align: center;
        }

        .circle-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .saran {
            margin-top: 20px;
            text-align: center;
        }

        .saran img {
            max-width: 100px;
            margin-top: 10px;
        }

        .alert {
            color: #ffffff;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .alert-sehat {
            background-color: #009966;
        }

        .alert-hati-hati {
            background-color: #ffde33;
        }

        .alert-danger {
            background-color: #cc0033;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="card text-center">
        <div class="title">
            <h2>Air Quality Index</h2>
            @if(isset($station))
                <div class="circle-container">
                    <div id="humidity-progress" class="progress-circle">
                        <div class="progress-text">Humidity: <span id="humidity-value">{{ $station->humidity ?? 'N/A' }}</span> %</div>
                    </div>
                    <div id="temperature-progress" class="progress-circle">
                        <div class="progress-text">Temperature: <span id="temperature-value">{{ $station->temperature ?? 'N/A' }}</span> °C</div>
                    </div>
                    <div id="atmos-progress" class="progress-circle">
                        <div class="progress-text">Carbon Monoxide: <span id="atmos-value">{{ $station->atmospheric_pressure ?? 'N/A' }}</span> ppm</div>
                    </div>
                    <div id="aqi-progress" class="progress-circle">
                        <div class="progress-text">AQI: <span id="aqi-value">{{ $station->aqi ?? 'N/A' }}</span></div>
                    </div>
                </div>

                @php
                    $saranData = null;
                    if ($station->aqi < 50) {
                        $saranData = App\Models\Saran::where('tipe', 'sehat')->first();
                    } elseif ($station->aqi < 100) {
                        $saranData = App\Models\Saran::where('tipe', 'hati-hati')->first();
                    } else {
                        $saranData = App\Models\Saran::where('tipe', 'danger')->first();
                    }
                @endphp

                @if($saranData)
                    <div class="saran">
                        <div class="alert alert-{{ $saranData->tipe }}">
                            <strong>Saran:</strong> {{ $saranData->saran }}
                        </div>
                        <div>
                            <img src="{{ asset('storage/images/' . $saranData->gambar) }}" alt="Saran Image">
                        </div>
                    </div>
                @else
                    <div class="saran">
                        <div class="alert alert-warning">
                            <strong>Saran:</strong> Data saran tidak tersedia untuk nilai AQI ini.
                        </div>
                    </div>
                @endif
            @else
                <p>No data available</p>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": {
                    "value": 53,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 23.67442924896818,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
        });
    </script>
</body>
</html>
