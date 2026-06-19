
<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])){
            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-xl shadow-lg w-96">
    <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required class="w-full p-2 border rounded mb-3">
        <input type="password" name="password" placeholder="Password" required class="w-full p-2 border rounded mb-3">
        <button type="submit" name="login" class="w-full bg-green-500 text-white p-2 rounded">Login</button>
    </form>
    <p class="mt-3 text-center">Belum punya akun? <a href="register.php" class="text-blue-500">Register</a></p>
</div>
</body>
</html>