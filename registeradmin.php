<?php

require_once 'koneksi.php'; 

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $raw_password = $_POST['password'];
    $nama_pengurus = trim($_POST['nama_pengurus']);

    if (empty($username) || empty($raw_password) || empty($nama_pengurus)) {
        $message = "Semua kolom wajib diisi!";
        $message_type = 'error';
    } else {

        $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    
        $check_sql = "SELECT id_admin FROM admin_users WHERE username = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "Username <b>" . htmlspecialchars($username) . "</b> sudah digunakan. Pilih username lain.";
            $message_type = 'error';
        } else {
        
            $insert_sql = "INSERT INTO admin_users (username, password, nama_pengurus) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            
            if ($insert_stmt) {
                $insert_stmt->bind_param("sss", $username, $hashed_password, $nama_pengurus);
                
                if ($insert_stmt->execute()) {
                    $message = "Admin <b>" . htmlspecialchars($username) . "</b> berhasil didaftarkan! Password sudah di-hash.";
                    $message_type = 'success';
                } else {
                    $message = "Gagal mendaftar: " . $insert_stmt->error;
                    $message_type = 'error';
                }
                $insert_stmt->close();
            } else {
                $message = "Error persiapan query: " . $conn->error;
                $message_type = 'error';
            }
        }
        $check_stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Admin Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --color-primary: #1e88e5; 
            --color-success: #4CAF50;
            --color-error: #F44336;
        }
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .register-box { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1); width: 100%; max-width: 450px; }
        .register-box h2 { color: var(--color-primary); margin-bottom: 25px; text-align: center; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .input-group input { width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-size: 1em; }
        .btn-register { width: 100%; padding: 12px; background-color: var(--color-primary); color: white; border: none; border-radius: 6px; font-size: 1.1em; cursor: pointer; transition: background-color 0.3s; margin-top: 15px; }
        .btn-register:hover { background-color: #1565c0; }
        .message { padding: 15px; margin-bottom: 20px; border-radius: 6px; font-weight: 500; text-align: center; }
        .message.success { background-color: #e8f5e9; color: var(--color-success); border: 1px solid var(--color-success); }
        .message.error { background-color: #ffebee; color: var(--color-error); border: 1px solid var(--color-error); }
    </style>
</head>
<body>

<div class="register-box">
    <h2><i class="fas fa-user-plus"></i> Pendaftaran Akun Admin</h2>
    
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $message_type; ?>"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="input-group">
            <label for="nama_pengurus">Nama Pengurus (Nama Lengkap)</label>
            <input type="text" id="nama_pengurus" name="nama_pengurus" required>
        </div>
        <button type="submit" class="btn-register">Daftar Admin</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        <a href="login.php" style="color: var(--color-primary); text-decoration: none;">&larr; Kembali ke Halaman Login</a>
    </p>
</div>

</body>
</html>