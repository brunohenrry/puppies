<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pets_adocao";

// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id']; // Obtém o ID do usuário logado

// Seleciona apenas os animais cadastrados pelo usuário logado
$sql = "SELECT * FROM animals WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Puppies - Lista de Animais</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --primary-color: #ff3500;
            --primary-light: #ff5733;
            --text-dark: #333;
            --background-light: #fff5f2;
        }

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background-color: #f8f9fa;
            color: var(--text-dark);
            line-height: 1.6;
            margin: 0; /* Remove margem padrão do body */
            padding: 0; /* Remove padding padrão do body */
        }

        .container {
            max-width: 1200px;
            margin: 0 auto; /* Removido margin-top */
            padding: 1rem;
        }

        h3 {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            padding-top: 1rem; /* Adicionado padding em vez de margin */
        }

      

        .pets-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }

        .pet-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .pet-card:hover {
            transform: translateY(-5px);
        }

        .pet-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .pet-info {
            padding: 1.5rem;
        }

        .pet-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0 0 0.5rem 0;
        }

        .pet-location {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-edit {
            background-color: #ffd700;
            color: #000;
        }

        .btn-delete {
            background-color: #ff4444;
            color: white;
        }

        .btn-add {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            margin: 1rem auto; /* Reduzido margin */
            display: block;
            width: fit-content;
        }

        .btn:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            background: var(--background-light);
            border-radius: 15px;
            margin: 1rem 0;
        }

        .ti {
            font-size: 1.1em;
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .pets-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
</head>

<body>
<?php include('navbar.php'); ?>

<div class="container">
        <h3>Lista de Animais para Adoção</h3>
        
        <div class="pets-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="pet-card">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="pet-image">
                        <div class="pet-info">
                            <h4 class="pet-name"><?php echo $row['name']; ?></h4>
                            <div class="pet-location">
                                <i class="ti ti-location-pin"></i>
                                <?php echo $row['location']; ?>
                            </div>
                            <?php if ($row['user_id'] == $user_id): ?>
                                <div class="action-buttons">
                                    <a href="edit_animal.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">
                                        <i class="ti ti-pencil"></i> Editar
                                    </a>
                                    <a href="delete_animal.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-delete" 
                                       onclick="return confirm('Tem certeza que deseja excluir este animal?')">
                                        <i class="ti ti-trash"></i> Excluir
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="ti ti-alert" style="font-size: 3rem; color: var(--primary-color);"></i>
                    <h4>Nenhum animal encontrado</h4>
                    <p>Nenhum animal encontrado.</p>
                </div>
            <?php endif; ?>
        </div>

        <a href="admin.php" class="btn btn-add">
            <i class="ti ti-plus"></i> Adicionar Animal
        </a>
    </div>
        
    

    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
