<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: adminpura.php");
    exit;
}
require_once 'koneksi.php'; 

$error_message = ''; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!isset($conn) || $conn->connect_error) {
        $error_message = "Koneksi database bermasalah. Cek koneksi.php.";
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password']; 

        $sql = "SELECT id_admin, username, password, nama_pengurus FROM admin_users WHERE username = ?";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $admin = $result->fetch_assoc();
        
                if (password_verify($password, $admin['password'])) { 
                
                    $_SESSION['logged_in'] = true;
                    $_SESSION['id_admin'] = $admin['id_admin'];
                    $_SESSION['username'] = $admin['username'];
                    $_SESSION['nama_pengurus'] = $admin['nama_pengurus'];
                    
                    header("Location: adminpura.php");
                    exit;
                } else {
                    $error_message = "Username atau Password salah.";
                }
            } else {
                $error_message = "Username atau Password salah.";
            }
            $stmt->close();
        } else {
            $error_message = "Terjadi kesalahan internal pada query: " . $conn->error;
        }
    }
}
if (isset($conn) && $conn) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Pura Mandira Taman Sari</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --color-primary: #FF9900; 
            --color-secondary: #5e3b0c; 
            --color-text: #333333;
            --bg-color-soft: #fffbe6; 
            --bg-color-main: #f0f0f0; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            box-sizing: border-box;
            background: linear-gradient(135deg, var(--bg-color-soft) 0%, var(--bg-color-main) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 360px; 
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-header {
            margin-bottom: 15px; 
            padding-top: 5px;
        }
        
        .logo-om-large {
            width: 80px; 
            height: 80px; 
            background: var(--color-primary);
            border-radius: 50%;
            padding: 8px;
            filter: drop-shadow(0 0 10px rgba(255, 153, 0, 0.4)); 
            border: 3px solid white;
            box-sizing: content-box;
        }

        .login-box {
            background: #ffffff;
            padding: 30px; 
            border-radius: 10px; 
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); 
            border-top: 4px solid var(--color-primary); 
            text-align: center;
        }

        .login-box h2 {
            font-family: 'Poppins', sans-serif;
            color: var(--color-secondary);
            margin-top: 0;
            margin-bottom: 4px;
            font-size: 1.5em; 
            font-weight: 700;
        }
        
        .login-box p.subtitle {
            color: #777;
            margin-bottom: 25px; 
            font-size: 0.9em;
        }

        .input-group {
            margin-bottom: 15px; 
            text-align: left;
        }
        
        .input-label {
            display: block;
            font-size: 0.85em;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 4px; 
        }
        
        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px; 
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 0.85em;
        }

        .input-group input {
            width: 100%;
            padding: 10px 15px 10px 35px; 
            border: 1px solid #ddd;
            border-radius: 7px;
            box-sizing: border-box;
            font-size: 0.95em;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .input-group input:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 2px rgba(255, 153, 0, 0.15);
            outline: none;
        }

        .btn-login-submit {
            display: inline-block;
            padding: 10px 35px;
            background-color: var(--color-primary);
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 0.95em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(255, 153, 0, 0.4); 
            transition: background-color 0.3s, transform 0.1s, box-shadow 0.3s;
            margin-top: 5px;
        }

        .btn-login-submit:hover {
            background-color: var(--color-secondary);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(94, 59, 12, 0.3); 
        }

        .error-message {
            color: #c0392b;
            background-color: #fcebeb;
            padding: 10px;
            border: 1px solid #c0392b;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 500;
            font-size: 0.85em;
        }
        
        .footer-link {
            margin-top: 20px; 
            font-size: 0.85em;
            color: #999;
        }
        
        .footer-link a {
            color: var(--color-secondary); 
            text-decoration: none; 
            transition: color 0.3s;
            font-weight: 600;
        }
        
        .footer-link a:hover {
            color: var(--color-primary);
        }

        @media (max-width: 500px) {
            .login-box {
                padding: 25px 15px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <img src="images/2.png" alt="Logo Omkara" class="logo-om-large"> 
    </div>

    <div class="login-box">
        <h2>Sistem Admin Pura</h2>
        <p class="subtitle">Masuk dengan akun Pengurus Resmi.</p>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-group">
                <label for="username" class="input-label">Username</label>
                <div class="input-wrapper">
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="username">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            
            <div class="input-group">
                <label for="password" class="input-label">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required autocomplete="current-password">
                    <i class="fas fa-lock"></i>
                </div>
            </div>
            
            <button type="submit" class="btn-login-submit">Login</button>
        </form>
        
        <p class="footer-link">
            <a href="index.php"><i class="fas fa-home"></i> Kembali ke Beranda</a>
        </p>
    </div>
</div>

</body>
</html>