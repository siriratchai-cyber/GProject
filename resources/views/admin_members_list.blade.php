@extends('layouts.headadmin')
@section('title', 'จัดการสมาชิกในชมรม')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
  <style>
    body.page-member-list {
      background-color: #d9e7f3;
      font-family:  "Arial", sans-serif;
      margin: 0;
      padding: 30px 0;
    }

    .member-list-container {
      max-width: 1000px;
      margin:auto;
      background: #f9f6f2;
      border-radius: 20px;
      padding: 40px 45px;
    }

    .member-list-title {
      text-align: center;
      font-weight: 800;
      color: #2d3e50;
      margin-bottom: 35px;
      margin-top: -55px;
    }

    .member-table {
      width: 100%;
      border-collapse: collapse;
    }

    .member-table thead {
      background: #e2ecf3;
      font-weight: 700;
    }

    .member-table th,
    .member-table td {
      text-align: center;
      vertical-align: middle;
      padding: 10px 12px;
      border: 1.5px solid #d1d9e0;
    }

    .member-action-btn {
      border: none;
      background: #2d3e50;
      color: white;
      border-radius: 25px;
      padding: 6px 14px;
      font-weight: 60;
      text-decoration: none;
    }

    .btn-back {
      background: #5e5f68;
      color: white;
      border-radius: 25px;
      padding: 8px 16px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 15px;
    }

  </style>

  <div class="member-list-container page-member-list">
    <a href="{{ route('admin.clubs.edit', $club->id) }}" class="btn-back">⬅ กลับ</a>
    <h3 class="member-list-title">แก้ไขสมาชิกใน{{ $club->name }}</h3>

    <table class="member-table">
      <thead>
        <tr>
          <th>ชื่อ-นามสกุล</th>
          <th>รหัสนักศึกษา</th>
          <th>ตำแหน่ง</th>
          <th>สถานะ</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        @forelse($club->members as $member)
          <tr>
            <td>{{ $member->name }}</td>
            <td>{{ $member->student_id }}</td>
            <td>{{ $member->role }}</td>
            <td>{{ $member->status }}</td>
            <td>
              <a href="{{ route('admin.member.edit', ['club_id' => $club->id, 'member_id' => $member->id]) }}"
                class="member-action-btn">แก้ไข</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" style="color:#777;">ไม่มีข้อมูลสมาชิก</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection