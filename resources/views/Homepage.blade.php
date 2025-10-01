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
            .img-club{
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .club-box{
                padding-bottom: 20px;
                padding-left: 10%;
                position: absolute;
                color: black;
                font-size: 16px; 
                font-weight: bold;
                text-align: center;
                /*text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);  เงาเพื่อความชัดเจน */
            }
            .img-box{
                position: relative;
                width: 50px; 
                height: 50px; 
                border-radius: 50%; 
                overflow: hidden; 
                display: flex;
                justify-content: center;
                align-items: center;
                background: #f0f0f0; 
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
            <div class="active-club">
            <h3>ชมรมที่คุณอยู่</h3>
            <div style="display: flex; gap: 30px; margin-top: 10px;">
                @foreach($club as $c)
                    @if($c->student_id == $user->std_id)
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span class="img-box">
                                <img class="img-club" 
                                    src="{{ $c->club->image ? asset('storage/'.$c->club->image) : asset('default.jpg') }}" 
                                    alt="club">
                            </span>
                            <span class="club-box" style="position: static; font-weight: bold;">
                                {{ $c->club->name }}
                            </span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="activity-club">
            <h3>กิจกรรมที่กำลังมาถึง</h3>
            @foreach($activities as $a)
                <div style="display: flex; align-items: center; gap: 15px; margin: 15px 0; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
                    <span class="img-box">
                        <img class="img-club" 
                            src="{{ $a->club->image ? asset('storage/'.$a->club->image) : asset('default.jpg') }}" 
                            alt="club">
                    </span>
                    <div style="flex: 1;">
                        <strong>{{ $a->club->name }}</strong><br>
                        • วันที่ {{ \Carbon\Carbon::parse($a->date)->translatedFormat('d F Y') }} | 
                        เวลา {{ \Carbon\Carbon::parse($a->date)->format('H:i') }} น. | 
                        {{ $a->detail }}
                    </div>
                </div>
            @endforeach
            </div>
        </main>
    </body>
</html>