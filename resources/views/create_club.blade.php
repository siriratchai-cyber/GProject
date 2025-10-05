<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สร้างชมรมใหม่ - CP Club</title>

  <!-- Bootstrap + SweetAlert -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body { font-family: "Arial", sans-serif; margin: 0; background: #d9e7f3; }
    header { background: #2d3e50; color: white; display: flex; align-items: center; justify-content: space-between; padding: 10px 30px; }
    header .logo { font-size: 32px; font-weight: bold; font-family: "Georgia", cursive; }
    header .nav { display: flex; gap: 20px; }
    header .nav a { color: white; text-decoration: none; font-weight: bold; }
    .username-box { background: #1a3552; padding: 5px 15px; color: white; border-radius: 5px; margin-right: 15px; display: inline-block; }

    .card { border-radius: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
    .form-control, .btn, select { border-radius: 12px !important; }
    .member-row { background: #f9fcff; border-radius: 15px; border: 1px solid #d9e7ff; box-shadow: 0 3px 8px rgba(0,0,0,0.05); }
    #preview { width: 100%; height: 310px; object-fit: cover; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .btn-success { background: #28a745; border: none; border-radius: 15px; padding: 10px 25px; box-shadow: 0 4px 12px rgba(40,167,69,0.3); transition: 0.2s; }
    .btn-success:hover { background: #218838; transform: translateY(-2px); }
    .btn-secondary, .btn-danger { border-radius: 12px; }
  </style>
</head>
<body>

<header>
  <div class="username-box">{{ $user->std_id }}</div>
  <div class="logo">CP Club</div>
  <div class="nav">
    <a href="{{ route('clubs.index') }}">All Clubs</a>
    <a href="{{ route('homepage.index') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

<div class="container mt-3 mb-2">
  <a href="{{ route('clubs.index') }}" class="btn btn-outline-secondary">⬅ กลับไป</a>
</div>

<div class="container py-3">
  <div class="card shadow-lg p-4">
    <h2 class="mb-4 text-center text-primary">📌 สร้างชมรมใหม่</h2>

    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
      @csrf

      <div class="row mb-4">
        <div class="col-md-4 text-center">
          <img id="preview" src="https://via.placeholder.com/300x200?text=Preview" class="img-fluid rounded border mb-3" alt="Preview">
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label">ชื่อชมรม</label>
            <input type="text" name="name" class="form-control" placeholder="เช่น ชมรมดนตรี" required>
          </div>
          <div class="mb-3">
            <label class="form-label">รายละเอียด</label>
            <textarea name="description" class="form-control" rows="4" placeholder="รายละเอียดชมรม" required></textarea>
          </div>
        </div>
      </div>

      <h6 class="mt-4 text-danger">** ต้องมีสมาชิกอย่างน้อย 5 คน และหัวหน้าชมรม 1 คน **</h6>
      <div id="memberList" class="mb-3"></div>
      <button type="button" class="btn btn-secondary mb-3" onclick="addMember()">+ เพิ่มสมาชิก</button>

      <div class="text-center">
        <button type="submit" id="saveBtn" class="btn btn-success px-4" disabled>💾 บันทึกชมรม</button>
      </div>
    </form>
  </div>
</div>

<script>
let memberCount = 0;

function previewImage(event){
  const reader = new FileReader();
  reader.onload = function(){ document.getElementById('preview').src = reader.result; }
  reader.readAsDataURL(event.target.files[0]);
}

function addMember() {
  const list = document.getElementById("memberList");
  const div = document.createElement("div");
  div.classList.add("row","mb-3","member-row","align-items-center","p-3");

  let number = list.querySelectorAll(".member-row").length + 1;
  div.innerHTML = `
    <div class="col-12 fw-bold mb-2">สมาชิกที่ ${number}</div>
    <div class="col-md-3 mb-2">
      <input type="text" name="members[${memberCount}][student_name]" class="form-control" placeholder="ชื่อ - นามสกุล" required>
    </div>
    <div class="col-md-3 mb-2">
      <input type="text" name="members[${memberCount}][student_id]" class="form-control" placeholder="รหัสนักศึกษา" required>
    </div>
    <div class="col-md-2 mb-2">
      <input type="text" name="members[${memberCount}][branch]" class="form-control" placeholder="สาขา" required>
    </div>
    <div class="col-md-2 mb-2">
      <input type="number" name="members[${memberCount}][year_level]" class="form-control" placeholder="ชั้นปี" min="1" max="8" required>
    </div>
    <div class="col-md-2 mb-2 d-flex justify-content-between">
      <select name="members[${memberCount}][position]" class="form-control position-select" required onchange="checkLeaderLimit(this)">
        <option value="">ตำแหน่ง</option>
        <option value="สมาชิก">สมาชิก</option>
        <option value="หัวหน้าชมรม">หัวหน้าชมรม</option>
      </select>
      <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeMember(this)">ลบ</button>
    </div>
  `;
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
  rows.forEach((row,index)=>{
    let label = row.querySelector(".fw-bold");
    if(label){ label.textContent = `สมาชิกที่ ${index+1}`; }
  });
}

function checkMemberCount() {
  let rows = document.querySelectorAll(".member-row").length;
  document.getElementById("saveBtn").disabled = rows < 5;
}

function checkLeaderLimit(select){
  if(select.value !== "หัวหน้าชมรม") return;
  let leaders = document.querySelectorAll(".position-select");
  leaders.forEach(s => {
    if(s !== select && s.value === "หัวหน้าชมรม"){
      Swal.fire("❌ จำกัดหัวหน้าชมรมได้เพียง 1 คนเท่านั้น");
      select.value = "";
    }
  });
}

function validateForm(){
  const rows = document.querySelectorAll(".member-row");
  if(rows.length < 5){
    Swal.fire("⚠️ สมาชิกต้องไม่น้อยกว่า 5 คน");
    return false;
  }
  const leader = Array.from(document.querySelectorAll(".position-select")).filter(s => s.value === "หัวหน้าชมรม");
  if(leader.length < 1){
    Swal.fire("❌ ต้องมีหัวหน้าชมรมอย่างน้อย 1 คน");
    return false;
  }
  Swal.fire("✅ บันทึกสำเร็จ", "ชมรมของคุณถูกสร้างเรียบร้อยแล้ว!", "success");
  return true;
}

document.addEventListener("input", checkMemberCount);
</script>

</body>
</html>
