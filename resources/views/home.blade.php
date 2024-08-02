<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InvoiceManagement</title>
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
                @auth
                    @if(Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoices.index') }}">Invoices</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clients.index') }}">Clients</a>
                        </li>
                    @elseif(Auth::user()->role === 'user')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('invoices.index') }}">Invoices</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome to Our Company</h1>
        <p>Your journey starts here. We are excited to have you!</p>
        <img src="{{ asset('images/images.jpg') }}" alt="Project Image">
    </div>
</body>
</html>
