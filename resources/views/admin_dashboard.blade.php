<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - CP club</title>
  <style>
    body { font-family: "Arial", sans-serif; margin: 0; background:#d9e7f3; }
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

    /* ปุ่มคำร้องขอเหมือนปุ่มสร้างชมรม */
    .create-btn {
      display: flex;
      justify-content: flex-end;
      padding: 20px 30px 0 30px;
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

    .clubs { margin:30px; background:#f9f6f2; padding:20px; border-radius:20px; }
    .club-list { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; }
    .club-card { background:white; padding:15px; border-radius:15px; display:flex; justify-content:space-between; align-items:center; }
    .btn { padding:6px 12px; border:none; border-radius:12px; cursor:pointer; font-size:14px; }
    .edit { background:#f7e58d; }
    .delete { background:#f69191; }

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
  </style>
</head>
<body>

<header>
  <div class="username-box">{{ $user->std_id }}</div>
  <div class="logo">CP club</div>
  <div class="nav">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

 <div class="welcome">
    <span>Welcome {{ $user->std_name }}</span>
  </div>

<div class="create-btn">
  <a href="{{ route('admin.requests') }}">คำร้องขอ</a>
</div>

<div class="clubs">
  <h3>ชมรมทั้งหมด</h3>
  <div class="club-list">
    @forelse($clubs as $club)
      <div class="club-card">
        <span>{{ $club->name }}</span>
        <div>

         <a href="{{ route('admin.clubs.edit', $club->id) }}" class="btn edit">EDIT</a>

            @csrf
            <button class="btn delete" type="submit">DELETE</button>
          </form>
        </div>
      </div>
    @empty
      <p>- ไม่มีชมรม -</p>
    @endforelse
  </div>
</div>

</body>
</html>
