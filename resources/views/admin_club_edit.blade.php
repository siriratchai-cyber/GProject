<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>แก้ไขชมรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body.page-edit {
      background-color: #cfe2f3;
      font-family: "Sarabun", sans-serif;
      margin: 0;
    }

    .app-header {
      background: #2d3e50;
      color: #fff;
      padding: 12px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
    }
    .header-left .username-box {
      border: 2px solid rgba(255,255,255,.6);
      border-radius: 8px;
      padding: 6px 12px;
      font-weight: 700;
      background: rgba(255,255,255,.06);
    }
    .header-center .club-title {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-weight: 800;
      font-size: 1.9rem;
      letter-spacing: .5px;
    }
    .header-right a {
      color: #fff;
      text-decoration: none;
      font-weight: 700;
      margin-left: 20px;
    }

    .back-wrap {
      width: min(1100px, 92%);
      margin: 18px auto 0;
    }
    .back-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px; height: 44px;
      border: 2px solid #8ea5b8;
      border-radius: 50%;
      background: #e9f0f6;
      color: #2d3e50;
      text-decoration: none;
      font-size: 20px;
      font-weight: 800;
      box-shadow: 0 2px 6px rgba(0,0,0,.06);
    }

    .edit-card {
      background: #fbf5ef;
      border: 1px solid #b9b9b9;
      border-radius: 22px;
      width: min(1100px, 92%);
      margin: 16px auto 60px;
      padding: 26px 30px 32px;
      box-shadow: 0 4px 14px rgba(0,0,0,.06);
    }
    .page-title {
      margin: 0 0 18px;
      text-align: center;
      font-weight: 800;
    }

    .edit-grid {
      display: grid;
      grid-template-columns: 360px 1fr;
      gap: 26px;
      align-items: start;
    }

    .club-image {
      width: 100%;
      max-width: 360px;
      aspect-ratio: 4 / 3;
      object-fit: cover;
      border: 1px solid #cfcfcf;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,.06);
      background: #fff;
    }
    .file-input {
      margin-top: 10px;
      border-radius: 10px;
      padding: 6px 10px;
      border: 1.5px solid #b8b8b8;
      background: #fff;
      width: 100%;
    }

    .field-label {
      font-weight: 800;
      margin-bottom: 6px;
      display: block;
    }
    .text-input,
    .textarea-input {
      width: 100%;
      border: 1.5px solid #b8b8b8;
      border-radius: 12px;
      padding: 8px 12px;
      background: #fff;
      outline: none;
    }

    .desc-box {
      border: 2px solid #9da6ad;
      border-radius: 16px;
      padding: 12px 14px;
      background: #fff;
    }
    .textarea-input {
      border: none;
      box-shadow: none;
      resize: vertical;
      min-height: 140px;
    }

    .btn-members,
    .btn-save,
    .btn-back {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 10px;
      font-weight: 800;
      text-decoration: none;
      box-shadow: 0 2px 0 rgba(0,0,0,.04);
    }
    .btn-members {
      background: #e7f0ff;
      border: 1px solid #a7b9e6;
      color: #1f3a6d;
    }
    .btn-save {
      background: #ffffff;
      border: 1px solid #bdbdbd;
      color: #222;
    }
    .btn-back {
      background: #f1f1f1;
      border: 1px solid #cfcfcf;
      border-radius: 10px;
      font-weight: 800;
      padding: 8px 14px;
      color: #222;
      margin-left: 8px;
      box-shadow: 0 2px 0 rgba(0,0,0,.04);
      text-decoration: none;
      display: inline-block;
    }
  </style>
</head>

<body class="page-edit">

  <header class="app-header">
    <div class="header-left">
      <div class="username-box">username</div>
    </div>
    <div class="header-center">
      <div class="club-title">CP club</div>
    </div>
    <div class="header-right">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
  </header>

  <div class="back-wrap">
    <a class="back-btn" href="{{ route('admin.dashboard') }}">←</a>
  </div>

  <div class="edit-card">
    <h3 class="page-title">แก้ไขชมรม: {{ $club->name }}</h3>

    <form class="edit-form" action="{{ route('admin.clubs.update', $club->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="edit-grid">
        <!-- ซ้าย: รูป -->
        <div class="left-col">
          <img
            class="club-image"
            src="{{ $club->image ? asset('storage/' . $club->image) : 'https://via.placeholder.com/360x270' }}"
            alt="Club Image">
          <input type="file" name="image" class="file-input" accept="image/*">
        </div>

        <div class="right-col">
          <div class="mb-3">
            <label class="field-label">ชื่อชมรม :</label>
            <input type="text" name="name" class="text-input"
                   value="{{ old('name', $club->name) }}">
          </div>

          <div class="mb-2">
            <label class="field-label">รายละเอียดชมรม :</label>
            <div class="desc-box">
              <textarea name="description" class="textarea-input" rows="5">{{ old('description', $club->description) }}</textarea>
            </div>
          </div>

          <div class="text-end mt-3">
            <button type="submit" class="btn-save">บันทึกข้อมูล</button>
          </div>
        </div>
      </div>

      <div class="divider"></div>

      <a href="{{ route('admin.clubs.members', $club->id) }}" class="btn-members">จัดการสมาชิกชมรม</a>
    </form>
  </div>
</body>
</html>
