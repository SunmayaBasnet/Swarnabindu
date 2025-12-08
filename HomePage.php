<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swarnabindu Prashan Program</title>

  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
  />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

  <style>
    body{
    font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
    font-size: 12px;;
    background-color:#eff8fd;
    margin: 5px;

    }

    .container{
       /* background-color:#eff8fd; */
      margin-top: 20px;
    }
    .card1{
      color:  #0000FF;
      background-color: white;
      border-radius: 10px;
      border: 1px solid  #0000FF;
      height: 180px;
      width: 280px;
    }
    .card:hover{
      transition: 0.3 ease-in;
    }
    .card2{
      color: #38b874;
       border: 1px solid #38b874;
       background-color: white;
       border-radius: 10px;
       height: 180px;
      width: 280px;
    }
    .card3{
      background-color: white;
      color: #8E4585;
       border-radius: 10px;
       border: 1px solid #8E4585;
      height: 180px;
      width: 280px;
    }
    .card4{
      background-color: white;
      color: #E97451;
       border-radius: 10px;
       border: 2px solid #E97451;
      height: 180px;
      width: 280px;
    }
    .card1, .card2, .card3, .card4{
      transition: all 0.5s ease-in-out;
    }
    .card1:hover, .card2:hover, .card3:hover, .card4:hover{
      transform: translateY(-8px);
      /* box-shadow: 0 8px 20px rgba(0,0,0,0.15); */
      cursor: pointer;
    }
    .box{
      transition: 0.3s ease-out;
    }
    .box:hover{
      transform: translateY(-8px);
    }
    li{
      list-style: none;
    }
  </style>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm position-relative">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="HomePage.pho"> <i class="bi bi-house"></i> गृहपृष्ठ</a></li>
        <li class="nav-item"><a class="nav-link" href="Register.php"> <i class="bi bi-plus-circle me-2"></i> नयाँ दर्ता</a></li>
        <li class="nav-item"><a class="nav-link" href="Screening.html"> <i class="bi bi-graph-up-arrow"></i> स्क्रिनिङ</a></li>
        <li class="nav-item"><a class="nav-link" href="DataSink.html"> <i class="bi bi-database"></i> डाटा सिंक </a></li>
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

<div class="container py-2 text-center">
   <input type="radio" class="badge bg-success mb-2" style="color: green;">
  <label for="Online" class="fw-bold">Online</label>
 
  <!-- <span class="badge bg-success mb-2">Online</span> -->
  <h2 class="fw-bold">स्वर्णबिन्दु प्रशान कार्यक्रम</h2>
  <h4 class="text-primary">Swarnabindu Prashan Program</h4>
  <p>बालबालिकाको स्वास्थ्य र प्रतिरोध क्षमतामा वृद्धि गर्नका लागि आयुर्वेदिक स्वर्णबिन्दु प्रशान कार्यक्रम | Ayurvedic Swarnabindu Prashan program for children health and immunity enhancement</p>
</div>

