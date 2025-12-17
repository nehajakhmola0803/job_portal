<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'jobseeker') {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$applications = $conn->query("
    SELECT applications.*, jobs.title 
    FROM applications 
    JOIN jobs ON applications.job_id = jobs.id 
    WHERE applications.user_id = $user_id
");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Applications</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container mt-5">
    <h3 class="mb-4">My Applications</h3>

    <table class="table table-bordered">
        <thead>
    <tr>
        <th>Job Title</th>
        <th>Status</th>
        <th>Applied Date</th>
        <th>Action</th> <!-- new column -->
    </tr>
</thead>


        <tbody>

        <?php while ($app = $applications->fetch_assoc()): ?>
        <tr>
    <td><?php echo htmlspecialchars($app['title']); ?></td>

    <td class="<?php
        if ($app['status'] === 'Applied') {
            echo 'status-applied';
        } elseif ($app['status'] === 'Accepted') {
            echo 'status-accepted';
        } else {
            echo 'status-rejected';
        }
    ?>">
        <?php echo htmlspecialchars($app['status']); ?>
    </td>

    <td><?php echo $app['applied_at']; ?></td>

    <!-- Action column -->
    <td>
        <a href="delete_application.php?id=<?php echo $app['id']; ?>" 
           class="btn btn-danger btn-sm"
           onclick="return confirm('Are you sure you want to delete this application?');">
           Delete
        </a>
    </td>
</tr>

        <?php endwhile; ?>

        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

</body>
</html>
