<?php
session_start();
include 'connection.php';
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if($result && password_verify($password,$result['password'])){
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];
        $_SESSION['name'] = $result['name'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid Email or Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Job Portal</title>
   <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- Custom CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center">Job Portal Login</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="post" class="w-50 mx-auto">
        <div class="mb-3">
            <input type="email" name="email" placeholder="Email" class="form-control" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" placeholder="Password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" name="login">Login</button>
        <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register</a></p>
    </form>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
