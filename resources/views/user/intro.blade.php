<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>153 Kreatif</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/153.png') }}">
    <style>
        @verbatim
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 60%, #fff0e5 85%, #ff8c40 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .intro-logo {
            height: auto;
            width: clamp(150px, 30vw, 300px);
            object-fit: contain;
            opacity: 0;
            transform: scale(0.9);
            animation: fadeInScale 0.8s ease-out forwards, fadeOut 0.2s 1.1s ease-in forwards;
        }
        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
        @keyframes fadeOut {
            0% {
                opacity: 1;
                transform: scale(1);
            }
            100% {
                opacity: 0;
                transform: scale(0.95);
            }
        }
        @endverbatim
    </style>
</head>
<body>
    <img src="{{ asset('assets/img/153.png') }}" alt="153 Kreatif Logo" class="intro-logo">

    <script>
        (function () {
            var redirectUrl = "{{ route('home') }}";
            setTimeout(function () {
                window.location.href = redirectUrl;
            }, 1300); // 0.8s in + 0.3s hold + 0.2s out = 1.3s
        })();
    </script>
</body>
</html>
