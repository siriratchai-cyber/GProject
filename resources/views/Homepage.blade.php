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
            .welcome {
                text-align: center;
                margin: 20px 0;
            }
            .welcome span {
                background: #f5f5f5ff;
                padding: 10px 30px;
                border-radius: 20px;
                font-weight: bold;
            }
            .active-club{
                background: #f5f5f5ff;
                padding: 10px 30px;
                margin: 40px 50px 10px;
                border-radius: 20px; 
            }
            .activity-club{
                background: #f5f5f5ff;
                padding: 10px 30px;
                margin: 10px 50px 10px 50px;
                border-radius: 20px; 
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
            <div class="welcome"><span>Welcome naja</span></div>
            <div class="active-club">
                <h3>ชมรมที่อยู่ : </h3>
                @foreach($club as $c)
                    @if($c->student_id == $user->std_id)
                        <p>
                            <img src="{{ $c->club->image ? asset('storage/'.$c->club->image) : asset('default.jpg') }}" alt="club">
                            {{$c->club->name}}
                        </p>
                    @endif
                @endforeach
            </div>
            <div class="activity-club">
                <h3>กิจกรรมที่กำลังจะมาถึง : </h3>

            </div>
        </main>
    </body>
</html>