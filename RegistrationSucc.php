<?php
$server = mysqli_connect("localhost","root","","swornabindu");
if(!$server){
  die("DB connection failed");
}
if(!isset($_GET['id'])){
  die("Invalid access");
}
$id = (int)$_GET['id'];
$result = mysqli_query(
  $server, "SELECT full_name, age, district, qr_image FROM full_registration WHERE id = $id"
);
$data = mysqli_fetch_assoc($result);
if(!$data){
  die("Record not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration Success</title> 

  <!-- Bootstrap Icons CSS -->
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
  />
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>

<style>
  body {
    background: #e5fff5;
    font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
    font-size: 12px;
    margin: 0;
    padding: 0;
  }

  .main-box {
    background: white;
    border-radius: 18px;
    padding-top: 24px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 600px;
    text-align: center;
    margin: 120px auto 20px auto; /* space from fixed navbar */
  }

  .section-header {
    background-color: #32a852;
    color: white;
    height: 150px;
  }

  .info-box {
    background-color: #cceccc;
    border: 1px solid green;
    border-radius: 10px;
    margin: 20px;
    color: green;
    padding: 15px;
    height: 150px;
  }

  button a {
    text-decoration: none;
  }

  @media (max-width: 576px) {
    .main-box {
      margin: 140px 10px 10px 10px; /* maintain spacing on mobile */
      padding: 15px;
    }
    button {
      width: 100%;
      justify-content: center;
    }
    .d-flex.gap-3.flex-wrap button {
      width: 100%;
      justify-content: center;
    }
  }
</style>

<body>
  <!-- Fixed Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="HomePage.php"> <i class="bi bi-house"></i> गृहपृष्ठ</a></li>
          <li class="nav-item"><a class="nav-link" href="Register.php"> <i class="bi bi-plus-circle me-2"></i> नयाँ दर्ता</a></li>
          <li class="nav-item"><a class="nav-link" href="#"> <i class="bi bi-graph-up-arrow"></i> स्क्रिनिङ</a></li>
          <li class="nav-item"><a class="nav-link" href="#"> <i class="bi bi-database"></i> डाटा सिंक </a></li>
        </ul>
      </div>

      <!-- Profile Dropdown -->
      <div class="dropdown ms-3">
        <button class="btn btn-light border rounded-pill px-3 dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
          <span class="me-2"></span> Hari Rijal
        </button>

        <ul class="dropdown-menu shadow p-3" style="width: 250px;">
          <li class="fw-bold"> <i class="bi bi-person"></i> Hari Rijal</li>
          <li class="text-muted">@haririjal</li>
          <li class="small mt-1">जिल्ला: दाङ</li>
          <li><hr></li>
          <li><a class="text-danger fw-bold text-decoration-none" href="#">↩️  लागआउट</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="main-box success-card">
    <div class="section-header text-white p-3 rounded-3 mb-4">
      <span class="done-symbol">
        <i class="bi bi-check2-circle" style="font-size: 60px"></i>
      </span>
      <br />
      दर्ता सफल भयो! <br />
      Registration Successful
    </div>

    <!-- qr images -->
     <div class="text-center my-4">
      <p class="fw-bold">QR Code</p>
      <img 
    src="images/<?php echo htmlspecialchars($data['qr_image']); ?>" 
    width="200"
    style="border:5px solid #32a852; padding:10px; background:white;"
  >
     </div>

    <div class="p-4 text-center">
      <p class="fw-bold" style="font-size: 20px"><?php echo htmlspecialchars($data['full_name']); ?> को दर्ता सम्पन्न भयो</p>
      <p>स्वर्णविन्दु प्राशन कार्यक्रममा सफलतापूर्वक दर्ता गरिएको छ।</p>

      <!-- Info box -->
      <div class="info-box text-start mx-auto mt-3">
        <div class="row">
          <div class="col-md-6 col-6">
            <div class="row mb-2">
              <div class="col-4 ">दर्ता:</div>
              <div class="col-8"><?php echo htmlspecialchars($data['full_name']);?></div>
            </div>
            <div class="row mb-2">
              <div class="col-4 ">उमेर (Month):</div>
              <div class="col-8"><?php echo htmlspecialchars ($data['age']); ?></div>
            </div>
          </div>

          <div class="col-md-6 col-6">
            <div class="row mb-2">
              <div class="col-4">मिति:</div>
              <div class="col-8"><?php echo date("Y-m-d"); ?></div>
            </div>
          </div>
        </div>
      </div>



      <!-- Buttons -->
      <div class="text-center mt-4">
        <button class="px-4 py-2 mb-4" style="font-size: 16px; border-radius: 6px; background-color: black;">
          <a href="#" style="color: white"> Online - Database मा हेर्नुहोस् </a>
        </button>

        <hr class="mt-3 mb-4" style="width: 85%; margin-left:auto; margin-right:auto; border-color:#ddd;">

        <div class="d-flex justify-content-center gap-3 flex-wrap mb-4">
          <button class="btn btn-outline-secondary d-flex align-items-center px-4 py-2" style="border-radius: 6px;">
            <i class="bi bi-download me-2"></i>
            <a href="#" style="color: inherit"> प्रमाणपत्र डाउनलोड </a>
          </button>

          <button class="d-flex align-items-center px-4 py-2" style="border-radius: 6px; color: white; background-color: black;">
            <i class="bi bi-plus-circle me-2"></i>
            <a href="Form.php" style="color: white;"> नयाँ दर्ता </a>
          </button>
        </div>

        <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
          <button class="btn btn-light border px-4 py-2">
            <a href="HomePage.php" style="text-decoration:none; color:inherit;"> <i class="bi bi-download"></i> होम पेज / Pre Registered Entry</a>
          </button>

          <button class="btn btn-light border px-4 py-2">
            <a href="#" style="text-decoration:none; color:inherit;"> <i class="bi bi-person-add"></i> दर्ता सूची</a>
          </button>

          <button class="btn btn-light border px-4 py-2">
            <a href="#" style="text-decoration:none; color:inherit;"> <i class="bi bi-file-earmark-fill"></i> रिपोर्ट</a>
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
