<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - CP Club</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
<<<<<<< Updated upstream
    body{font-family:'Arial',sans-serif;background:#d9e7f3;}
    header{background:#2d3e50;color:white;display:flex;justify-content:space-between;align-items:center;padding:12px 30px;}
    .club-title{font-weight:800;font-size:1.8rem;}
    .request-btn{background:white;border-radius:20px;padding:6px 16px;border:1px solid #ccc;text-decoration:none;color:black;}
    .request-btn:hover{background:#f0f0f0;}
    .card{background:#f9f6f2;border-radius:15px;padding:20px;margin:15px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .btn-edit{background:#fff8c6;border:1px solid #ccc;border-radius:20px;padding:4px 10px;}
    .btn-delete{background:#f69191;color:white;border:none;border-radius:20px;padding:4px 10px;}
=======
    body.page-dashboard {
      background: #cfe2f3;
      font-family: "ariel", sans-serif;
    }

    .dashboard-container {
      max-width: 1000px;
      margin: 10px auto;
    }
    
    .dashboard-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      margin-bottom: 25px;
    }

    .welcome-box {
      background: #eff5fb;
      color: #2d3e50;
      font-weight: 700;
      font-size: larger;
      padding: 8px 18px;
      border-radius: 25px;
      text-align: center;
      margin-left: 365px;
    }

    .request-btn a {
      background: #2d3e50;
      color: #fff;
      font-weight: 700;
      text-decoration: none;
      padding: 6px 14px;
      border-radius: 25px;
      font-size: 0.9rem;
    }

    .clubs-panel {
      background: #fcf7f2;
      border: 2px solid #cfd7e1;
      border-radius: 20px;
      padding: 25px 25px 32px;
    }

    .clubs-title {
      font-weight: 800;
      color: #2b2b2b;
      margin-bottom: 18px;
      font-size: 1.2rem;
      border-left: 5px;
      padding-left: 10px;
    }

    .club-row {
      row-gap: 18px;
    }

    .club-card {
      background: #EBEBEB;
      border: 1.5px solid #a4b1c5ff;
      border-radius: 20px;
      padding: 14px 18px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .club-name {
      font-weight: 800;
      margin: 0;
      font-size: 1rem;
      color: #2b2b2b;
    }

    .club-buttons {
      display: flex;
      gap: 8px;
      align-items: center;
    }

    .btn-edit,
    .btn-delete {
      border: none;
      padding: 5px 12px;
      font-weight: 700;
      border-radius: 25px;
      text-decoration: none;
      color: #2d2d2d;
      line-height: 1;
    }

    .btn-edit {
      background: #fff3b0;
    }

    .btn-delete {
      background: #ffb0b0;
    }

>>>>>>> Stashed changes
  </style>
</head>
<body>
<header>
  <div class="club-title">CP Club</div>
  <div>
    <a href="{{ route('admin.requests') }}" class="request-btn">คำร้องขอ</a>
    <a href="{{ route('logout') }}" style="color:white;text-decoration:none;font-weight:bold;">Logout</a>
  </div>
</header>

<div class="container mt-4">
  <h3>ชมรมทั้งหมด</h3>
  <div class="row">
    @forelse($clubs as $club)
    <div class="col-md-4">
      <div class="card">
        <h5>{{ $club->name }}</h5>
        <p>{{ $club->description }}</p>
        <a href="{{ route('admin.clubs.edit',$club->id) }}" class="btn-edit">EDIT</a>
        <form action="{{ route('admin.clubs.destroy',$club->id) }}" method="POST" style="display:inline;">
          @csrf @method('DELETE')
          <button class="btn-delete" onclick="return confirm('ลบชมรมนี้หรือไม่?')">DELETE</button>
        </form>
      </div>
    </div>
    @empty
    <p class="text-center">ยังไม่มีชมรมในระบบ</p>
    @endforelse
  </div>
</div>
</body>
</html>
