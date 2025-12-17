<?php
session_start();                 // Start the session
include 'connection.php';        // Connect to the database

// Only logged-in jobseekers can delete their own applications
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'jobseeker') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $app_id = intval($_GET['id']);         // Application ID from URL
    $user_id = $_SESSION['user_id'];       // Logged-in user ID

    // Get the resume file name (if exists)
    $res = $conn->query("SELECT resume FROM applications WHERE id=$app_id AND user_id=$user_id");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $resume_path = "resumes/" . $row['resume'];

        // Delete the resume file if it exists
        if (file_exists($resume_path)) {
            unlink($resume_path);
        }

        // Delete the application record from the database
        $stmt = $conn->prepare("DELETE FROM applications WHERE id=? AND user_id=?");
        $stmt->bind_param("ii", $app_id, $user_id);
        $stmt->execute();
    }
}

// Redirect back to My Applications page
header("Location: my_applications.php");
exit;
?>