<div class="container mb-4">
  <div class="row g-4">

    <div class="col-md-3">
      <div class="card1 shadow-sm p-3">
        <div class="d-flex justify-content-between align-items-center p-3">
          <p>कुल बिरामी | Total Patients</p>
          <span class="fs-3"><i class="bi bi-people-fill"></i></span>
        </div>
        <h1 class="text-primary">10692</h1>
        <p class>Registered children</p>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card2 shadow-sm p-3">

        <div class="d-flex justify-content-between align-items-center p-3">
          <p>आजका दर्ता | Todays Registrations</p>
          <span class="fs-3"><i class="bi bi-calendar4"></i></span>
        </div>
        <div  class=" d-flex justify-content-between align-items-center p-3 mb-4 ">
          <div>
            <h1 class="text-success">0</h1>
            <p>New registrations today</p>
          </div>
          <div>
          <h1 class="text-dark">0</h1>
          <p>Self registered</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card3 shadow-sm p-3">

        <div class="d-flex justify-content-between align-items-center p-3">
        <p>कुल स्क्रिनिङ | Total Screenings</p>
        <span class="fs-3"><i class="bi bi-activity"></i></span>
        
        </div>
        <h1 class="text-purple">0</h1>
        <p>Health screenings completed</p>

      </div>
    </div>

    <div class="col-md-3">
      <div class="card4 shadow-sm p-3 ">
        <div class="d-flex justify-content-between p-3  align-items-center">
          <p>लिङ्ग वितरण | Gender Distribution</p>
          <span class="fs-3"><i class="bi bi-graph-up-arrow"></i></span>
        </div>
        
        <div class="d-flex justify-content-around">
          <div>
            <h2 class="text-primary mb-0">5915</h2>
            <small class="text-primary">पुरुष | Male</small>
          </div>
          <div>
            <h2 class="text-danger mb-0">4777</h2>
            <small class="text-danger ">महिला | Female</small>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="container pb-5">
  <div class="row g-2 mb-3">

    <div class=" box col-md-4">
      <div class="card shadow-sm p-4 text-center">
        <span class="fs-1 text-success mb-4"><i class="bi bi-person-plus"></i></span>
        <h5 style="color: green;">नयाँ दर्ता | New Registration</h5>
        <p>Register a new child for the Swarnabindu program</p>
        <a href="#" class="btn btn-success w-100"> <span class="g-1"><i class="bi bi-person-plus g-4"></i></span>नयाँ दर्ता | New Registration</a>
      </div>
    </div>

    <div class=" box col-md-4 mb-3">
      <div class="card shadow-sm p-4 text-center">
        <span class="fs-1 text-primary mb-4"><i class="bi bi-droplet-fill"></i></span>
        <h5 class="text-primary">स्वर्णबिन्दु प्रशान | Swarnabindu Prashan</h5>
        <p>Administer Swarnabindu drops to registered children</p>
        <a href="#" class="btn btn-primary w-100"><span><i class="bi bi-droplet-fill"></i></span> स्वर्णबिन्दु प्रशान | Swarnabindu Prashan</a>
      </div>
    </div>

    <div class=" box col-md-4">
      <div class="card shadow-sm p-4 text-center">
        <span class="fs-1 text-success mb-4"><i class="bi bi-search"></i></span>
        <h5 class="text-success">Self Registered</h5>
        <p>Search and view self-registered users</p>
        <a href="#" class="btn btn-success w-100"> <span><i class="bi bi-search"></i></span>Self Registered</a>
      </div>
    </div>

  </div>

<!-- Data Sync & Emergency Section -->
<div class="container mb-5">
  <div class="row g-4">
    <div class=" box col-md-6">
      <div class="card shadow-sm p-4 text-center border-primary">
        <span class="fs-1 text-primary mb-4"><i class="bi bi-database"></i></span>
        <h5 class="text-primary">डाटा सिंक | Data Sync</h5>
        <p>Synchronize offline data with server</p>
        <a href="#" class="btn btn-primary w-100"> <span><i class="bi bi-database"></i></span>डाटा सिंक | Data Sync</a>
      </div>
    </div>
    <div class=" box col-md-6">
      <div class="card shadow-sm p-4 text-center border-danger">
        <span class="fs-1 text-danger mb-4"><i class="bi bi-shield"></i></span>
        <h5 class="text-danger">आपतकालीन | Emergency</h5>
        <p>Emergency contacts and procedures</p>
      </div>
    </div>
  </div>
</div>

<!-- Program Information Section -->
<div class="container mb-5">
  <div class="card shadow-sm p-4">
    <h4 class="fw-bold text-center mb-4">कार्यक्रम जानकारी | Program Information</h4>
    <div class="row">
      <div class="col-md-6">
        <p class="text-primary fs-6 fw-bold">स्वर्णबिन्दु प्रशानका फाइदाहरु | Benefits</p>
        <ul class="mt-3 none">
          <li> <i class="bi bi-check2-circle text-success fw-bold fs-6"></i> प्रतिरोध क्षमता वृद्धि | Immunity enhancement</li>
          <li> <i class="bi bi-check2-circle text-success fw-bold fs-6"></i> बुद्धि र स्मरण शक्ति विकास | Intelligence & memory development</li>
          <li> <i class="bi bi-check2-circle text-success fw-bold fs-6"></i> पाचन क्रिया सुधार | Digestive improvement</li>
          <li> <i class="bi bi-check2-circle text-success fw-bold fs-6"></i> क्षयरोगसम्बन्धी समस्या कम | Reduced respiratory issues</li>
        </ul>
      </div>
      <div class="col-md-6">
        <p class=" fs-6 fw-bold" style="color: rgb(132, 31, 132);">लक्षित समूह | Target Group</p>
        <ul class="mt-3">
          <li> <i class="bi bi-heart text-danger fw-bold"></i>६ महिनादेखि ५ वर्षसम्मका बालबालिका | Children 6 months to 5 years</li>
          <li> <i class="bi bi-heart text-danger"></i>स्वस्थ बालबालिका | Healthy children</li>
          <li> <i class="bi bi-heart text-danger"></i>नियमित खुराक आवश्यक | Regular doses required</li>
          <li> <i class="bi bi-heart text-danger"></i>पुष्य नक्षत्रमा सेवन उत्तम | Best taken during Pushya Nakshatra</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
