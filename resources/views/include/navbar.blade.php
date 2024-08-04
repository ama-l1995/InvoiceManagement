<nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
    <a class="navbar-brand" href="{{ route('home') }}">InvoiceManagement</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            @if(Auth::guard('superAdmin')->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                </li>
            @elseif(Auth::guard('web')->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('invoices.all') }}">Invoices</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('clients.all') }}">Clients</a>
                </li>
            @elseif(Auth::guard('client')->check())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('client.invoices.index') }}">Clients</a>
                </li>
            @endif
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                    </form>
                </li>
        </ul>
    </div>
</nav>
