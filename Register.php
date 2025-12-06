<?php
// ========== DATABASE CONNECTION ==========
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "swornabindu";
$table      = "registration";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ========== FORM SUBMISSION ==========
if ($_SERVER ['REQUEST_METHOD']=="POST"){
    $district        = $_POST['district'];
    $municipality    = $_POST['municipality'];
    $child_name      = $_POST['child_name'];
    $child_gender    = $_POST['child_gender'];
    $child_age_year  = $_POST['child_age_year'];
    $child_age_month = $_POST['child_age_month'];
    $father_name     = $_POST['father_name'];
    $mother_name     = $_POST['mother_name'];
    $contact_number  = $_POST['contact_number'];

    // age validation
    $total_months = ($child_age_year*12)+$child_age_month;
    if($total_months < 6 || $total_months>60){
      echo "<script>alert('Child age must be between 6 months and 5 years.'); window.history.back();</script>";
      exit();
    }

    // Insert Query
    $sql = "INSERT INTO registration 
            (district, municipality, child_name, child_gender, child_age_year, child_age_month, father_name, mother_name, contact_number)
            VALUES 
            ('$district', '$municipality', '$child_name', '$child_gender', '$child_age_year', '$child_age_month', '$father_name', '$mother_name', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        header("Location: Register1.html"); 
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
  }
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
            font-size: 12px;
        }

        .main-box {
            max-width: 1000px;
            margin: 20px auto;
            border-radius: 18px;
            background-color: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            padding: 24px 28px 28px;
        }

        .quick-bar {
            background-color: #bee0f5;
            border-radius: 12px;
            border: 1px solid #afdbf3;
        }

        .custom-textarea:focus {
            border-color: gray;
            box-shadow: 0 0 0 0.2rem rgb(101, 102, 104, 0.25);
        }

        .age-wrapper {
            background-color: #f3fff6;
            border: 1px solid rgb(190, 236, 190);
            border-radius: 9px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 18px;
            height: 70px;
        }

        .age-input {
            width: 70px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e5e5;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm position-relative">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
        </div>
    </nav>

    <div class="main-box">

        <form action="" method="POST">

            <!-- Header -->
            <div class="bg-primary text-white p-3 rounded-3 mb-3 d-flex align-items-center gap-2">
                <h4 class="m-0">Child and Guardian Information</h4>
            </div>

            <!-- Quick Registration Bar -->
            <div class="quick-bar d-flex justify-content-between align-items-center px-3 py-2 mb-4">
                <span class="text-primary fs-6">द्रुत दर्ता | Quick Registration</span>
                <span class="badge rounded-pill bg-white text-dark border fs-6">Step 2/3</span>
            </div>

            <div class="container my-4">
                <div class="row g-4">

                    <!-- LEFT SIDE -->
                    <div class="col-md-6">
                        <div class="border rounded p-4 bg-white">

                            <label class="section-title fw-semibold text-primary">बच्चाको विवरण | Child Info</label>

                            <!-- District -->
                            <div class="mt-3">
                                <label class="form-label">District *</label>
                                <input type="text" class="form-control custom-textarea" name="district" value="दाङ" required readonly disabled>
                            </div>

                            <!-- Municipality -->
                            <div class="mt-3">
                                <label class="form-label">Municipality *</label>
                                <select class="form-select custom-textarea" name="municipality" required>
                                    <option value="Ghorahi">घोराही उपमहानगरपालिका</option>
                                    <option value="Tulsipur">तुलसीपुर उपमहानगरपालिका</option>
                                    <option value="Lamahi">लमही नगरपालिका</option>
                                    <option value="Gadhawa">गढवा गाउपालिका</option>
                                    <option value="Rajpur">राजपुर गाउपालिका</option>
                                    <option value="Shantinagar">शान्तीनगर गाउपालिका</option>
                                    <option value="Dangisharan">दंगीशरण गाउपालिका</option>
                                    <option value="Banglachuli">बंगलाचुली गाउपालिका</option>
                                    <option value="Babai">बबै गाउपालिका</option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <label class="mt-4 mb-1"><b>लिङ्ग *</b></label>
                            <div class="d-flex gap-3">
                                <label class="btn btn-outline-dark flex-fill">
                                    <input type="radio" name="child_gender" value="Male" required class="me-2" /> पुरुष | Male
                                </label>

                                <label class="btn btn-outline-dark flex-fill-primary">
                                    <input type="radio" name="child_gender" value="Female" class="me-2" /> महिला | Female
                                </label>
                            </div>

                            <!-- Child Name -->
                            <div class="mt-4">
                                <label class="form-label"><b>बच्चाको नाम *</b></label>
                                <input type="text" class="form-control custom-textarea" name="child_name" required placeholder="बच्चाको नाम लेख्नुहोस्">
                            </div>

                            <!-- Age -->
                            <div class="mt-4">
                                <label class="form-label"><b>बच्चाको उमेर *</b></label>

                                <div class="age-wrapper mt-1">
                                    <div class="d-flex align-items-center">
                                        <input type="number" class="form-control age-input" name="child_age_year" value="0" min="0" required>
                                        <span class="ms-2">वर्ष</span>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <input type="number" class="form-control age-input" name="child_age_month" value="0" min="0" max="11" required>
                                        <span class="ms-2">महिना</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6">
                        <div class="border rounded p-4 bg-white">

                            <label class="section-title text-primary fw-semibold">अभिभावक विवरण | Guardian Info</label>

                            <!-- Father Name -->
                            <div class="mt-4">
                                <label class="form-label">बुबाको नाम</label>
                                <input type="text" class="form-control custom-textarea" name="father_name" placeholder="बुबाको नाम">
                            </div>

                            <!-- Mother Name -->
                            <div class="mt-4">
                                <label class="form-label">आमाको नाम</label>
                                <input type="text" class="form-control custom-textarea" name="mother_name" placeholder="आमाको नाम">
                            </div>

                            <!-- Contact -->
                            <div class="mt-4">
                                <label class="form-label">सम्पर्क नम्बर *</label>
                                <div class="input-group">
                                    <span class="input-group-text">+977</span>
                                    <input type="text" class="form-control custom-textarea" name="contact_number" required placeholder="9800000000">
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- NEXT BUTTON -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-dark px-4 py-2">अर्को चरण | Next Step</button>
                </div>

            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
