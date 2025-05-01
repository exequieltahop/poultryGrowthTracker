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

    <title>{{$title}}</title>

    <link rel="shortcut icon" href="{{asset('assets/icon/csit.png')}}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
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