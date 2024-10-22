<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Buscar informações do usuário
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, email, location, contact_info FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $location, $contact_info);
$stmt->fetch();
$stmt->close();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Puppies</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS here -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #fff5f2 0%, #ffe5e0 100%);
            min-height: 100vh;
            padding-bottom: 3rem;
        }

        .profile-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(255, 53, 0, 0.1);
            padding: 2.5rem;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
        }

        .profile-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #ff3500, #ff6b40);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(45deg, #ff3500, #ff6b40);
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .profile-name {
            font-size: 1.8rem;
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-info {
            background: #fff;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            transition: all 0.3s ease;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item:hover {
            background: #fff5f2;
            border-radius: 10px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #ffe5e0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: #ff3500;
        }

        .info-content {
            flex-grow: 1;
        }

        .info-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: #1f2937;
            font-weight: 500;
        }

        .btn-logout {
            background: #ff3500;
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            margin-top: 2rem;
            width: 100%;
        }

        .btn-logout:hover {
            background: #e62e00;
            transform: translateY(-2px);
            color: white;
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
    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="profile-container">
                <div class="paw-print"></div>
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?php echo strtoupper(substr($username, 0, 1)); ?>
                    </div>
                    <h2 class="profile-name"><?php echo htmlspecialchars($username); ?></h2>
                    <p class="text-muted">Membro desde <?php echo date('F Y'); ?></p>
                </div>

                <div class="profile-info">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nome Completo</div>
                            <div class="info-value"><?php echo htmlspecialchars($username); ?></div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo htmlspecialchars($email); ?></div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Localização</div>
                            <div class="info-value"><?php echo htmlspecialchars($location); ?></div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Telefone de Contato</div>
                            <div class="info-value"><?php echo htmlspecialchars($contact_info); ?></div>
                        </div>
                    </div>
                </div>

                <a href="logout.php" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair da Conta
                </a>
            </div>
        </div>
    </div>
</div>

</body>

</html>
