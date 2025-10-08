@extends('layouts.headadmin')
@section('title', 'จัดการคำร้องทั้งหมด')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
  <style>

    body.page-requests {
      background-color: #d9e7f3;
      font-family: "Arial", sans-serif;
    }

    .request-container {
      max-width: 1000px;
      margin: 20px auto;
      background: #f9f6f2;
      border-radius: 20px;
      padding: 40px 45px;
    }

    .btn-back {
      background: #5e5f68;
      color: white;
      border-radius: 25px;
      padding: 7px 18px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 25px;
    }

    .request-title {
      font-weight: 800;
      color: #2d3e50;
      text-align: center;
      margin-top: -60px;
      margin-bottom: 40px;
    }

    .section-title {
      font-weight: 700;
      color: #2d3e50;
      margin-top: 10px;
      margin-bottom: 15px;
    }

    .request-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 25px;
    }

    .request-table thead {
      background: #e2ecf3;
      font-weight: 700;
    }

    .request-table th,
    .request-table td {
      text-align: center;
      vertical-align: middle;
      padding: 10px 12px;
      border: 1.5px solid #d1d9e0;
    }

    .request-table th {
      color: #2b2b2b;
    }

    .btn-approve {
      background: #A9CF88;
      color: #000;
      border: none;
      border-radius: 20px;
      padding: 8px 20px;
      font-weight: 700;
      text-decoration: none;
      display: inline-block;
    }

    .btn-reject {
      background: #F69191;
      color: #000;
      border: none;
      border-radius: 20px;
      padding: 8px 20px;
      font-weight: 700;
      text-decoration: none;
      display: inline-block;
    }
  </style>

  <div class="request-container page-requests">
    <a href="{{ route('admin.dashboard') }}" class="btn-back">⬅ กลับ</a>
    <h3 class="request-title">คำร้องขอสร้างชมรม</h3>

    <table class="request-table">
      <thead>
        <tr>
          <th>ชื่อชมรม</th>
          <th>รายละเอียด</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pendingClubs as $club)
          <tr>
            <td>{{ $club->name }}</td>
            <td>{{ $club->description }}</td>
            <td>
              <form action="{{ route('admin.clubs.approve', $club->id) }}" method="POST" style="display:inline">
                @csrf
                <button class="btn-approve">อนุมัติ</button>
              </form>
              <form action="{{ route('admin.clubs.reject', $club->id) }}" method="POST" style="display:inline">
                @csrf
                <button class="btn-reject">ไม่อนุมัติ</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td">ไม่มีคำร้องในขณะนี้</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection