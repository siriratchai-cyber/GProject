<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>สร้างชมรมใหม่</title>

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
  <div class="username-box">username</div>
  <div class="logo">CP club</div>
  <div class="nav">
    <a href="#">Dashboard</a>
    <a href="#">Logout</a>
  </div>
</header>

<div class="container mt-3 mb-2">
  <a href="/clubs" class="btn btn-outline-secondary">⬅ กลับไป</a>
</div>

<div class="container py-3">
  <div class="card shadow-lg p-4">
    <h2 class="mb-4 text-center text-primary">📌 สร้างชมรมใหม่</h2>

    <form action="{{ route('clubs.store') }}" method="POST" enctype="multipart/form-data">
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

      <h6 class="mt-4">**สมาชิก ต้องมีอย่างน้อย 5 คน และหัวหน้าชมรม 1 คน**</h6>
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

// preview รูป
function previewImage(event){
  const reader = new FileReader();
  reader.onload = function(){ document.getElementById('preview').src = reader.result; }
  reader.readAsDataURL(event.target.files[0]);
}

// เพิ่มสมาชิก
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
    <div class="col-md-2 mb-2">
      <input type="text" name="members[${memberCount}][student_id]" class="form-control" pattern="\\d{6,9}-\\d" placeholder="6XXXXXXXX-6" required>
    </div>
    <div class="col-md-3 mb-2">
      <select name="members[${memberCount}][branch]" class="form-control" required>
        <option value="">เลือกสาขา</option>
        <option value="วิทยาการคอมพิวเตอร์">วิทยาการคอมพิวเตอร์</option>
        <option value="เทคโนโลยีสารสนเทศ">เทคโนโลยีสารสนเทศ</option>
        <option value="ภูมิสารสนเทศศาสตร์">ภูมิสารสนเทศศาสตร์</option>
        <option value="ปัญญาประดิษฐ์">ปัญญาประดิษฐ์</option>
        <option value="ความมั่นคงปลอดภัยไซเบอร์">ความมั่นคงปลอดภัยไซเบอร์</option>
      </select>
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

// ลบสมาชิก
function removeMember(btn) {
  btn.closest(".member-row").remove();
  reorderMembers();
  checkMemberCount();
}

// เรียงลำดับสมาชิกใหม่
function reorderMembers() {
  let rows = document.querySelectorAll("#memberList .member-row");
  rows.forEach((row,index)=>{
    let label = row.querySelector(".fw-bold");
    if(label){ label.textContent = `สมาชิกที่ ${index+1}`; }
  });
}

// เช็คจำนวนสมาชิก ≥5
function checkMemberCount() {
  let rows = document.querySelectorAll(".member-row").length;
  document.getElementById("saveBtn").disabled = rows < 5;
}

// ตรวจชื่อ/รหัสซ้ำ
function checkDuplicate() {
  let idMap = {}, nameMap = {}, errors = [];

  document.querySelectorAll("input[name^='members'][name$='[student_id]']").forEach((input, idx)=>{
    let val = input.value.trim();
    if(!idMap[val]) idMap[val] = [];
    idMap[val].push(idx + 1);
    input.classList.remove("is-invalid");
  });
  for(let key in idMap){
    if(idMap[key].length > 1){
      errors.push(`รหัส ${key} ซ้ำกันในสมาชิกคนที่ ${idMap[key].join(', ')}`);
      idMap[key].forEach(i=>{
        document.querySelectorAll("input[name^='members'][name$='[student_id]']")[i-1].classList.add("is-invalid");
      });
    }
  }

  document.querySelectorAll("input[name^='members'][name$='[student_name]']").forEach((input, idx)=>{
    let val = input.value.trim();
    if(!nameMap[val]) nameMap[val] = [];
    nameMap[val].push(idx + 1);
    input.classList.remove("is-invalid");
  });
  for(let key in nameMap){
    if(nameMap[key].length > 1){
      errors.push(`ชื่อ ${key} ซ้ำกันในสมาชิกคนที่ ${nameMap[key].join(', ')}`);
      nameMap[key].forEach(i=>{
        document.querySelectorAll("input[name^='members'][name$='[student_name]']")[i-1].classList.add("is-invalid");
      });
    }
  }

  if(errors.length > 0){
    Swal.fire("⚠️ พบข้อมูลซ้ำ", errors.join("<br>"), "error");
    return false;
  }
  return true;
}

// ตรวจหัวหน้าซ้ำ
function checkLeaderLimit(select){
  if(select.value !== "หัวหน้าชมรม") return;
  let leaders = document.querySelectorAll(".position-select");
  leaders.forEach(s => {
    if(s !== select && s.value === "หัวหน้าชมรม"){
      Swal.fire("❌ สามารถมีหัวหน้าชมรมได้แค่ 1 คน");
      select.value = "";
    }
  });
}

// submit form + reindex สมาชิก
document.querySelector("form").addEventListener("submit", function(e){
  // Reindex สมาชิกให้ต่อเนื่อง
  document.querySelectorAll(".member-row").forEach((row, idx) => {
      row.querySelectorAll("input, select").forEach(input => {
          input.name = input.name.replace(/members\[\d+\]/, `members[${idx}]`);
      });
  });

  if(!checkDuplicate()){ 
      e.preventDefault(); 
      return; 
  }

  let leaderCount = 0;
  document.querySelectorAll(".position-select").forEach(s=>{
      if(s.value === "หัวหน้าชมรม") leaderCount++;
  });

  if(leaderCount < 1){
      e.preventDefault();
      Swal.fire("❌ ต้องมีหัวหน้าชมรมอย่างน้อย 1 คน");
  }
});

// อัปเดตปุ่มบันทึก
document.addEventListener("input", checkMemberCount);
</script>

</body>
</html>
