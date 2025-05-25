<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOL Blog</title>
    <meta name="author" content="MOL Shipping Co.">
    <meta name="description" content="Secure login to MOL Shipping Blog.">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap');
        body {
            font-family: 'Karla', sans-serif;
        }
    </style>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"
        integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-teal-100 via-blue-100 to-cyan-100 min-h-screen flex items-center justify-center">
    {{ $slot }}
</body>

</html>
