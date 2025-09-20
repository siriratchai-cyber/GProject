<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home Page</title>
        <style>
            body {
                font-family: "Arial", sans-serif;
                margin: 0;
                background: #d9e7f3;
            }
            main {
                display: flex;
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
            .Box-welcome{
                font-size: 20px;
                background: #ffffff;
                color: #000000;
                border-radius: 5px;
                padding: 5px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header>
            <div class="username-box">username</div>
            <div class="logo">CP club</div>
            <div class="nav">
                <a href="#">Dashboard</a>
                <a href="/login">Logout</a>
            </div>
        </header>
        <main>
            <div class="Box-welcome">Wellcome</div>
        </main>
    </body>
</html>