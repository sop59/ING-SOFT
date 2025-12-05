<?php
session_start();
error_reporting(0);
include("include/config.php");

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $num = mysqli_fetch_array($ret);

    if($num > 0)
    {
        $extra = "change-password.php";
        $_SESSION['alogin'] = $_POST['username'];
        $_SESSION['id'] = $num['id'];
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    }
    else
    {
        $_SESSION['errmsg'] = "Usuario o contraseña inválidos";
        $extra = "index.php";
        $host  = $_SERVER['HTTP_HOST'];
        $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Compras | Panel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f9fb;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 16px 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .logo-accent {
            color: #2563eb;
        }

        .back-link {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: #2563eb;
        }

        /* Main Container */
        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .login-header p {
            font-size: 14px;
            color: #6b7280;
            font-weight: 400;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 24px;
            display: none;
            border-left: 4px solid #dc2626;
            background: #fef2f2;
            color: #991b1b;
        }

        .alert.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            background: #f9fafb;
            transition: all 0.2s ease;
            color: #1f2937;
        }

        .form-group input::placeholder {
            color: #9ca3af;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            background: white;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.05);
        }

        .submit-btn {
            width: 100%;
            padding: 11px 16px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            margin-top: 8px;
        }

        .submit-btn:hover {
            background: #1d4ed8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        /* Footer */
        footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }

        @media (max-width: 640px) {
            .header-container {
                flex-direction: column;
                gap: 12px;
            }

            .login-container {
                max-width: 100%;
            }

            .login-card {
                padding: 24px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .main-content {
                padding: 24px 16px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a class="logo" href="index.html">
                Portal de <span class="logo-accent">Compras</span>
            </a>
            <a class="back-link" href="http://localhost/shopping/">
                ← Volver al portal
            </a>
        </div>
    </header>

    <div class="main-content">
        <div class="login-container">
            <div class="login-header">
                <h1>Acceso Administrativo</h1>
                <p>Ingresa tus credenciales para continuar</p>
            </div>

            <?php if($_SESSION['errmsg'] != ""): ?>
                <div class="alert show">
                    <?php echo htmlentities($_SESSION['errmsg']); ?>
                    <?php $_SESSION['errmsg'] = ""; ?>
                </div>
            <?php endif; ?>

            <div class="login-card">
                <form method="post">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" id="username" name="username" placeholder="tu@usuario.com" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="submit-btn" name="submit">Ingresar</button>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Portal de Compras. Todos los derechos reservados.</p>
    </footer>
</body>
</html>