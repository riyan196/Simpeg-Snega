<?php
session_start();
require '../includes/db.php'; // Impor koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk mengambil data pengguna berdasarkan username
    $query = $db->prepare("SELECT * FROM users WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password
    if ($user && md5($password) === $user['password']) {
        $_SESSION['username'] = $user['username']; // Username
        $_SESSION['nama'] = $user['nama']; // Nama pengguna
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container-fluid flex-grow-1 d-flex align-items-center">
        <div class="row w-100 shadow rounded overflow-hidden">
            <div class="col-md-6 bg-white p-5">
                <div class="text-center mb-4">
                <img src="https://i.imgur.com/9GtdKZc.png" alt="Logo">
                    <h2 class="mt-2">SIMPEG SNEGA</h2>
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text" id="username" name="username" class="form-control" required
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Masukkan username Anda">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="loginButton">
                        <span id="buttonText">Login</span>
                        <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </form>
                <div class="text-center mt-3">
                    <a href="#" class="text-decoration-none">Lupa Password?</a> | 
                    <a href="#" class="text-decoration-none">Buat Akun</a>
                </div>
            </div>
            <div class="col-md-6 d-none d-md-flex bg-primary text-white flex-column justify-content-center align-items-center p-5">
                <h2 class="mb-3">Selamat Datang di Sistem Informasi</h2>
                <p class="text-center">Sistem ini dirancang untuk mempermudah pengelolaan data pengguna dengan fitur canggih yang aman dan mudah digunakan.</p>
                <ul class="list-unstyled text-start">
                    <li><i class="fas fa-check-circle"></i> Keamanan data terjamin</li>
                    <li><i class="fas fa-check-circle"></i> Akses mudah dan responsif</li>
                    <li><i class="fas fa-check-circle"></i> Tampilan yang modern</li>
                </ul>
            </div>
        </div>
    </div>
    <footer class="bg-dark text-grey text-center py-3 mt-auto">
        <p>&copy; 2024 Riyan Heriyanto | Simpeg Snega, SMP Negeri 3 Jakarta. All Rights Reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordField = document.querySelector("#password");
        togglePassword.addEventListener("click", function () {
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;
            this.innerHTML = type === "password" ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        const darkModeToggle = document.getElementById("darkModeToggle");
        darkModeToggle.addEventListener("click", function () {
            document.body.classList.toggle("dark-mode");
            document.querySelector("form").classList.toggle("dark-mode");
            document.querySelector(".bg-primary").classList.toggle("dark-mode");
        });

        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.getElementById("loginButton").addEventListener("click", function () {
            document.getElementById("buttonText").classList.add("d-none");
            document.getElementById("spinner").classList.remove("d-none");
        });
    </script>
</body>
</html>
