<?php
session_start();
include 'connection.php';

if($_SESSION['role'] != 'jobseeker') die("Access Denied");

$success = $error = '';

if(isset($_POST['apply'])){
    $job_id = $_POST['job_id'];
    $user_id = $_SESSION['user_id'];

    // Candidate details
    $name = $_POST['name'];
    $experience = $_POST['experience'];
    $current_ctc = $_POST['current_ctc'];
    $expected_ctc = $_POST['expected_ctc'];
    $skills = $_POST['skills'];

    // Resume upload
    if(isset($_FILES['resume']) && $_FILES['resume']['error'] == 0){
        $file_name = $_FILES['resume']['name'];
        $file_tmp = $_FILES['resume']['tmp_name'];

        $file_name = preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $file_name);
        $allowed_ext = ['pdf','doc','docx'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(!in_array($file_ext,$allowed_ext)){
            $error = "Only PDF, DOC, or DOCX files are allowed!";
        } else {
            $target_dir = "resumes/";
            if(!is_dir($target_dir)) mkdir($target_dir,0777,true);

            $file_name_only = pathinfo($file_name, PATHINFO_FILENAME);
            $target_file = $target_dir . $file_name_only . "." . $file_ext;
            $counter = 1;
            while(file_exists($target_file)){
                $target_file = $target_dir . $file_name_only . "_".$counter.".".$file_ext;
                $counter++;
            }

            if(move_uploaded_file($file_tmp, $target_file)){
                $resume_file = basename($target_file);

                $stmt = $conn->prepare("INSERT INTO applications (job_id,user_id,name,experience,current_ctc,expected_ctc,skills,resume) VALUES (?,?,?,?,?,?,?,?)");
                $stmt->bind_param("iissssss",$job_id,$user_id,$name,$experience,$current_ctc,$expected_ctc,$skills,$resume_file);
                $stmt->execute();
                $success = "Applied Successfully!";
            } else {
                $error = "Failed to upload resume!";
            }
        }
    } else {
        $error = "Please select a resume file!";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Apply Job</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Apply for Job</h2>

    <?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="job_id" value="<?php echo isset($_GET['job_id']) ? $_GET['job_id'] : ''; ?>">

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Experience</label>
        <input type="text" name="experience" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Current CTC</label>
        <input type="text" name="current_ctc" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Expected CTC</label>
        <input type="text" name="expected_ctc" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Skills</label>
        <textarea name="skills" class="form-control" rows="3" required></textarea>
    </div>

    <div class="mb-3">
        <label>Upload Resume (PDF/DOC/DOCX)</label>
        <input type="file" name="resume" class="form-control" required>
    </div>

    <button class="btn btn-primary" name="apply">Apply</button>
</form>


    <a href="jobs.php" class="btn btn-secondary mt-3">Back to Jobs</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
