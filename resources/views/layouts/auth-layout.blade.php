@props(['title' => 'App'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>{{$title}}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <header class="bg-white py-2 shadow-lg">
        <nav>
            <ul class="nav">
                <li class="nav-item">
                    <a href="{{route('logout')}}" class="nav-link">Log Out</a>
                </li>
            </ul>
        </nav>
    </header>
    {{$slot}}
</body>
</html>