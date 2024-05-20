<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet"/>
    <title>Fetch AQI</title>
</head>
<body class="d-flex justify-content-center align-items-center vh-100" style="background-color: #f8f9fa;">
    <div class="col-6 col-md-4 form-container">
        <form action="{{ route('fetchAqi') }}" method="post">
            @csrf
            <div class="form-outline mb-4">
                <input type="text" id="tokenInput" name="token" class="form-control" required/>
                <label class="form-label" for="tokenInput">Token</label>
            </div>
            <div class="form-outline mb-4">
                <input type="text" id="keywordInput" name="keyword" class="form-control" required/>
                <label class="form-label" for="keywordInput">Keyword</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block mb-4">Fetch AQI</button>
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.js"></script>
</body>
</html>
