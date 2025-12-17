<?php
include 'connection.php';
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$password,$role);
    $stmt->execute();
    $success = "Registration successful! You can now login.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Job Portal</title>
   <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center">Register</h2>
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post" class="w-50 mx-auto">
        <div class="mb-3"><input type="text" name="name" placeholder="Name" class="form-control" required></div>
        <div class="mb-3"><input type="email" name="email" placeholder="Email" class="form-control" required></div>
        <div class="mb-3"><input type="password" name="password" placeholder="Password" class="form-control" required></div>
        <div class="mb-3">
            <select name="role" class="form-control" required>
                <option value="">Select Role</option>
                <option value="jobseeker">Job Seeker</option>
                <option value="employer">Employer</option>
            </select>
        </div>
        <button class="btn btn-success w-100" name="register">Register</button>
        <p class="mt-3 text-center">Already have an account? <a href="index.php">Login</a></p>
    </form>
</div>

</body>
</html>
