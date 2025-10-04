<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลักแอดมิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #cfe2f3;
            font-family: "Sarabun", sans-serif;
        }

        header {
            background: #2d3e50;
            color: white;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        header .club {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.8rem;
            font-weight: bold;
        }

        header .right {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-left: auto;
        }

        header .logout {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }


        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }


        .welcome-box {
            background-color: #e6f0fa;
            padding: 15px 30px;
            border-radius: 20px;
            width: fit-content;
            margin: 30px auto;
            font-weight: 500;
            text-align: center;
        }

        .club-container {
            background-color: #fbf8f5;
            margin: 0 auto 50px auto;
            padding: 30px 50px;
            width: 90%;
            border-radius: 20px;
            border: 1px solid #aaa;
        }

        .club-container h3 {
            font-weight: bold;
            margin-bottom: 25px;
        }

        .club-card {
            background-color: #f8f6f5;
            border: 1.5px solid #999;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 15px;
            width: 45%;
            box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.1);
        }

        .club-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .club-card h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn-edit {
            background-color: #fff8c6;
            border: 1px solid #ccc;
            border-radius: 50px;
            padding: 2px 10px;
            font-weight: bold;
            font-size: 15px;
        }

        .btn-delete {
            background-color: #f79b9b;
            border: none;
            border-radius: 50px;
            color: white;
            padding: 2px 10px;
            font-size: 15px;
            margin-left: 5px;
        }

        .request-btn {
            position: absolute;
            top: 100px;
            right: 100px;
            background-color: #fff;
            border: 1.5px solid #999;
            border-radius: 20px;
            padding: 10px 20px;
            font-weight: bold;

        }

        .request-btn a {
            color: black;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header class="masthead">
        <div class="club">CP club</div>
        <div class="welcome">Welcome</div>
        <a class="logout" href="{{ route('logout') }}">Logout</a>
    </header>


    <div class="welcome-box">
        Welcome admin 
    </div>

    <div class="request-btn">
        <a href="{{ route('admin.requests') }}">คำร้องขอ</a>
    </div>

    <div class="club-container">
        <h3>ชมรมทั้งหมด</h3>
        <div class="club-grid">
            @foreach($clubs as $club)
                <div class="club-card">
                    <h5>{{ $club->name }}</h5>
                    <a href="{{ route('admin.clubs.edit', $club->id) }}" class="btn btn-edit">EDIT</a>
                    <form action="{{ route('admin.clubs.destroy', $club->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"
                            onclick="return confirm('ลบชมรมนี้หรือไม่?')">DELETE</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>

</body>

</html>