<?php?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Data Synchronization | Swarnabindu</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    <style>
      body {
        font-family: "Noto Sans Devanagari", "Segoe UI", sans-serif;
        font-size: 12px;
      }
      .card {
        height: 250px;
      }
      .card1{
        height: 180px;
      }
      .card-stat {
        min-height: 120px;
      }
      .sync-online {
        color: #28a745;
        font-weight: 600;
      }
    </style>
  </head>
  <body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white shadow-sm px-4">
      <a class="navbar-brand fw-bold" href="#">स्वर्णबिन्दु</a>
      <div class="ms-auto d-flex align-items-center">
        <span class="me-3 fw-semibold">User</span>
        <img
          src="https://via.placeholder.com/32"
          class="rounded-circle"
          alt=""
        />
      </div>
    </nav>

    <div class="container py-4">
      <!-- Back Button + Header -->
      <div class="d-flex align-items-center mb-3">
        <a href="#" class="btn btn-outline-secondary me-1" style="color: black"
          >&larr; Back to Home</a
        >
        <h2 class="fw-bold mb-0">Data Synchronization</h2>
        <span
          class="ms-auto badge bg-success p-2"
          style="color: #28a745; color: white"
          >Online</span
        >
      </div>

      <p class="text-muted">Manage offline data and sync with server</p>

      <div class="row g-4">
        <!-- Sync Controls -->
        <div class="col-lg-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <p class="fw-bold">Sync Controls</p>
              <br />
              <p>Manage data synchronization</p>

              <button class="btn btn-dark btn-sm px-2 py-1 w-100 mb-2">
                Manual Sync
              </button>
              <button class="btn btn-danger btn-sm px-2 py-1 w-100 mb-3">
                Clear All Data
              </button>

              <ul class="small text-muted">
                <li>Manual sync uploads all pending data</li>
                <li>Auto-sync happens when you go online</li>
                <li>Clear data removes all local storage</li>
              </ul>
            </div>
          </div>

          <!-- Sync Status -->
          <div class=" card card1 shadow-sm mt-2">
            <div class="card-body">
              <p class="fw-bold">Sync Status</p>
              <div class="d-flex justify-content-between">
                <p class="mb-1">Connection:</p>
                <span class="badge bg-dark">Online</span>
              </div>

              <div class="d-flex justify-content-between">
                <p class="mb-1">Pending Items:</p>
                <span class="badge bg-light" style="color: black">0</span>
              </div>

              <div class="d-flex justify-content-between">
                <p>Last Sync:</p>
                <em class="text-secondary">Never</em>
              </div>
              <button class="btn btn-secondary btn-sm w-100" disabled>
                All Synced
              </button>
            </div>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="col-lg-9">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="card card-stat shadow-sm text-center p-3">
                <h6 class="text-muted mb-1">Total Patients</h6>
                <h2 class="fw-bold">0</h2>
                <div class="small text-muted">Stored locally</div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card card-stat shadow-sm text-center p-3">
                <h6 class="text-muted mb-1">Pending Sync</h6>
                <h2 class="text-warning fw-bold">0</h2>
                <div class="small text-muted">Need to sync</div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card card-stat shadow-sm text-center p-3">
                <h6 class="text-muted mb-1">Synced</h6>
                <h2 class="text-success fw-bold">0</h2>
                <div class="small text-muted">Successfully synced</div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="card card-stat shadow-sm text-center p-3">
                <h6 class="text-muted mb-1">Screenings</h6>
                <h2 class="text-primary fw-bold">0</h2>
                <div class="small text-muted">Pending screenings</div>
              </div>
            </div>
          </div>

          <!-- Patient Data -->
          <div class="card shadow-sm mt-4">
            <div class="card-body">
              <div
                class="d-flex justify-content-between align-items-center mb-3"
              >
                <h5 class="fw-bold mb-0">Patient Data (0)</h5>

                <div>
                  <button class="btn btn-dark btn-sm">All (0)</button>
                  <button class="btn btn-outline-secondary btn-sm">
                    Pending (0)
                  </button>
                  <button class="btn btn-outline-secondary btn-sm">
                    Synced (0)
                  </button>
                </div>
              </div>

              <div class="text-muted py-4 text-center">
                No patient data found. Register some patients to see them here.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
