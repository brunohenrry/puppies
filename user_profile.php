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

// Buscar animais favoritos
$sql_favorites = "SELECT a.id, a.name, a.species, a.breed FROM favorites f JOIN animals a ON f.animal_id = a.id WHERE f.user_id = ?";
$stmt_favorites = $conn->prepare($sql_favorites);
$stmt_favorites->bind_param("i", $user_id);
$stmt_favorites->execute();
$result_favorites = $stmt_favorites->get_result();
$stmt_favorites->close();
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

        .favorites-section {
        margin-top: 3rem;
        padding: 2rem;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .favorites-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .favorites-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .favorites-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .favorite-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
        position: relative;
    }

    .favorite-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 53, 0, 0.1);
    }

    .favorite-image {
        height: 200px;
        background: #ffe5e0;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .favorite-image i {
        font-size: 4rem;
        color: #ff3500;
    }

    .favorite-content {
        padding: 1.5rem;
    }

    .favorite-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .favorite-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .info-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        background: #fff5f2;
        border-radius: 20px;
        font-size: 0.875rem;
        color: #ff3500;
    }

    .favorite-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-view {
        flex: 1;
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
    }

    .btn-view-details {
        background: #ff3500;
        color: white;
    }

    .btn-view-details:hover {
        background: #e62e00;
        color: white;
    }

    .btn-remove-favorite {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-remove-favorite:hover {
        background: #e5e7eb;
    }

    .empty-favorites {
        text-align: center;
        padding: 3rem;
        background: #fff5f2;
        border-radius: 15px;
    }

    .empty-favorites i {
        font-size: 3rem;
        color: #ff3500;
        margin-bottom: 1rem;
    }

    .empty-favorites p {
        color: #6b7280;
        margin-bottom: 1rem;
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

                <div class="favorites-section">
    <div class="favorites-header">
        <h3 class="favorites-title">
            <i class="fas fa-heart" style="color: #ff3500;"></i>
            Animais Favoritos
        </h3>
        <span class="badge bg-primary"><?php echo $result_favorites->num_rows; ?> favoritos</span>
    </div>

    <?php if ($result_favorites->num_rows > 0): ?>
        <div class="favorites-grid">
            <?php while ($favorite = $result_favorites->fetch_assoc()): ?>
                <div class="favorite-card">
                    <div class="favorite-image">
                        <i class="fas fa-paw"></i>
                    </div>
                    <div class="favorite-content">
                        <h4 class="favorite-name"><?php echo htmlspecialchars($favorite['name']); ?></h4>
                        <div class="favorite-info">
                            <span class="info-badge">
                                <i class="fas fa-pets"></i>
                                <?php echo htmlspecialchars($favorite['species']); ?>
                            </span>
                            <?php if (!empty($favorite['breed'])): ?>
                            <span class="info-badge">
                                <i class="fas fa-tag"></i>
                                <?php echo htmlspecialchars($favorite['breed']); ?>
                            </span>
                            <?php endif; ?>
                        </div>
                        <div class="favorite-actions">
                            <a href="adopt.php?id=<?php echo $favorite['id']; ?>" class="btn btn-view btn-view-details">
                                <i class="fas fa-eye me-2"></i>Ver Detalhes
                            </a>
                            <button onclick="removeFavorite(<?php echo $favorite['id']; ?>)" class="btn btn-view btn-remove-favorite">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="empty-favorites">
            <i class="fas fa-heart-broken"></i>
            <p>Você ainda não favoritou nenhum animal.</p>
            <a href="todos_animais.php" class="btn btn-primary">Explorar Animais</a>
        </div>
    <?php endif; ?>
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
<script>
function removeFavorite(animalId) {
    if (confirm('Tem certeza que deseja remover este animal dos favoritos?')) {
        fetch('remove_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                animal_id: animalId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover dos favoritos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao remover dos favoritos');
        });
    }
}
</script>
