<?php
session_start();
include 'connection.php';
if($_SESSION['role'] != 'employer') die("Access Denied");

$employer_id = $_SESSION['user_id'];
$applications = $conn->query("SELECT applications.*, jobs.title, users.name AS applicant_name FROM applications 
JOIN jobs ON applications.job_id = jobs.id 
JOIN users ON applications.user_id = users.id
WHERE jobs.employer_id=$employer_id ORDER BY applications.applied_at DESC");

if(isset($_GET['action'])){
    $app_id = $_GET['id'];
    $status = $_GET['action'];
    $conn->query("UPDATE applications SET status='$status' WHERE id=$app_id");
    header("Location:view_applications.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Applications</title>
    <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body>
<div class="container mt-5">
    <h2>Applicants</h2>
   <table class="table table-bordered">
    <tr>
        <th>Applicant</th>
        <th>Job Title</th>
        <th>Experience</th>
        <th>Current CTC</th>
        <th>Expected CTC</th>
        <th>Skills</th>
        <th>Resume</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while($app = $applications->fetch_assoc()): ?>
    <tr>
        <td><?php echo $app['applicant_name']; ?></td>
        <td><?php echo $app['title']; ?></td>
        <td><?php echo $app['experience']; ?></td>
        <td><?php echo $app['current_ctc']; ?></td>
        <td><?php echo $app['expected_ctc']; ?></td>
        <td><?php echo $app['skills']; ?></td>
        <td><a href="resumes/<?php echo $app['resume']; ?>" target="_blank">View</a></td>
        <td>
            <?php 
                $status = $app['status'];
                if($status == "Applied") echo "<span class='badge bg-primary'>$status</span>";
                elseif($status == "Accepted") echo "<span class='badge bg-success'>$status</span>";
                else echo "<span class='badge bg-danger'>$status</span>";
            ?>
        </td>
        <td>
            <a href="?id=<?php echo $app['id']; ?>&action=Accepted" class="btn btn-success btn-sm">Accept</a>
            <a href="?id=<?php echo $app['id']; ?>&action=Rejected" class="btn btn-danger btn-sm">Reject</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
