<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - CP Club</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{font-family:'Sarabun',sans-serif;background:#d9e7f3;}
    header{background:#2d3e50;color:white;display:flex;justify-content:space-between;align-items:center;padding:12px 30px;}
    .club-title{font-weight:800;font-size:1.8rem;}
    .request-btn{background:white;border-radius:20px;padding:6px 16px;border:1px solid #ccc;text-decoration:none;color:black;}
    .request-btn:hover{background:#f0f0f0;}
    .card{background:#f9f6f2;border-radius:15px;padding:20px;margin:15px;box-shadow:0 2px 8px rgba(0,0,0,0.1);}
    .btn-edit{background:#fff8c6;border:1px solid #ccc;border-radius:20px;padding:4px 10px;}
    .btn-delete{background:#f69191;color:white;border:none;border-radius:20px;padding:4px 10px;}
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
