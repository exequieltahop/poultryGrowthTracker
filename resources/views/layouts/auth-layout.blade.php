@props(['title' => 'App'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{$title}}</title>
    <link rel="shortcut icon" href="{{asset('assets/icon/csit.png')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body class="bg-light">
    <header class="bg-white py-2 shadow-lg">
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">
                        <i class="bi bi-box-arrow-left fw-bold text-primary" style="font-style: normal;"> Log Out</i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    {{$slot}}
</body>
</html>