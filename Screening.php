<?php
$conn = new mysqli("localhost", "root", "", "swornabindu");
if ($conn->connect_error) {
    die("Connection failed");
}

$patient = null;

if (isset($_GET['search'])) {

    $search = trim($_GET['search']);

    // remove country code if typed
    $search = ltrim($search, '+');

    if (ctype_digit($search)) {

        // Try contact number first
        $stmt = $conn->prepare("
            SELECT * FROM full_registration
            WHERE contact_number = ?
            LIMIT 1
        ");
        $stmt->bind_param("s", $search);
        $stmt->execute();

        $patient = $stmt->get_result()->fetch_assoc();

        // If not found, try ID
        if (!$patient) {
            $stmt = $conn->prepare("
                SELECT * FROM full_registration
                WHERE id = ?
                LIMIT 1
            ");
            $stmt->bind_param("i", $search);
            $stmt->execute();
            $patient = $stmt->get_result()->fetch_assoc();
        }
    }
}
?>


<?php if ($patient): ?>
<div class="card shadow-sm mt-3">
    <div class="card-body">

        <h6 class="fw-bold mb-2">Patient Details</h6>

        <p><strong>Name:</strong> <?= htmlspecialchars($patient['full_name']) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($patient['gender']) ?></p>
        <p><strong>Month:</strong> <?= htmlspecialchars($patient['age']) ?></p>
        <p><strong>District:</strong> <?= htmlspecialchars($patient['district']) ?></p>
        <p><strong>Contact:</strong> <?= htmlspecialchars($patient['contact_number']) ?></p>

        <?php if (!empty($patient['qr_image'])): ?>
            <img src="images/<?= $patient['qr_image'] ?>" width="120">
        <?php endif; ?>

    </div>
</div>
<?php elseif (isset($_GET['search'])): ?>
<div class="alert alert-warning mt-3">
    No patient found.
</div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Screening</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
            font-size: 12px;
        }
        .form-control:focus {
            color: gray !important;
            border-color: #656668;
            border: none;
            box-shadow: 0 0 0 0.2rem rgba(101, 102, 104, 0.25) !important;
        }
    </style>
</head>

<body class="bg-light">

<div class="container py-4">

    <!-- Back Button + Title in SAME LINE -->
    <div class=" d-flex mb-2">
        
        <!-- Back Button -->
        <a href="HomePage.php" class="btn btn-outline-secondary">
            ← Back to Home
        </a>

        <!-- Page Title -->
        <h3 class="fw-bold mb-0">स्क्रिनिङ | Patient Screening</h3>
    </div>

    <!-- Subtitle -->
    <p class="text-muted">Find patients and conduct follow-up screenings</p>

    <!-- Search Card -->
    <div class="card shadow-sm mt-3">
        <div class="card-body">

            <p class="fw-bold mb-1">विरामी खोज्नुहोस् | Find Patient</p>
            <p class="text-muted mb-3">Search for a patient using Unique ID or Contact Number</p>

            <!-- Search Row -->
            <div class="d-flex flex-wrap gap-2">
                <form  method="GET" action="Screening.php" class="d-flex flex-wrap gap-2">

                <!-- Input Field -->
                <div class="flex-grow-1">
                    <input 
                        name="search"
                        type="text"
                        class="form-control"
                        placeholder="Enter Unique ID or contact number">
                </div>

                <!-- Search Button -->
                <div>
                    <button type="submit" class="btn btn-dark px-4" 
                   
                    >Search</button>
                </div>
                </form>

            </div>

            <p class="text-muted small mt-2">
                Tip: You can type only the number and press Tab to auto-fill the full REG ID (LDT-XXXX).
                You can also search using the contact number.
            </p>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
