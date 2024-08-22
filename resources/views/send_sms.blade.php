<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sms de confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f8ff;
        }
        .card {
            background-color: rgba(0, 139, 139, 0.58); /* Dark cyan with 35% transparency */
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #008b8b /* Dark cyan with 35% transparency */
        }
        .form-label, .btn {
            color: white;
        }
        .btn-primary {
            background-color: #008b8b; /* Dark cyan */
            border-color: #008b8b; /* Dark cyan */
        }
        .btn-primary:hover {
            background-color: #006d6d; /* Slightly darker cyan */
            border-color: #006d6d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            @if(Session::has('success'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{Session::get('success')}}
                </div>
            </div>
            @endif
            @if(Session::has('fail'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {{Session::get('fail')}}
                </div>
            </div>
            @endif
            <div class="card-header">Sms de confirmation</div>
            <div class="card-body">
                <form action="{{ route('sendSMS') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Numero de telephone du destinataire</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="saisissez le numero de telephone du destinataire exemple:2236682****" name="number">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Votre Message</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
