<?php
session_start();
require_once 'db.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT id, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $success_message = "success_login"; // Definindo a mensagem de sucesso
            // Não redirecionar aqui
        } else {
            $error_message = "error_credentials";
        }

        $stmt->close();
    } else {
        $error_message = "error_empty";
    }
}
?>

<!doctype html>
<html class="no-js" lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - Puppies</title>
    <meta name="description" content="Sistema de login para o site Puppies">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">

    <!-- CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: linear-gradient(135deg, #fff5f2 0%, #ffe5e0 100%);
            min-height: 100vh;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(255, 53, 0, 0.1);
            padding: 2rem;
            margin-top: 5rem;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #ff3500, #ff6b40);
        }

        .paw-print {
            position: absolute;
            opacity: 0.1;
            transform: rotate(-15deg);
            width: 150px;
            height: 150px;
            right: -20px;
            bottom: -20px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512'%3E%3Cpath fill='%23ff3500' d='M256 224c-79.5 0-144 64.5-144 144s64.5 144 144 144 144-64.5 144-144-64.5-144-144-144zm0 240c-52.9 0-96-43.1-96-96s43.1-96 96-96 96 43.1 96 96-43.1 96-96 96zm0-128c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.8rem;
            border: 2px solid #ffe5e0;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ff3500;
            box-shadow: 0 0 0 3px rgba(255, 53, 0, 0.1);
        }

        .btn-primary {
            background: #ff3500;
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #e62e00;
            transform: translateY(-2px);
        }

        .login-header {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .register-link {
            color: #ff3500;
            text-decoration: none;
            font-weight: 500;
        }

        .register-link:hover {
            color: #e62e00;
            text-decoration: underline;
        }

        /* Custom SweetAlert styles */
        .swal2-popup {
            border-radius: 15px !important;
            padding: 2em !important;
        }

        .swal2-title {
            color: #1f2937 !important;
            font-size: 1.5em !important;
        }

        .swal2-toast {
            background: #fff !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important;
        }

        .swal2-icon {
            border-width: 3px !important;
        }

        .swal2-timer-progress-bar {
            background: rgba(255, 53, 0, 0.3) !important;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="login-container">
                    <div class="paw-print"></div>
                    <h3 class="login-header">Bem-vindo de volta! 🐾</h3>
                    <form action="login.php" method="POST" id="loginForm">
                        <div class="mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" required placeholder="seu@email.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password">Senha</label>
                            <input type="password" class="form-control" name="password" id="password" required placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3">Entrar</button>
                        <p class="text-center mb-0">
                            Ainda não tem conta? 
                            <a href="register.php" class="register-link">Registre-se</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <script>
        // Mostrar alertas baseados nas mensagens PHP
        <?php if ($error_message): ?>
            showAlert('<?php echo $error_message; ?>');
        <?php endif; ?>

        <?php if ($success_message): ?>
            showAlert('<?php echo $success_message; ?>');

            // Redirecionar após 2 segundos
            setTimeout(() => {
                window.location.href = "index.php";
            }, 2000);
        <?php endif; ?>

        function showAlert(message) {
            if (message === "error_credentials") {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro!',
                    text: 'Credenciais inválidas. Tente novamente.',
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: false,
                });
            } else if (message === "error_empty") {
                Swal.fire({
                    icon: 'warning',
                    title: 'Atenção!',
                    text: 'Por favor, preencha todos os campos.',
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: false,
                });
            } else if (message === "success_login") {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: 'Login realizado com sucesso!',
                    timer: 3000,
                    timerProgressBar: true,
                    showCloseButton: false,
                });
            }
        }
    </script>
</body>

</html>
