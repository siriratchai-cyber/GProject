<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CP Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background-color: #d9e7f3;
            font-family: "Arial", sans-serif;
        }

        header {
            background: #2d3e50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            font-family: "Georgia", cursive;
        }

        .nav {
            display: flex;
            gap: 20px;
        }

        .nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .username-box {
            background: #1a3552;
            padding: 5px 15px;
            color: white;
            border-radius: 5px;
            margin-right: 15px;
            display: inline-block;
        }

        main {
            padding: 20px;
        }

        @yield('style')
    </style>
</head>

<body>
<header>
    <div class="username-box">@yield('username')</div>
    <div class="logo">@yield('club_name', 'CP Club')</div>
    <div class="nav">
        <a href="{{ route('clubs.index') }}">Club</a>
        <a href="{{ route('logout') }}">Logout</a>
    </div>
</header>

<main>
    @yield('body')
</main>
</body>
</html>
