<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - InvoiceManagement</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
        }
        .container h1 {
            font-size: 2.5em;
            color: #343a40;
            margin-bottom: 15px;
        }
        .container p {
            font-size: 1.2em;
            color: #495057;
            margin-bottom: 25px;
        }
        .container img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }
        .nav-link {
            color: #495057 !important;
        }
        .nav-link:hover {
            color: #0056b3 !important;
        }
        .btn-link {
            color: #007bff;
        }
        .btn-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
        <a class="navbar-brand" href="{{ route('home') }}">InvoiceManagement</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('register') }}">Register</a> --}}
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="container">
            <h2>Login</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                {{-- <input type="hidden" name="guard" value="user">  --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
