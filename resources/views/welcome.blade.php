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
            height: 180px;
            width: 200px;
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
            @if(isset($latestData))
                <div class="circle-container">
                    <div id="humidity-progress" class="progress-circle">
                        <div class="progress-text">Humidity: <span id="humidity-value">{{ $latestData->humidity ?? 'N/A' }}</span> %</div>
                    </div>
                    <div id="temperature-progress" class="progress-circle">
                        <div class="progress-text">Temperature: <span id="temperature-value">{{ $latestData->temperatureC ?? 'N/A' }}</span> °C</div>
                    </div>
                    <div id="aqi-progress" class="progress-circle">
                        <div class="progress-text">Kadar H2: <span id="aqi-value">{{ $latestData->H2 ?? 'N/A' }}</span></div>
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
            @endif
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
            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="admin-text">Apakah Anda Admin?</div>
    <a href="{{ route('loginPage') }}" class="login-btn">Login</a>

    <script>
        setTimeout(function(){
            location.reload();
        }, 60000); // 60000 milliseconds = 1 minute
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-KV2H9TE1B8d60Z2ZTg8kVwl5OuPI2FdjC5f1o5g5TILVX4m2D7M5BlSXDh/WtDq6" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
