<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>อนุมัติคำร้องชมรม</title>

  <style>
    body.page-requests {
      background-color: #cfe2f3;
      font-family: "Sarabun", sans-serif;
      color: #2b2b2b;
      margin: 0;
    }

    .top {
      display: inline-flex;
      align-items: center;
      font-weight: 700;
      color: #2d3e50;
      margin-left: 20em;
      margin-top: 5px;
      margin-bottom: 10px;
      font-size: 1.2rem;
    }

    .header-bar {
      background: #2d3e50;
      color: #fff;
      padding: 12px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .header-username {
      opacity: 0.9;
      margin-right: 10px;
    }

    .btn-logout {
      border: 1.5px solid rgba(255, 255, 255, 0.7);
      color: #fff;
      border-radius: 999px;
      padding: 4px 12px;
      font-weight: 600;
      text-decoration: none;
    }


    .btn-back {
      display: inline-block;
      margin: 20px 0;
      background-color: #f7e37b;
      padding: 8px 18px;
      border-radius: 20px;
      font-weight: 700;
      color: #333;
      text-decoration: none;
      box-shadow: 0 1px 2px rgba(0, 0, 0, .1);
    }

    .approval-container {
      background-color: #d9edf8;
      border: none;
      border-radius: 14px;
      padding: 20px;
    }

    .approval-table {
      width: 100%;
      border-collapse: separate !important;
      border-spacing: 0 14px;
      background: transparent;
    }

    .approval-table thead th {
      border: none;
      color: #2d3e50;
      font-weight: 800;
      text-align: center;
    }

    .approval-table tbody tr {
      background: #ffffff;
      box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
    }

    .approval-table tbody td {
      text-align: center;
      padding: 14px 18px !important;
      vertical-align: middle;
    }

    .approval-table tbody tr td:first-child {
      border-top-left-radius: 12px;
      border-bottom-left-radius: 12px;
    }

    .approval-table tbody tr td:last-child {
      border-top-right-radius: 12px;
      border-bottom-right-radius: 12px;
    }


    .btn-approve {
      background: #a6e4b2 !important;
      border: none !important;
      color: #155b2b !important;
      font-weight: 700;
      border-radius: 999px !important;
      padding: 6px 18px !important;
    }

    .btn-reject {
      background: #f6b0b0;
      border: none ;
      color: #7b1f1f ;
      font-weight: 700;
      border-radius: 999px;
      padding: 6px 18px;
    }

    .btn-group-inline {
      display: flex;
      justify-content: center;
      gap: 10px;
    }
  </style>
</head>

<body class="page-requests">
  <header class="header-bar">
    <div>CP club</div>
    <div>
      <span class="header-username">Welcome admin</span>
      <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
    </div>
  </header>

  <div class="container py-4">
    <a href="{{ route('admin.dashboard') }}" class="btn-back">←</a>
    <span class="top">คำร้องขอการสร้างชมรม</span>

    <div class="approval-container">
      <div class="table-responsive">
        <table class="approval-table align-middle m-0">
          <thead>
            <tr>
              <th>ชื่อชมรม</th>
              <th>สถานะ</th>
              <th>การจัดการ</th>
            </tr>
          </thead>
          <tbody>
            @forelse($clubs as $club)
              <tr>
                <td>{{ $club->name }}</td>
                <td>{{ $club->status }}</td>
                <td>
                  <div class="btn-group-inline">
                    <form action="{{ route('admin.clubs.approve', $club->id) }}" method="POST" class="d-inline-block">
                      @csrf
                      <button type="submit" class="btn-approve">อนุมัติ</button>
                    </form>
                    <form action="{{ route('admin.clubs.reject', $club->id) }}" method="POST"
                      onsubmit="return confirm('ยืนยันปฏิเสธและลบคำร้องนี้หรือไม่?')">
                      @csrf
                      <button type="submit" class="btn-reject">ไม่อนุมัติ</button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="3">ยังไม่มีคำร้องชมรมใหม่</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>