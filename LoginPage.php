<?php include('server.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Swornabindu Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to bottom, #eef3ff, #dde7ff);
      height: 100vh;
      font-family: 'Noto Sans Devanagari', 'Segoe UI', sans-serif;
      font-size: 13px;
    }
    .login-card {
      width: 400px;
      border-radius: 15px;
    }
    .form-control:focus {
      border-color: gray;
      box-shadow: 0 0 0 0.2rem rgba(128, 128, 128, 0.25);
    }
    .logo {
      width: 90px;
      height: 90px;
      object-fit: contain;
    }
  </style>
</head>

<body class="d-flex justify-content-center align-items-center">

  <div class="card shadow login-card p-4">

    <!-- Logo Centered -->
    <!-- <div class="text-center mb-3">
      <img src="logo.jpg" alt="Swornabindu Logo" class="logo">
    </div> -->

    <h3 class="text-center text-primary mb-3">Swornabindu Login</h3>

    <!-- Display Errors -->
    <?php if (count($errors) > 0): ?>
      <div class="alert alert-danger py-2">
        <?php foreach ($errors as $error): ?>
          <p class="m-0"><?php echo $error; ?></p>
        <?php endforeach ?>
      </div>
    <?php endif ?>

    <form method="post" action="LoginPage.php">

      <!-- Username -->
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <!-- Login Button -->
      <button type="submit" name="login_user" class="btn btn-primary w-100">Login</button>

      <p class="text-center mt-3">
        Don't have an account? <a href="Registration.php">Register Here</a>
      </p>

    </form>

  </div>

</body>
</html>
