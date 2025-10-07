@extends('layouts.headadmin')
@section('title', 'หน้าหลักแอดมิน')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
<style>
  body.page-dashboard {
    background: #cfe2f3;
    font-family: "Ariel", sans-serif;
  }

  .dashboard-container {
    max-width: 1000px;
    margin: 30px auto;
    padding: 0 20px;
  }

  .dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 25px;
    gap: 10px;
  }

  .welcome-box {
    background: #eff5fb;
    color: #2d3e50;
    font-weight: 700;
    padding: 8px 18px; 
    border-radius: 25px;
    text-align: center;
    min-width: 220px;
    font-size: 0.95rem; 
    margin: auto;
    margin-right: 225px;
  }

  .request-btn a {
    background: #2d3e50;
    color: #fff;
    font-weight: 700;
    text-decoration: none;
    padding: 6px 14px; 
    border-radius: 25px;
    font-size: 0.9rem;
    margin-right: 50px;
  }


  .clubs-panel {
    background: #fcf7f2;
    border: 1px solid #cfd7e1;
    border-radius: 25px;
    padding: 25px 25px 32px;
  }

  .clubs-title {
    font-weight: 800;
    color: #2b2b2b;
    margin-bottom: 18px;
    font-size: 1.2rem;
    padding-left: 10px;
  }

  .club-row {
    row-gap: 18px;
  }

  .club-card {
    background: #F1EEEE;
    border: 1.5px solid #b1bccfff;
    border-radius: 18px;
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
    border-radius: 999px;
    text-decoration: none;
    color: #2d2d2d;
    line-height: 1;
    font-size: 0.9rem;
  }

  .btn-edit {
    background: #fff3b0;
  }

  .btn-delete {
    background: #ffb0b0;
  }
</style>



  <div class="dashboard-container">
    <div class="dashboard-header">
      <div class="welcome-box">Welcome admin {{ $user->std_name ?? 'admin' }}</div>
      <div class="request-btn">
        <a href="{{ route('admin.requests') }}">คำร้องขอ</a>
      </div>
    </div>

    <div class="clubs-panel">
      <div class="clubs-title">ชมรมทั้งหมด</div>

      <div class="row club-row">
        @forelse($clubs as $club)
          <div class="col-md-6">
            <div class="club-card">
              <div>
                <p class="club-name">{{ $club->name }}</p>
              </div>

              <div class="club-buttons">
                <a href="{{ route('admin.clubs.edit', $club->id) }}" class="btn-edit">EDIT</a>
                <form action="{{ route('admin.clubs.destroy', $club->id) }}" method="POST"
                  onsubmit="return confirm('ลบชมรมนี้หรือไม่?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-delete">DELETE</button>
                </form>
              </div>
            </div>
          </div>
        @empty
        @endforelse
      </div>
    </div>
  </div>
@endsection