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

// -------------------------,
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

// If patient not found
if (!$patient) {
    $patient = [
        "name" => "N/A",
        "gender" => "N/A",
        "phone_number" => "N/A",
        "date_of_birth" => "N/A",
        "child_age_year" => 0,
        "child_age_month" => 0
    ];
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

      .left-box {
        background: #eff8fd;
        border: 1px solid #d7e9ff;
        border-radius: 16px;
        padding: 24px;
        height: 410px;
      }

      .dose-box {
        background: #f5fff5;
        border: 1px solid #98fb98;
        border-radius: 16px;
        padding: 20px;
        height: 150px;
      }

      .main-box {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
      }

      .quick-bar {
        background: #f5fff5;
        border-radius: 12px;
        border: 1px solid #d4f4db;
      }

      .first {
        background: rgb(222, 92, 27);
      }

      .button {
        border: 1px solid gray;
        border-radius: 5px;
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
        <li class="nav-item"><a class="nav-link" href="HomePage.html">गृहपृष्ठ</a></li>
        <li class="nav-item"><a class="nav-link" href="Register.html">नयाँ दर्ता</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container py-3">
  <div class="row g-4">

    <!-- LEFT COLUMN -->
    <div class="col-md-4">

      <!-- PATIENT INFO -->
      <div class="left-box mb-3">
        <h5 class="fw-bold mb-4">बिरामीको जानकारी</h5>

        <p class="mb-0">नाम:</p>
        <p class="mb-2"><?php echo $patient["name"]; ?></p>

        <p class="mb-0">उमेर:</p>
        <p class="mb-2">
          <?php echo $patient["child_age_year"]; ?> वर्ष 
          <?php echo $patient["child_age_month"]; ?> महिना
        </p>

        <p class="mb-0">लिङ्ग:</p>
        <span class="badge bg-light text-dark border px-3 py-2">
          <?php echo $patient["gender"]; ?>
        </span>

        <hr />

        <p class="mb-0">फोन:</p>
        <p class="mb-2"><?php echo $patient["phone_number"]; ?></p>

        <p class="mb-0">जन्म मिति:</p>
        <p class="mb-2"><?php echo $patient["date_of_birth"]; ?></p>

      </div>

      <!-- RECOMMENDED DOSE -->
      <div class="dose-box">
        <h6 class="fw-bold mb-3">सिफारिस मात्रा</h6>

        <p class="text-muted mb-1">उमेर समूह: ६–१२ महिना</p>
        <h5 class="fw-bold">1 थोपा ●</h5>
      </div>
    </div>

    <!-- RIGHT COLUMN -->
    <div class="col-md-8">
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

          <div class="doctor-btn d-flex flex-wrap gap-2 mb-2">
            <button type="button" class="btn btn-light button" onclick="setDoctor('डा. सञ्जु भुसाल')">डा. सञ्जु भुसाल</button>
            <button type="button" class="btn btn-light button" onclick="setDoctor('डा. प्रतिभा सेन')">डा. प्रतिभा सेन</button>
            <button type="button" class="btn btn-light button" onclick="setDoctor('डा. सागर पोखरेल')">डा. सागर पोखरेल</button>
            <button type="button" class="btn btn-light button" onclick="setDoctor('डा. प्रितिक्षा के.सी')">डा. प्रितिक्षा के.सी</button>
          </div>

          <input type="hidden" id="doctor_name" name="doctor_name">

          <div class="text-danger">सेवन गर्ने व्यक्तिको नाम आवश्यक छ</div>

          <div class="row mt-3">
            <div class="col-md-6">
              <label class="form-label">ब्याच नम्बर</label>
              <input type="text" class="form-control" name="batch_no" value="SB251128279" />
            </div>

            <div class="col-md-6">
              <label class="form-label">मात्रा (थोपा)</label>
              <input type="number" class="form-control" name="dose" value="1" />
            </div>
          </div>

          <div class="mt-3">
            <label class="form-label">टिप्पणी</label>
            <textarea class="form-control" rows="3" name="note"></textarea>
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
            <a href="Register.html" class="btn btn-light border">← पछाडि</a>
            <button class="btn btn-dark border" type="submit">दर्ता पूरा गर्नुहोस्</button>
          </div>

        </form>
        <!-- ADMIN FORM END -->

      </div>
    </div>
  </div>
</div>

<script>
function setDoctor(name) {
    document.getElementById('doctor_name').value = name;
}
</script>
</body>
</html>
