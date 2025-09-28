<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            background: #d9e7f3;
        }

        header {
            background: #2d3e50;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 30px;
        }
        header .logo {
            font-size: 32px;
            font-weight: bold;
            font-family: "Georgia", cursive;
        }
        header .nav {
            display: flex;
            gap: 20px;
        }
        header .nav a {
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
    </style>
    @section('style')
    @show
</head>
<body>
    <header>
        <div class="username-box">@yield('username')</div>
        <div class="logo">@yield('club_name')</div>
        <div class="nav">
            <a href="/clubs">Club</a>
            <a href="/logout">Logout</a>
        </div>
    </header>
    @section('body')
    @show
</body>
</html>