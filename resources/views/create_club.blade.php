<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สร้างชมรมใหม่ - CP Club</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { font-family: Arial, sans-serif; background: #d9e7f3; margin: 0; }
    header { background: #2d3e50; color: white; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center; }
    .logo { font-size: 28px; font-weight: bold; font-family: "Arial", cursive;  margin-left: 670px;}
    .card { border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .form-control, .form-select { border-radius: 12px !important; }
    .member-row { background: #f9fcff; border-radius: 15px; border: 1px solid #d9e7ff; box-shadow: 0 3px 8px rgba(0,0,0,0.05); }
    #preview { width: 100%; height: 310px; object-fit: cover; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); } 
    
    .btn-back {
      background: #5e5f68;
      color: white;
      border-radius: 25px;
      padding: 7px 18px;
      font-weight: 600;
      display: inline-block;
      margin-top: 25px;
      margin-left: 25px;
      text-decoration: none;
    }
.nav { display: flex; gap: 20px; }
    .nav a { color: white; text-decoration: none; font-weight: bold; }
  </style>
</head>
<body>

<header>
  <div class="logo">CP Club</div>
  <div class="nav">
      <a href="{{ route('clubs.index') }}">All Clubs</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
</header>

<a href="{{ route('clubs.index') }}" class=" btn-back">⬅ กลับ</a>

<div class="container py-4">
  <div class="card p-4">
    
    <h2 class="text-center text-primary mb-4"> สร้างชมรมใหม่</h2>

    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
      @csrf

      <div class="row mb-4">
        <div class="col-md-4 text-center">
          <img id="preview" src="{{ old('image') ? asset('storage/'.old('image')) : 'https://via.placeholder.com/300x200?text=Preview' }}" class="img-fluid rounded border mb-3" alt="Preview">
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label">ชื่อชมรม</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="เช่น ชมรมดนตรี" required>
          </div>
          <div class="mb-3">
            <label class="form-label">รายละเอียด</label>
            <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">บทบาทของคุณในชมรมนี้:</label>
            <select name="creator_role" class="form-select" required onchange="checkCreatorRole(this)">
              <option value="">-- เลือกบทบาทของคุณ --</option>
              <option value="หัวหน้าชมรม" {{ old('creator_role')=='หัวหน้าชมรม'?'selected':'' }}>หัวหน้าชมรม</option>
              <option value="สมาชิก" {{ old('creator_role')=='สมาชิก'?'selected':'' }}>สมาชิก</option>
            </select>
          </div>
        </div>
      </div>

      <h6 class="text-danger">** ต้องมีสมาชิกอย่างน้อย 5 คน (รวมคุณ) และหัวหน้าชมรม 1 คน **</h6>
      <div id="memberList" class="mb-3"></div>
      <button type="button" class="btn btn-secondary mb-3" onclick="addMember()">+ เพิ่มสมาชิก</button>

      <div class="text-center">
        <button type="submit" id="saveBtn" class="btn btn-success px-4" disabled> บันทึกชมรม</button>
      </div>
    </form>
  </div>
</div>

{{-- แสดง SweetAlert --}}
@if(session('error'))
<script>
Swal.fire({
  icon: 'error',
  title: 'เกิดข้อผิดพลาด',
  html: `{!! session('error') !!}`,
  confirmButtonText: 'ตกลง'
});
</script>
@endif

@if(session('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'สำเร็จ!',
  text: "{{ session('success') }}",
  confirmButtonText: 'ตกลง'
}).then(() => window.location.href = "{{ route('clubs.index') }}");
</script>
@endif

<script>
let memberCount = 0;


function previewImage(event){
  const reader = new FileReader();
  reader.onload = () => document.getElementById('preview').src = reader.result;
  reader.readAsDataURL(event.target.files[0]);
}


function addMember() {
  const list = document.getElementById("memberList");
  const div = document.createElement("div");
  div.classList.add("row","mb-3","member-row","align-items-center","p-3");

  let number = list.querySelectorAll(".member-row").length + 1;
  div.innerHTML = `
    <div class="col-12 fw-bold mb-2">สมาชิกที่ ${number}</div>
    <div class="col-md-3 mb-2"><input type="text" name="members[${memberCount}][student_name]" class="form-control" placeholder="ชื่อ - นามสกุล" required></div>
    <div class="col-md-3 mb-2"><input type="text" name="members[${memberCount}][student_id]" class="form-control" placeholder="รหัสนักศึกษา" required></div>
    <div class="col-md-2 mb-2">
      <select name="members[${memberCount}][branch]" class="form-select" required>
        <option value="">สาขา</option>
        <option value="CS">CS</option><option value="CY">CY</option>
        <option value="IT">IT</option><option value="AI">AI</option>
        <option value="GIS">GIS</option>
      </select>
    </div>
    <div class="col-md-2 mb-2">
      <select name="members[${memberCount}][year_level]" class="form-select" required>
        <option value="">ปี</option>
        ${Array.from({length:8},(_,i)=>`<option value="${i+1}">${i+1}</option>`).join('')}
      </select>
    </div>
    <div class="col-md-2 mb-2 d-flex justify-content-between">
      <select name="members[${memberCount}][position]" class="form-select position-select" required onchange="checkLeaderLimit(this)">
        <option value="">ตำแหน่ง</option>
        <option value="สมาชิก">สมาชิก</option>
        <option value="หัวหน้าชมรม">หัวหน้าชมรม</option>
      </select>
      <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeMember(this)">ลบ</button>
    </div>`;
  list.appendChild(div);
  memberCount++;
  checkMemberCount();
}


function removeMember(btn) {
  btn.closest(".member-row").remove();
  reorderMembers();
  checkMemberCount();
}


function reorderMembers() {
  let rows = document.querySelectorAll("#memberList .member-row");
  rows.forEach((row,i)=> row.querySelector(".fw-bold").textContent = `สมาชิกที่ ${i+1}`);
}


function checkMemberCount() {
  let rows = document.querySelectorAll(".member-row").length;
  document.getElementById("saveBtn").disabled = (rows + 1) < 5;
}


function checkLeaderLimit(select){
  const creatorRole = document.querySelector("select[name='creator_role']").value;
  if (creatorRole === "หัวหน้าชมรม" && select.value === "หัวหน้าชมรม") {
    Swal.fire(" ผู้สร้างเป็นหัวหน้าชมรมแล้ว ห้ามเพิ่มหัวหน้าซ้ำ");
    select.value = "";
    return;
  }
  if(select.value === "หัวหน้าชมรม"){
    let leaders = document.querySelectorAll(".position-select");
    leaders.forEach(s => {
      if(s !== select && s.value === "หัวหน้าชมรม"){
        Swal.fire(" จำกัดหัวหน้าชมรมได้เพียง 1 คนเท่านั้น");
        select.value = "";
      }
    });
  }
}


function checkCreatorRole(select){
  const creatorRole = select.value;
  if(creatorRole === "หัวหน้าชมรม"){
    const memberLeaders = Array.from(document.querySelectorAll(".position-select")).filter(s => s.value === "หัวหน้าชมรม");
    if(memberLeaders.length > 0){
      Swal.fire(" มีหัวหน้าชมรมอยู่แล้วในรายชื่อสมาชิก");
      select.value = "";
    }
  }
}


function validateForm(){
  const rows = document.querySelectorAll(".member-row");
  if(rows.length + 1 < 5 ){
    Swal.fire(" ต้องมีสมาชิกอย่างน้อย 5 คนรวมผู้สร้าง");
    return false;
  }
  const leaderFromCreator = document.querySelector("select[name='creator_role']").value === "หัวหน้าชมรม";
  const leaderFromMembers = Array.from(document.querySelectorAll(".position-select")).some(s => s.value === "หัวหน้าชมรม");
  if(!leaderFromCreator && !leaderFromMembers){
    Swal.fire(" ต้องมีหัวหน้าชมรมอย่างน้อย 1 คน");
    return false;
  }
  return true;
}

</script>

</body>
</html>
@if(old('members'))
<script>
  const oldMembers = 
  @json(old('members'));
  oldMembers.forEach((m, i) => {
    addMember();
    document.querySelector(`[name="members[${i}][student_name]"]`).value = m.student_name || "";
    document.querySelector(`[name="members[${i}][student_id]"]`).value = m.student_id || "";
    document.querySelector(`[name="members[${i}][branch]"]`).value = m.branch || "";
    document.querySelector(`[name="members[${i}][year_level]"]`).value = m.year_level || "";
    document.querySelector(`[name="members[${i}][position]"]`).value = m.position || "";
  });
</script>
@endif