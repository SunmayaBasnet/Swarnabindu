<?php
// ===== DATABASE CONNECTION =====
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "swornabindu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ===== HANDLE FORM SUBMISSION =====
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // OPTIONAL FIELDS
    $registration_id   = $_POST['id'] ?? null;  
    $bindu_status      = $_POST['bindu_status'] ?? null;
    $allergy_history   = $_POST['allergy_history'] ?? null;
    $medical_history   = $_POST['medical_history'] ?? null;
    $weight            = $_POST['weight'] ?? null;
    $height            = $_POST['height'] ?? null;
    $muac              = $_POST['muac'] ?? null;
    $upper_arm_circ    = $_POST['upper_arm_circ'] ?? null;
    $chest_circ        = $_POST['chest_circ'] ?? null;
    $child_age_year    = $_POST['child_age_year'] ?? null;
    $child_age_month   = $_POST['child_age_month'] ?? null;

    // ===== REMOVE STRICT VALIDATION (Now Optional) =====
    // No check for registration_id or bindu_status

    // ===== INSERT INTO health_info =====
    $stmt = $conn->prepare("
        INSERT INTO health_info 
        (id, bindu_status, allergy_history, medical_history, weight, height, muac, upper_arm_circ, chest_circ, child_age_year, child_age_month)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssddddiii",
        $registration_id,
        $bindu_status,
        $allergy_history,
        $medical_history,
        $weight,
        $height,
        $muac,
        $upper_arm_circ,
        $chest_circ,
        $child_age_year,
        $child_age_month
    );

    if ($stmt->execute()) {
        $lastId= $registration_id;
        echo "<script>alert('Health information saved successfully!'); window.location.href='register2.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Health Information</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f5f7f8;
      font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
      font-size: 14px;
    }
    .main-box {
      max-width: 1000px;
      margin: 30px auto;
      border-radius: 18px;
      background-color: #fff;
      box-shadow: 0 4px 18px rgba(0,0,0,0.06);
      padding: 24px 28px 28px;
    }
    .section-box {
      border: 1px solid #cfe3d8;
      border-radius: 10px;
      padding: 20px;
      background-color: #f9fff9;
    }
    .toggle-btn.active {
      background-color: #28a745 !important;
      color: #fff !important;
    }
  </style>
</head>
<body>

  <div class="main-box">
    <form method="POST" action="">
      
      <!-- Hidden ID coming from ?id=XX -->
      <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">
      <input type="hidden" name="bindu_status" id="bindu_status" value="New">

      <div class="bg-success text-white p-3 rounded-3 mb-3">
        <h4 class="m-0">Health Information</h4>
      </div>

      <div class="row g-4">
        
        <!-- LEFT -->
        <div class="col-lg-6">
          <div class="section-box">
            <label class="fw-bold mb-2">बिन्दु स्थिति | Bindu Status</label>
            <div class="d-flex gap-2 mb-3">
              <button type="button" class="btn btn-outline-dark toggle-btn active" onclick="setBindu('New', this)">New</button>
              <button type="button" class="btn btn-outline-dark toggle-btn" onclick="setBindu('Old', this)">Old</button>
            </div>

            <label class="fw-semibold mb-2">Allergy History</label>
            <textarea class="form-control mb-3" name="allergy_history" rows="3"></textarea>

            <label class="fw-semibold mb-2">Medical History</label>
            <textarea class="form-control" name="medical_history" rows="3"></textarea>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-6">
          <div class="section-box">
            <h6 class="fw-bold mb-3">शारीरिक मापन | Anthropometry</h6>

            <div class="row gy-3">
              <div class="col-md-4">
                <label class="fw-semibold">Weight (kg)</label>
                <input type="number" name="weight" class="form-control" required>
              </div>

              <div class="col-md-4">
                <label class="fw-semibold">Height (cm)</label>
                <input type="number" name="height" class="form-control" required>
              </div>

              <div class="col-md-4">
                <label class="fw-semibold">MUAC (cm)</label>
                <input type="number" name="muac" class="form-control" required>
              </div>

              <div class="col-md-6">
                <label class="fw-semibold">Upper Arm (cm)</label>
                <input type="number" name="upper_arm_circ" class="form-control">
              </div>

              <div class="col-md-6">
                <label class="fw-semibold">Chest (cm)</label>
                <input type="number" name="chest_circ" class="form-control">
              </div>

              <div class="col-md-6 mt-2">
                <label class="fw-semibold">Child Age (Years)</label>
                <input type="number" name="child_age_year" class="form-control" required>
              </div>

              <div class="col-md-6 mt-2">
                <label class="fw-semibold">Child Age (Months)</label>
                <input type="number" name="child_age_month" class="form-control" required>
              </div>
            </div>

          </div>
        </div>

      </div>

      <div class="d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-dark px-4">अर्को चरण | Next Step</button>
      </div>

    </form>
  </div>

<script>
function setBindu(status, btn) {
  document.getElementById('bindu_status').value = status;
  document.querySelectorAll('.toggle-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}
</script>

</body>
</html>
