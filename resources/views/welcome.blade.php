<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            background-color: #222831;
        }

        .card {
            max-width: 50rem;
            background-color: #31363F;
        }

        .title {
            color: #EEEEEE;
        }

        /* CSS untuk progress circle */
        .progress-circle {
            position: relative;
            width: 120px; /* Sesuaikan ukuran circle progress bar */
            height: 120px; /* Sesuaikan ukuran circle progress bar */
            border-radius: 50%; /* Membuat circle progress bar */
            background-color: #76ABAE; /* Warna latar belakang circle */
            overflow: hidden;
        }

        /* Container untuk circle yang akan diatur sejajar kiri-kanan */
        .circle-container {
            display: flex;
            justify-content: space-between; /* Membuat circle sejajar kiri-kanan */
            width: 100%;
        }

        .progress-circle .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            font-size: 14px;
            color: #EEEEEE;
        }

        .progress-circle .progress-text span {
            font-weight: bold;
        }

        .progress-circle .progress-circle-fill {
            stroke: #3498db; /* Warna stroke untuk progress circle */
            stroke-width: 8px; /* Lebar stroke */
            fill: transparent;
            transition: stroke-dasharray 0.5s ease;
        }

        /* CSS untuk tulisan "Apakah Anda Admin?" */
        .admin-text {
            position: absolute;
            top: 10px;
            right: 100px;
            color: #EEEEEE;
            font-weight: bold;
        }

        /* CSS untuk tombol login */
        .login-btn {
            position: absolute;
            top: 10px;
            right: 10px; /* Sesuaikan jarak dari kanan */
            background-color: #76ABAE;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

    <div class="card text-center">
        <div class="card-body">
            <input type="hidden" id="tokenInput" value="32c5640caacbd1f1945d22860184aaf0db4a380e">
            <input type="hidden" id="keywordInput" value="batam">
            <div class="title" id="outputContainer"></div>
            <div class="circle-container">
                <div id="humidity-progress" class="progress-circle">
                    <div class="progress-text">Humidity: <span id="humidity-value">0</span> %</div>
                </div>
                <div id="temperature-progress" class="progress-circle">
                    <div class="progress-text">Temperature: <span id="temperature-value">0</span> °C</div>
                </div>
                <div id="atmos-progress" class="progress-circle">
                    <div class="progress-text">Carbon Monoxide: <span id="atmos-value">0</span> ppm</div>
                </div>
                <div id="aqi-progress" class="progress-circle">
                    <div class="progress-text">AQI: <span id="aqi-value">0</span></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tulisan "Apakah Anda Admin?" dan tombol login -->
    <div class="admin-text">Apakah Anda Admin?</div>
    <a href="{{ route('loginPage') }}" class="login-btn">Login</a>

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

    <!-- Tambahkan script untuk inisialisasi dan fungsi JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            init("#tokenInput", "#keywordInput", "#outputContainer");
        });

        function init(tokenId, inputId, outputId) {
            var token = document.querySelector(tokenId);

            var input = document.querySelector(inputId);
            var timer = null;
            var output = document.querySelector(outputId);

            search(input.value, output, token.value);
        }

        function search(keyword, output, token) {
            output.innerHTML = "<h2>Search results:</h2><div>Loading...</div>";

            let url = "https://api.waqi.info/v2/search/?token=" + token + "&keyword=" + keyword;
            fetch(url)
                .then((response) => response.json())
                .then((result) => {
                    output.innerHTML = "<h2>Search results:</h2>";
                    if (!result || result.status != "ok") {
                        throw result.data;
                    }

                    if (result.data.length == 0) {
                        output.innerHTML += "<div>Sorry, there is no result for your query!</div>";
                        return;
                    }

                    var table = document.createElement("table");
                    table.classList.add("result");
                    output.appendChild(table);

                    output.innerHTML += "<div>Click on any of the station to see the detailed AQI</div>";

                    var stationInfo = document.createElement("div");
                    output.appendChild(stationInfo);

                    result.data.forEach(function (station, i) {
                        var tr = document.createElement("tr");
                        tr.innerHTML = "<td>" + station.station.name + "</td><td>" + colorize(station.aqi) + "</td><td>" + station.time.stime + "</td>";
                        tr.addEventListener("click", function () {
                            showStation(station, stationInfo);
                        });
                        table.appendChild(tr);
                        if (i == 0) showStation(station, stationInfo);
                    });
                })
                .catch((e) => {
                    output.innerHTML = "<div class='ui negative message'>" + e + "</div>";
                });
        }

        function showStation(station, output) {
            output.innerHTML = "<h2>Pollutants & temperature conditions:</h2><div class='circle-progress'><div class='progress-inner'></div><div class='aqi-text'></div></div>";

            let url = "https://api.waqi.info/feed/@" + station.uid + "/?token=" + token();
            fetch(url)
                .then((response) => response.json())
                .then((result) => {
                    if (!result || result.status != "ok") {
                        output.innerHTML += "<div>Sorry, something wrong happened: " + (result.data ? "<code>" + result.data + "</code>" : "") + "</div>";
                        return;
                    }

                    output.innerHTML += "<div>Station: " + result.data.city.name + " on " + result.data.time.s + "</div>";

                    // Calculate progress based on data (example: AQI value)
                    var aqi = result.data.aqi;
                    // var progress = aqi / 500 * 100; // Assuming maximum AQI is 500

                    // var progressInner = output.querySelector('.progress-inner');
                    // progressInner.style.clip = 'rect(0px, 100px, 100px, ' + progress + 'px)';

                    // // Display AQI value inside the circle
                    // var aqiText = output.querySelector('.aqi-text');
                    // aqiText.textContent = "AQI: " + aqi;

                    // Ambil data kelembaban (humidity) dan cuaca (temperature) dari respons API
                    var humidity = result.data.iaqi.h.v;
                    var temperature = result.data.iaqi.t.v;
                    var atmosphericPressure = result.data.iaqi.p.v;

                    // Update nilai kelembaban dan cuaca dalam circle progress bar
                    document.getElementById('humidity-value').textContent = humidity + "%";
                    document.getElementById('temperature-value').textContent = temperature;
                    document.getElementById('aqi-value').textContent = aqi;
                    document.getElementById('atmos-value').textContent = atmosphericPressure;

                    // Update progress circle untuk kelembaban dan cuaca
                    updateProgressCircle('humidity-progress', humidity);
                    updateProgressCircle('temperature-progress', temperature);
                    updateProgressCircle('aqi-progress', aqi);
                    updateProgressCircle('atmos-progress', atmosphericPressure);
                })
                .catch((e) => {
                    output.innerHTML = "<h2>Sorry, something wrong happened</h2>" + e;
                });
        }

        function updateProgressCircle(id, value) {
            var circle = document.getElementById(id); // Mengambil elemen dengan ID yang diberikan
            var circleValue = circle.querySelector('.progress-text span'); // Mengambil elemen di dalam circle dengan kelas progress-text
            circleValue.textContent = value; // Mengatur teks nilai

            var circumference = 2 * Math.PI * 50; // radius 50, bisa disesuaikan
            var progress = circumference - (value / 100) * circumference;

            // Periksa apakah elemen dengan kelas .progress-circle-fill ada di dalam circle
            var progressCircleFill = circle.querySelector('.progress-circle-fill');
            if (progressCircleFill) {
                progressCircleFill.style.strokeDasharray = `${progress} ${circumference}`; // Atur stroke dasharray untuk membuat lingkaran progres
            } else {
                console.error("Element with class 'progress-circle-fill' not found in circle with ID:", id);
            }
        }

        function token() {
            var tokenInput = document.querySelector("#tokenInput");
            return tokenInput.value || "demo";
        }

        function colorize(aqi, specie) {
            specie = specie || "aqi";
            if (["pm25", "pm10", "no2", "so2", "co", "o3", "aqi"].indexOf(specie) < 0)
                return aqi;

            var spectrum = [
                { a: 0, b: "#cccccc", f: "#ffffff" },
                { a: 50, b: "#009966", f: "#ffffff" },
                { a: 100, b: "#ffde33", f: "#000000" },
                { a: 150, b: "#ff9933", f: "#000000" },
                { a: 200, b: "#cc0033", f: "#ffffff" },
                { a: 300, b: "#660099", f: "#ffffff" },
                { a: 500, b: "#7e0023", f: "#ffffff" },
            ];

            var i = 0;
            for (i = 0; i < spectrum.length - 2; i++) {
                if (aqi == "-" || aqi <= spectrum[i].a) break;
            }
            return "<div style='font-size: 120%; min-width: 30px; text-align: center; background-color: " + spectrum[i].b + "; color: " + spectrum[i].f + "'>" + aqi + "</div>";
        }
    </script>
</body>
</html>
