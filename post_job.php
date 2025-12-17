<?php
session_start();
include 'connection.php';
if($_SESSION['role'] != 'employer') die("Access Denied");

if(isset($_POST['post'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $loc = $_POST['location'];
    $skills = $_POST['skills'];
    $employer_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO jobs (employer_id,title,description,location,skills) VALUES (?,?,?,?,?)");
    $stmt->bind_param("issss",$employer_id,$title,$desc,$loc,$skills);
    $stmt->execute();
    $success = "Job Posted Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post Job</title>
    <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container mt-5">
    <h2>Post a Job</h2>
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post">
        <div class="mb-3"><input type="text" name="title" placeholder="Job Title" class="form-control" required></div>
        <div class="mb-3"><textarea name="description" placeholder="Job Description" class="form-control" required></textarea></div>
        <div class="mb-3"><input type="text" name="location" placeholder="Location" class="form-control" required></div>
        <div class="mb-3"><input type="text" name="skills" placeholder="Skills Required" class="form-control"></div>
        <button class="btn btn-primary" name="post">Post Job</button>
    </form>
    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
