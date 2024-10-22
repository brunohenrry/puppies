<?php
require_once 'db.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $location = trim($_POST['location']);
    $contact_info = trim($_POST['contact_info']);
    
    if (!empty($name) && !empty($email) && !empty($password) && !empty($location) && !empty($contact_info)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Verificar se o email já existe
        $sql = "SELECT id FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error_message = "error_email_exists";
            } else {
                // Inserir novo usuário
                $sql = "INSERT INTO users (username, email, password, location, contact_info) VALUES (?, ?, ?, ?, ?)";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("sssss", $name, $email, $hashed_password, $location, $contact_info);

                    if ($stmt->execute()) {
                        $success_message = "success_register";
                    } else {
                        $error_message = "error_register";
                    }
                } else {
                    $error_message = "error_register";
                }
            }
            $stmt->close();
        } else {
            $error_message = "error_query";
        }
    } else {
        $error_message = "error_empty";
    }

    // Definindo mensagens de erro amigáveis
    if ($error_message == "error_email_exists") {
        $error_message = "Este email já está em uso. Tente outro.";
    } elseif ($error_message == "error_empty") {
        $error_message = "Por favor, preencha todos os campos.";
    } elseif ($error_message == "error_register") {
        $error_message = "Ocorreu um erro durante o registro. Tente novamente.";
    } elseif ($error_message == "error_query") {
        $error_message = "Erro na consulta ao banco de dados.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Cadastro - Puppies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS here -->
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

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(255, 53, 0, 0.1);
            padding: 2.5rem;
            margin: 3rem auto;
            position: relative;
            overflow: hidden;
            max-width: 500px;
        }

        .register-container::before {
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
            width: 100%;
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
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: #e62e00;
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 500;
            color: #4b5563;
            display: block;
            margin-bottom: 0.25rem;
        }

        .register-header {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .input-group {
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="register-container">
                <div class="paw-print"></div>
                <h3 class="register-header">Junte-se a nossa família! 🐾</h3>
                <form id="registerForm" action="register.php" method="POST">
                    <div class="input-group">
                        <label class="form-label" for="name">Nome</label>
                        <input type="text" class="form-control" name="name" id="name" required placeholder="Seu nome completo">
                    </div>
                    <div class="input-group">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required placeholder="seu@email.com">
                    </div>
                    <div class="input-group">
                        <label class="form-label" for="password">Senha</label>
                        <input type="password" class="form-control" name="password" id="password" required placeholder="••••••••">
                    </div>
                    <div class="input-group">
                        <label class="form-label" for="location">Localização</label>
                        <input type="text" class="form-control" name="location" id="location" required placeholder="Cidade, Estado">
                    </div>
                    <div class="input-group">
                        <label class="form-label" for="contact_info">Telefone de Contato</label>
                        <input type="text" class="form-control" name="contact_info" id="contact_info" required placeholder="(00) 00000-0000">
                    </div>
                    <div class="input-group">
                        <input type="checkbox" id="terms" required>
                        <label for="terms" class="form-label" style="display: inline;">Eu concordo com os <a href="termos.html" target="_blank">termos e condições</a>.</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function showAlert(message, type) {
    Swal.fire({
        icon: type === 'success' ? 'success' : 'error',
        title: type === 'success' ? 'Sucesso!' : 'Erro!',
        text: message,
        confirmButtonText: 'OK'
    }).then(() => {
        // Se for sucesso, redireciona após o alerta
        if (type === 'success') {
            window.location.href = 'index.php'; // Mude para a página de redirecionamento desejada
        }
    });
}

// Verifica mensagens do servidor
<?php if ($error_message): ?>
    showAlert('<?= $error_message ?>', 'error');
<?php elseif ($success_message): ?>
    showAlert('Cadastro realizado com sucesso!', 'success');
<?php endif; ?>
</script>

</body>
</html>
