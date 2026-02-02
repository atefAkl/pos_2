<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'نقطة البيع')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        * {
            padding: auto;
            margin: 0;
            box-sizing: border-box;
            font-family: normal 1rem/1.3 'Cairo', sans-serif;
            color: inherit;
        }

        ul li,
        ol li {
            list-style: none;
        }

        .page-heading .page-heading-title {
            font: Bolder 1.3rem /1.3 'Cairo', sans-serif;
            color: #555;
            padding: 0 1rem;
        }

        .card {
            box-shadow: 0 0px 8px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;

            &:hover {
                transform: translateY(-3px);
            }
        }

        .page-heading .page-heading-actions button {
            background-color: transparent;
            border: none;
            font-size: 18px;
            padding: 5px 10px;
            transition: all 0.3s ease;

            &:hover {
                background-color: #a0a2a3;
                color: #fff;
            }
        }

        a,
        a:hover,
        a:focus,
        a:active,
        a:visited {
            text-decoration: none;
        }

        .container {
            width: 80%;
        }

        a.quick-action-btn {
            width: 50px;
            height: 50px;
            background-color: #ccc;
            text-align: center;
            color: #555;
            font-size: 24px;
            display: inline-block;
            line-height: 50px;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body>
    @if (!isset($hideSidebar) || !$hideSidebar)
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark no-print">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">نقطة البيع</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('pos') }}">نقطة البيع</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('orders.index') }}">الطلبات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('meals.index') }}">الوجبات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('reports.daily') }}">التقارير</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('auth.user.profile') }}" class="dropdown-item">Profile</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <div class="container-fluid mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</body>

</html>
