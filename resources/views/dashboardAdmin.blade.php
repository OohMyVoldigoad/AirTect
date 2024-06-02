<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Saran</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #2e3a4a;
            background-size: cover;
            background-position: 50% 50%;
            z-index: -1;
        }

        .container {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%;
            max-width: 500px;
        }

        .card h2 {
            margin-bottom: 20px;
        }

        .card .form-control,
        .card .form-select {
            margin-bottom: 15px;
        }

        .card .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #000;
            width: 457px;
            margin-bottom: 10px
        }

        .card .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .btn-danger {
            width: 200px;
        }
    </style>
</head>

<body>
    <div id="particles-js"></div>

    <div class="container">
        <div class="card">
            <h2>Create Saran</h2>
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form action="{{ route('sarans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="saran" class="form-label">Saran:</label>
                    <textarea name="saran" id="saran" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar:</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe:</label>
                    <select name="tipe" id="tipe" class="form-select" required>
                        <option value="sehat">Sehat</option>
                        <option value="hati-hati">Hati-hati</option>
                        <option value="danger">Danger</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <!-- Particles.js library -->
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
            }
        });
    </script>
    <!-- Bootstrap Bundle JS (including Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
