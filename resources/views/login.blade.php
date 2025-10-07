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
      clip-path: polygon(90% 0, 90% 47%, 75% 57%, 90% 67%, 90% 100%, 0 100%, 0 70%, 0 0); 
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
  </style>
</head>
<body>
  <div class="left">
    <button class="register-btn" ><a href="/register">REGISTER</a></button>
    <button class="login-btn" >LOGIN</button>
  </div>

  <div class="right">
    <div class="form-box">
      <h2>LOG IN</h2>
      <form action="/login" method="POST">
        @csrf
        <input name="std_id" type="text" placeholder="รหัสนักศึกษา" required>
        <input name="password" type="password" placeholder="รหัสผ่าน" required>
        <button type="submit">LOG IN</button>
      </form>
    </div>
  </div>
</body>
</html>
