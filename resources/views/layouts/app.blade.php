<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'CP Club')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#d9e7f3; font-family:"Sarabun",sans-serif; margin:0; }
    header { background:#2d3e50; color:white; display:flex; justify-content:space-between;
             align-items:center; padding:10px 30px; position:relative; }
    header .logo { position:absolute; left:50%; transform:translateX(-50%); font-size:1.8rem; font-weight:bold; }
    header .username-box { background:#1a3552; padding:6px 14px; border-radius:8px; }
    header .nav a { color:white; text-decoration:none; font-weight:bold; margin-left:20px; }
  </style>
  @yield('style')
</head>
<body>
  <header>
    <div class="username-box">@yield('username')</div>
    <div class="logo">@yield('club_name', 'CP Club')</div>
    <div class="nav">@yield('nav')</div>
  </header>

  <main class="py-4">@yield('body')</main>
</body>
</html>
