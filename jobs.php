<?php
session_start();
include 'connection.php';
if($_SESSION['role'] != 'jobseeker') die("Access Denied");

$jobs = $conn->query("SELECT jobs.*, users.name AS employer_name FROM jobs JOIN users ON jobs.employer_id = users.id ORDER BY jobs.posted_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Jobs</title>
    <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container mt-5">
    <h2>Available Jobs</h2>
    <?php while($job = $jobs->fetch_assoc()): ?>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title"><?php echo $job['title']; ?> - <?php echo $job['location']; ?></h5>
            <p class="card-text"><?php echo $job['description']; ?></p>
            <p class="card-text"><strong>Skills:</strong> <?php echo $job['skills']; ?></p>
            <p class="card-text"><strong>Employer:</strong> <?php echo $job['employer_name']; ?></p>
            <a href="apply.php?job_id=<?php echo $job['id']; ?>" class="btn btn-success">Apply</a>
        </div>
    </div>
    <?php endwhile; ?>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
