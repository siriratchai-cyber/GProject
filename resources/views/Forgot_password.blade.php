<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            background: #cfe0ed;
        }

        .left {
            background: #2f4156;
            width: 35%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            clip-path: polygon(90% 0, 90% 43%, 75% 50%, 90% 57%, 90% 100%, 0 100%, 0 70%, 0 0); 
        }

        .left button {
            margin: 15px 0;
            padding: 25px 60px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        .forgot-btn {
            background: #fff;
            color: #2f4156;
        }

        .right {
            width: 65%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #cfe0ed;
        }

        .form-box {
            position: relative;
            background: #f9f6f2;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            width: 1000px;
            text-align: center;
        }

        .form-box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-box input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-box button{
            margin-top: 15px;
            width: 50%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #7dbf67;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }

        .form-box button:hover {
            background: #6aac59;
        }

        /* ปุ่มย้อนกลับ */
        .form-box a {
            position: absolute;
            top: 15px;
            left: 15px;
            background: none;
            font-size: 16px;
            cursor: pointer;
            color: #2f4156;
            text-decoration: none;
            color: inherit;
            font-weight: bold;
        }
    </style>
</head>
<body>    
    <div class="left">
        <button class="forgot-btn">Forgot Password</button>
    </div>

    <div class="right">
        <div class="form-box">
            <!-- ปุ่มย้อนกลับ -->
            <a href="{{ route('login') }}">&#8592; login</a>

            <h2>Forgot password</h2>

            <form action="{{ route('forgotpassword.reset') }}" method="POST">
                @csrf
                <div>
                    <input type="email" name="email" placeholder="อีเมล" required>
                </div>
                <div>
                    <input type="password" name="new_password" placeholder="รหัสผ่านใหม่" required>
                </div>
                <div>
                    <input type="password" name="new_password_confirmation" placeholder="ยืนยันรหัสผ่านใหม่" required>
                </div>
                <button type="submit" calss="submit">Submit</button>
            </form>

            @if(session('error'))
                <p style="color:red;">{{ session('error') }}</p>
            @endif

            @if(session('success'))
                <p style="color:green;">{{ session('success') }}</p>
            @endif
        </div>
    </div>
</body>
</html>
