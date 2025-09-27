<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>CP Club</title>
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
    .create-btn {
      display: flex;
      justify-content: flex-end;
      padding: 0 30px;
    }
    .create-btn a {
      background: white;
      border: 1px solid #bbb;
      border-radius: 20px;
      padding: 8px 15px;
      cursor: pointer;
      font-size: 14px;
      text-decoration: none;
      color: #000;
    }
    .club-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      padding: 30px;
      justify-items: center;
    }
    .club-card {
      background: #F5EFEB;
      border-radius: 8px;
      width: 280px;
      text-align: center;
      padding: 15px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .club-card img {
       width: 100%;
    height: 250px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .club-card h3 {
      margin: 15px 0 10px;
    }
    .club-card p {
      font-size: 14px;
      color: #333;
      text-align: left;
      border: 1px solid #aaa;
      padding: 10px;
      min-height: 100px;
    }
    .club-card .member {
      margin-top: 10px;
      font-size: 13px;
      color: #333;
    }
    .club-card button {
      margin-top: 15px;
      background: #333;
      color: white;
      padding: 8px 25px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      font-size: 14px;
      transition: 0.3s;
    }
    .club-card button.cancel {
      background: red;
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

  <div class="welcome">
    <span>Welcome naja</span>
  </div>

  <div class="create-btn">
    <a href="{{ route('clubs.create') }}">+ สร้างชมรม</a>
  </div>

  <div class="club-container">
    @foreach($clubs as $club)
      <div class="club-card">
        <h3>{{ $club->name }}</h3>
        <img src="{{ $club->image ? asset('storage/'.$club->image) : asset('default.jpg') }}" alt="club">
        <p>{{ $club->description }}</p>
        <div class="member">
          สมาชิกในชมรม : {{ $club->members->count() }}
        </div>
        <button class="join-btn" data-id="{{ $club->id }}">สมัคร</button>
      </div>
    @endforeach
  </div>

  <script>
  document.addEventListener("click", function(e) {
    if(e.target.classList.contains("join-btn")){
      let btn = e.target;
      if(btn.innerText === "สมัคร"){
        btn.innerText = "ยกเลิก";
        btn.classList.add("cancel");
        // TODO: ส่ง AJAX ไปบันทึกการสมัคร
      } else {
        btn.innerText = "สมัคร";
        btn.classList.remove("cancel");
        // TODO: ส่ง AJAX ไปยกเลิกการสมัคร
      }
    }
  });
  </script>

</body>
</html>
