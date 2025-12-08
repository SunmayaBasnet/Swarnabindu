<?php include('server.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swornabindu Registration</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    
    body{
          font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
          font-size: 12px;
              }
    input{
          font-size: 10px;
         }
         .form-control:focus{
          color:gray;
         }<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Swornabindu Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{ font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif; font-size:12px; }
    input{ font-size:10px; }
    .form-control:focus{ color:gray; }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header text-center bg-primary text-white">
            <h3>Swornabindu Registration</h3>
          </div>
          <div class="card-body">
            <!-- METHOD and ACTION set; action empty -> submits to same page -->
            <form method="post" action="">
              <!-- show errors (optional) -->
              <?php if(!empty($errors)): ?>
                <div class="alert alert-danger">
                  <?php foreach($errors as $err) echo "<div>".htmlspecialchars($err)."</div>"; ?>
                </div>
              <?php endif; ?>
              <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" name="username" class="form-control" id="fullName" placeholder="Enter your full name" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password_1" class="form-control" id="password1" placeholder="Enter your password" required>
              </div>

              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" name="password_2" class="form-control" id="password2" placeholder="Confirm your password" required>
              </div>

              <div class="d-grid">
                <!-- submit button must have name="reg_user" so server.php detects registration -->
                <button type="submit" name="reg_user" class="btn btn-primary">Register</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            Already have an account? <a href="index.php">Login here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
