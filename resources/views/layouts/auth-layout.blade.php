@props(['title' => 'App'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <meta name="theme-color" content="#001535" />
    <link rel="apple-touch-icon" href="{{ asset('chicken.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    <title>{{$title ?? 'App'}}</title>
    <link rel="shortcut icon" href="{{asset('assets/icon/csit.png')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="bg-light">
    <header class="bg-white py-2 shadow-lg">
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    {{-- btn install app --}}
                    <button id="installPwaBtn" class="nav-link d-flex align-items-center gap-2 text-primary fw-bold"
                        style="display: none;">
                        <i class="bi bi-cloud-download"></i>
                        <span>Install App</span>
                    </button>
                </li>

                {{-- home --}}
                <li class="nav-item">
                    <a href="/home" class="nav-link d-flex align-items-center gap-2 text-primary fw-bold"
                        style="display: none;">
                        <i class="bi bi-house-door"></i>
                        <span>Home</span>
                    </a>
                </li>
                {{-- logs --}}
                <li class="nav-item">
                    <a href="/logs" class="nav-link d-flex align-items-center gap-2 text-primary fw-bold"
                        style="display: none;">
                        <i class="bi bi-journal-text"></i>
                        <span>Logs</span>
                    </a>
                </li>

                {{-- logout  --}}
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">
                        <i class="bi bi-box-arrow-left fw-bold text-primary" style="font-style: normal;"> Log Out</i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    {{$slot}}

    <script src="{{ asset('/sw.js') }}"></script>
    <script src="{{ asset('/helper.js') }}"></script>

    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").
            then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>

</html>