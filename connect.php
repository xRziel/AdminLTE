<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "suparoek";

$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("การเชื่อมต่อผิดพลาด: " . mysqli_connect_error());
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    echo "<script>alert('กรุณากรอกชื่อผู้ใช้และรหัสผ่าน'); window.history.back();</script>";
    exit;
}

$sql = "SELECT * FROM narak WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($password === $row['password']) {
        $_SESSION['username'] = $row['username'];
        header("Location: /036/project1/dist/index.php");
        exit();
    } else {
        echo "<script>alert('รหัสผ่านไม่ถูกต้อง');window.history.back();</script>";
        exit();
    }
} else {
    echo "<script>alert('ไม่พบบัญชีผู้ใช้นี้');window.history.back();</script>";
    exit();
}
mysqli_close($conn);
