<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "swornabindu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -------------------------
// GET registration_id
// -------------------------
$registration_id = isset($_GET['registration_id']) ? $_GET['registration_id'] : 0;

// -------------------------
// FETCH PATIENT DATA
// From table: health_info
// -------------------------
$patient = null;
if ($registration_id > 0) {
    $stmt = $conn->prepare("
        SELECT name, gender, phone_number, date_of_birth,
        child_age_year, child_age_month
        FROM health_info
        WHERE registration_id = ?
    ");
    $stmt->bind_param("i", $registration_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
}

// -------------------------
// INSERT INTO doctor_admin
// -------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $registration_id = $_POST['registration_id'];
    $doctor_name = $_POST['doctor_name'];
    $batch_no = $_POST['batch_no'];
    $dose = $_POST['dose'];
    $note = $_POST['note'];

    // checkbox: if checked = 1, else 0
    $content_eligible = isset($_POST['consent_eligible']) ? 1 : 0;
    $content_guardian = isset($_POST['consent_guardian']) ? 1 : 0;

    $insert = $conn->prepare("
        INSERT INTO doctor_admin 
        (registration_id, doctor_name, batch_no, dose, note, content_eligible, content_guardian) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $insert->bind_param("issisii", 
        $registration_id, 
        $doctor_name, 
        $batch_no, 
        $dose, 
        $note, 
        $content_eligible, 
        $content_guardian
    );

    if ($insert->execute()) {
        echo "<script>alert('Data stored successfully!'); window.location='RegistrationSucc.php';</script>";
        exit();
    } else {
        echo "Error: " . $insert->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ne">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
/>

<style>
  body {
    background: #f5f7f8;
    font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
    font-size: 12px;
  }

  .container {
    padding: 50px 15px;
  }

  @media (min-width: 576px) { .container { padding: 70px 20px; } }
  @media (min-width: 768px) { .container { padding: 100px 40px; } }
  @media (min-width: 992px) { .container { padding: 180px 60px; } }
  @media (min-width: 1200px) { .container { padding: 300px 80px; } }

  .main-box {
    background: white;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
    max-width: 800px;
    margin: 0 auto;
  }

  .quick-bar {
    background: #f5fff5;
    border-radius: 12px;
    border: 1px solid #d4f4db;
  }

  .first { background: rgb(222, 92, 27); }
  .button { border: 1px solid gray; border-radius: 5px; }
  .custom-textarea:focus {
    border-color: gray;
    box-shadow: 0 0 0 0.2rem rgba(101, 102, 104, 0.25);
    outline: 0;
  }
  .active-doctor{
    background:#0d6efd !important;
    color:white !important;
    border-color:#0d6efd !important
  }
  .form-control, .custom-textarea, .doctor-btn button{
    width: 100%;
  }
  @media (min-width:576px){
    .doctor-btn button{
      width:auto;
    }
    .doctor-btn{
      flex-wrap:wrap;
      gap: 10px;
    }
  }
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm position-relative">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="HomePage.php">गृहपृष्ठ</a></li>
        <li class="nav-item"><a class="nav-link" href="Register.php">नयाँ दर्ता</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-3">
  <div class="main-box">

    <!-- Header -->
    <div class="first text-white p-3 rounded-3 mb-4">
      <h4 class="m-1">स्वर्णबिन्दु प्राशन विवरण | Administration Form</h4>
    </div>

    <!-- Quick bar -->
    <div class="quick-bar d-flex justify-content-between px-3 py-2 mb-3">
      <span class="text-success">द्रुत दर्ता | Quick Registration</span>
      <span class="badge bg-white text-dark border">Step 3/3</span>
    </div>

    <!-- ADMIN FORM START -->
    <form action="" method="POST">
      <input type="hidden" name="registration_id" value="<?php echo $registration_id; ?>">

      <p class="mb-1">सेवन गर्ने व्यक्ति *</p>

      <div class="doctor-btn d-flex">
        <button type="button" class="btn btn-light button doctor-select" onclick="setDoctor('डा. प्रतिभा शर्मा',this)">डा. प्रतिभा शर्मा</button>
        <button type="button" class="btn btn-light button doctor-select" onclick="setDoctor('डा. यक राज भण्डारी', this)">डा. यक राज भण्डारी</button>
      </div>

      <input type="hidden" id="doctor_name" name="doctor_name">

      <div class="row mt-3">
        <div class="col-md-6">
          <label class="form-label">ब्याच नम्बर</label>
          <input type="text" class="form-control custom-textarea" name="batch_no" value="" />
        </div>

        <div class="col-md-6">
          <label class="form-label">मात्रा (थोपा)</label>
          <input type="number" class="form-control custom-textarea" name="dose" value="1" />
        </div>
      </div>

      <div class="mt-3">
        <label class="form-label">टिप्पणी</label>
        <textarea class="form-control custom-textarea" rows="3" name="note"></textarea>
      </div>

      <hr />

      <div class="form-check mb-2">
        <input class="form-check-input" type="checkbox" name="consent_eligible" checked />
        <label class="form-check-label">बालक योग्य छ</label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="consent_guardian" checked />
        <label class="form-check-label">अभिभावकको सहमति छ</label>
      </div>

      <div class="d-flex justify-content-between mt-3">
        <a href="Register1.php" class="btn btn-light border">← पछाडि</a>
        <button class="btn btn-dark border" type="submit">दर्ता पूरा गर्नुहोस्</button>
      </div>
    </form>
    <!-- ADMIN FORM END -->

  </div>
</div>

<script>
// Map doctors to batch numbers
const doctorBatchMap = {
    "डा. प्रतिभा शर्मा": "P250600170",
    "डा. यक राज भण्डारी": "SB251128280"
};

function setDoctor(name, btn) {
    document.getElementById('doctor_name').value = name;

    // set batch number automatically
    const batchInput = document.querySelector('input[name="batch_no"]');
    batchInput.value = doctorBatchMap[name] || "";

    // highlight selected doctor
    document.querySelectorAll('.doctor-select').forEach(b => b.classList.remove('active-doctor'));
    btn.classList.add('active-doctor');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
