<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" content="width=device-width, initial-scale=1">
  <title>หน้าสมัคร</title>
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
      clip-path: polygon(90% 0, 90% 32%, 75% 42%, 90% 52%, 90% 100%, 0 100%, 0 70%, 0 0);
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

    .register-btn {
      background: #fff;
      color: #2f4156;
    }

    .login-btn {
      width: 200px;
      background: #f5f5f5;
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

    .form-box button {
      margin-top: 15px;
      width: 100%;
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
    .Select-Box{
      display: inline-block;
      width: 30%;
      padding: 10px;
      margin: 10px 50px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="left">
    <button class="register-btn">REGISTER</button>
    <button class="login-btn"><a href="/login">LOGIN</a></button>
  </div>

  <div class="right">
    <div class="form-box">
      <h2>REGISTER</h2>
      <form action="/register" method="POST">
        @csrf
        <input name="std_name" type="text" placeholder="ชื่อ - สกุล" required>
        <input name="std_id" type="text" placeholder="รหัสนักศึกษา" required>
        <input name="email" type="email" placeholder="อีเมล" required>
        <input name="password" type="password" placeholder="รหัสผ่าน" required>
        <input type="password" placeholder="ยืนยันรหัสผ่าน" required>
        <select class="Select-Box" name="major" required>
          <option name="major" selected>--- Select Major ---</option>
          <option value="CS">CS</option>
          <option value="IT">IT</option>
          <option value="CY">CY</option>
          <option value="AI">AI</option>
          <option value="GIS">GIS</option>
        </select>
        <select name="year" class="Select-Box" required>
          @for($i = 1; $i <= 8; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
          @endfor
        </select>
        <button type="submit">Sign up</button>
      </form>
    </div>
    @if (session('success'))
      <script>
        alert("{{ session('success') }}");
      </script>
    @endif

    @if (session('error'))
      <script>
        alert("{{ session('error') }}");
      </script>
    @endif
  </div>
</body>
</html>
