<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS Laravel')</title>
    <link href="{{ asset('build/assets/app-Bl5lLFHa.css') }}" rel="stylesheet">
    <script src="{{ asset('build/assets/app-B22hxfBP.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('scripts')
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

        .input-group .input-group-text,
        .input-group select.form-select,
        .input-group input.form-control {
            border-radius: 0 !important;
            height: 2.2rem;
        }

        .input-group select.form-select,
        .input-group select.form-select option {
            padding: 0.3rem 0.75rem !important;
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



    <div class="row">
        <aside style="width: 250px; height: 100vh; background-color: #0080ffff;">

        </aside>
        <main class="col col-auto" style="width: calc(100vw - 250px);">
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
        </main>
    </div>


</body>

</html>