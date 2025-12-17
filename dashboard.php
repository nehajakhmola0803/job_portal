<?php
// START SESSION (VERY IMPORTANT)
session_start();

// Protect dashboard (no direct access)
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="#">Job Portal</a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <h3 class="mb-4">
        Welcome, <?php echo $_SESSION['name'] ?? 'User'; ?> 👋
    </h3>

    <div class="row g-4">
        <?php if($_SESSION['role'] === 'employer'): ?>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5>Post a Job</h5>
                    <p>Create and manage job listings</p>
                    <a href="post_job.php" class="btn btn-primary">Post Job</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5>View Applications</h5>
                    <p>Review candidates and update status</p>
                    <a href="view_applications.php" class="btn btn-success">View Applications</a>
                </div>
            </div>

        <?php else: ?>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5>Browse Jobs</h5>
                    <p>Find jobs that match your skills</p>
                    <a href="jobs.php" class="btn btn-primary">View Jobs</a>
                </div>
            </div>

            <div class="col-md-6">
                <div class="dashboard-card">
                    <h5>My Applications</h5>
                    <p>Track application status</p>
                    <a href="my_applications.php" class="btn btn-success">My Applications</a>
                </div>
            </div>

        <?php endif; ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
