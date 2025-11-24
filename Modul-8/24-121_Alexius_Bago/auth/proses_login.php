<?php
session_start();
include "../config/koneksi.php";

$username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username == '' || $password == '') {
    echo "<script>alert('Username dan password wajib diisi!'); window.location='login.php';</script>";
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' LIMIT 1");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($query);

if ($data) {

    $password_db = $data['password'];

    $bcrypt_valid = password_verify($password, $password_db);

    $md5_valid = ($password_db === md5($password));

    if ($bcrypt_valid || $md5_valid) {

        if ($md5_valid) {
            $new_bcrypt = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($koneksi,
                "UPDATE user SET password='" . mysqli_real_escape_string($koneksi, $new_bcrypt) . "' 
                 WHERE id_user=" . $data['id_user']
            );
        }

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama_user'] = $data['nama'];
        $_SESSION['level'] = (int)$data['level'];

        header("Location: ../home.php");
        exit;
    }
}

echo "<script>alert('Username atau password salah!'); window.location='login.php';</script>";
exit;
?>