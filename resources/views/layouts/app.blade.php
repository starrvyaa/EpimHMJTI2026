<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EPIM 2026</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-black text-white">

<nav class="flex justify-between p-6">
    <h1 class="text-xl font-bold text-orange-500">EPIM 2026</h1>
    <div class="space-x-6">
        <a href="/">Beranda</a>
        <a href="#">Lomba</a>
        <a href="#">Timeline</a>
        <a href="#">Login</a>
    </div>
</nav>

@yield('content')

</body>
</html>
