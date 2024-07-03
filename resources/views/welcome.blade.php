<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Air Quality Index</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body{
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #222831;
        }

        html{
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            color: #ffffff;
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
            width: 200px;
            height: 180px;
            border-radius: 50%;
            background-color: #76ABAE;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 10px;
        }

        .progress-text {
            font-size: 18px;
            color: #EEEEEE;
            text-align: center;
        }

        .admin-text {
            position: absolute;
            top: 10px;
            right: 100px;
            color: #EEEEEE;
            font-weight: bold;
        }

        .login-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #76ABAE;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
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

        #imageCarousel .carousel-item img {
            width: 800px;
            height: 400px; /* Ganti dengan tinggi yang Anda inginkan */
            object-fit: fill; /* Menjaga rasio aspek gambar dan memastikan gambar menutupi kontainer */
        }

        .info-box {
            position: absolute;
            top: 10px; /* Adjust this value as needed */
            right: 10px; /* Adjust this value as needed */
            background-color: white;
            border-radius: 8px; /* Adjust this value for more or less rounding */
            padding: 5px 10px; /* Adjust padding as needed */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
        }

        /* Custom colors for strong elements */
        .strong-1 {
            color: white;
            background-color: red;
        }

        .strong-2 {
            color: black;
            background-color: yellow;
        }

        .strong-3 {
            color: white;
            background-color: green;
        }

        .strong-4 {
            color: white;
            background-color: blue;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="card text-center">
        <div class="title">
            <h2>Air Quality Index</h2>
            <button><i class="info-box" data-toggle="modal" data-target="#infoModal">info</i></button>
            @if(isset($latestData))
                <div class="circle-container">
                    <div id="humidity-progress" class="progress-circle">
                        <div class="progress-text">Kelembapan: <br><span id="humidity-value">{{ $latestData->humidity ?? 'N/A' }}</span> %</div>
                    </div>
                    <div id="temperature-progress" class="progress-circle">
                        <div class="progress-text">Suhu Ruangan: <br><span id="temperature-value">{{ $latestData->temperatureC ?? 'N/A' }}</span> °C</div>
                    </div>
                    <div id="atmos-progress" class="progress-circle">
                        <div class="progress-text">Karbon Monoksida: <br><span id="atmos-value">{{ $latestData->H2 ?? 'N/A' }}</span> ppm</div>
                    </div>
                    <div id="aqi-progress" class="progress-circle">
                        <div class="progress-text">
                            @if($latestData->CH4 == 0)
                                Tidak ada gas beracun di sini
                            @else
                                Awas terdeteksi gas beracun di sini
                            @endif
                        </div>
                    </div>
                </div>

                @php
                    $saranData = null;
                    if ($latestData->CH4 === 0) {
                        $saranData = App\Models\Saran::where('tipe', 'sehat')->first();
                    } else {
                        $saranData = App\Models\Saran::where('tipe', 'danger')->first();
                    }
                @endphp

                @if($saranData)
                    <div class="saran">
                        <!-- Carousel for Sarans -->
                        <div id="saranCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($images as $saranData)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <div class="alert alert-{{ $saranData->tipe }}">
                                            <strong>Saran:</strong> {{ $saranData->saran }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- Carousel for Images -->
                        <div id="imageCarousel" class="carousel slide mt-4" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($images as $image)
                                    <div class="carousel-item @if($loop->first) active @endif">
                                        <img src="{{ asset('storage/images/' . $image->gambar) }}" alt="Image">
                                    </div>
                                @endforeach
                            </div>
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

    <div class="admin-text">Apakah Anda Admin?</div>
    <a href="{{ route('loginPage') }}" class="login-btn">Login</a>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('storage/images/tes.jpg') }}" alt="Info Image" class="img-fluid mb-3 rounded">
                    <p><strong class="strong-1 rounded">1.</strong> Kelembapan diukur dengan <strong>DHT 11</strong></p>
                    <p><strong class="strong-2 rounded">2.</strong> Suhu diukur dengan sensor <strong>DHT 11</strong></p>
                    <p><strong class="strong-3 rounded">3.</strong> Karbon Monoksida diukur dengan sensor <strong>MQ-8</strong></p>
                    <p><strong class="strong-4 rounded">4.</strong> CH4 atau gas beracun diukur dengan sensor <strong>MQ-9</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KV2H9TE1B8d60Z2ZTg8kVwl5OuPI2FdjC5f1o5g5TILVX4m2D7M5BlSXDh/WtDq6" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        setTimeout(function(){
            location.reload();
        }, 60000); // 60000 milliseconds = 1 minute
    </script>
    <script>
        particlesJS("particles-js", {"particles":{"number":{"value":118,"density":{"enable":true,"value_area":800}},"color":{"value":"#ffffff"},"shape":{"type":"circle","stroke":{"width":0,"color":"#000000"},"polygon":{"nb_sides":6},"image":{"src":"img/github.svg","width":100,"height":100}},"opacity":{"value":0.8417913319543995,"random":false,"anim":{"enable":false,"speed":1,"opacity_min":0.1,"sync":false}},"size":{"value":12.02559045649142,"random":true,"anim":{"enable":false,"speed":40,"size_min":0.1,"sync":false}},"line_linked":{"enable":true,"distance":150,"color":"#ffffff","opacity":0.4,"width":1},"move":{"enable":true,"speed":6,"direction":"none","random":false,"straight":false,"out_mode":"out","bounce":false,"attract":{"enable":false,"rotateX":600,"rotateY":1200}}},"interactivity":{"detect_on":"canvas","events":{"onhover":{"enable":true,"mode":"repulse"},"onclick":{"enable":true,"mode":"push"},"resize":true},"modes":{"grab":{"distance":400,"line_linked":{"opacity":1}},"bubble":{"distance":400,"size":40,"duration":2,"opacity":8,"speed":3},"repulse":{"distance":200,"duration":0.4},"push":{"particles_nb":4},"remove":{"particles_nb":2}}},"retina_detect":true});var count_particles, stats, update; stats = new Stats; stats.setMode(0); stats.domElement.style.position = 'absolute'; stats.domElement.style.left = '0px'; stats.domElement.style.top = '0px'; document.body.appendChild(stats.domElement); count_particles = document.querySelector('.js-count-particles'); update = function() { stats.begin(); stats.end(); if (window.pJSDom[0].pJS.particles && window.pJSDom[0].pJS.particles.array) { count_particles.innerText = window.pJSDom[0].pJS.particles.array.length; } requestAnimationFrame(update); }; requestAnimationFrame(update);;
    </script>
</body>
</html>
