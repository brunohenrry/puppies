<?php
// Classe para gerenciar a conexão com o banco de dados
class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "pets_adocao";
    private $conn;

    // Construtor para inicializar a conexão
    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Método para buscar animais com filtros
    public function searchAnimals($search, $species_filter, $sex_filter, $breed_filter, $age_filter, $favorite_filter) {
        $sql = "SELECT a.* FROM animals a";

        if ($favorite_filter) {
            $sql .= " JOIN favorites f ON a.id = f.animal_id WHERE f.user_id = $favorite_filter";
        } else {
            $sql .= " WHERE 1=1";
        }

        if (!empty($search)) {
            $sql .= " AND (a.name LIKE '%$search%' OR a.location LIKE '%$search%')";
        }

        if (!empty($species_filter)) {
            $sql .= " AND a.species = '$species_filter'";
        }
        if (!empty($sex_filter)) {
            $sql .= " AND a.sex = '$sex_filter'";
        }
        if (!empty($breed_filter)) {
            $sql .= " AND a.breed LIKE '%$breed_filter%'";
        }
        if (!empty($age_filter)) {
            $sql .= " AND a.age = $age_filter";
        }

        $result = $this->conn->query($sql);
        return $result;
    }

    // Método para fechar a conexão com o banco de dados
    public function closeConnection() {
        $this->conn->close();
    }
}

// Instanciando a classe Database para usar seus métodos
$db = new Database();

// Inicializando as variáveis com valores padrão
$search = isset($_GET['search']) ? $_GET['search'] : "";
$species_filter = isset($_GET['species']) ? $_GET['species'] : "";
$sex_filter = isset($_GET['sex']) ? $_GET['sex'] : "";
$breed_filter = isset($_GET['breed']) ? $_GET['breed'] : "";
$age_filter = isset($_GET['age']) ? $_GET['age'] : "";
$favorite_filter = isset($_GET['favorites']) ? $_GET['favorites'] : "";

// Realizando a busca de animais com base nos filtros
$result = $db->searchAnimals($search, $species_filter, $sex_filter, $breed_filter, $age_filter, $favorite_filter);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Todos os Animais</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
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
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>
<body>
<?php include('navbar.php'); ?>

    <div class="slider_area">
        <div class="single_slider slider_bg_1 d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="slider_text">
                            <h3>Encontre Todos os <br> <span>Animais Disponíveis!</span></h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            <a href="contato.php" class="boxed-btn4">Contato</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dog_thumb d-none d-lg-block">
                <img src="img/banner/cat.png" alt="">
            </div>
        </div>
    </div>

    <div class="service_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10">
                    <div class="section_title text-center mb-95">
                        <h3>Todos os Animais</h3>
                        <p>Uma seleção especial de peludinhos que buscam um lar para chamar de seu.</p>
                    </div>
                </div>
            </div>
            
            <div class="row justify-content-center">
                <form method="get" action="todos_animais.php" class="mb-5">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Nome do Animal" value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="species" class="form-control">
                                <option value="">Espécie</option>
                                <option value="Cachorro" <?php if ($species_filter == 'Cachorro') echo 'selected'; ?>>Cachorro</option>
                                <option value="Gato" <?php if ($species_filter == 'Gato') echo 'selected'; ?>>Gato</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="breed" class="form-control" placeholder="Raça" value="<?php echo htmlspecialchars($breed_filter); ?>">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="age" class="form-control" placeholder="Idade" value="<?php echo htmlspecialchars($age_filter); ?>">
                        </div>
                        <div class="col-md-2">
                            <select name="sex" class="form-control">
                                <option value="">Sexo</option>
                                <option value="Macho" <?php if ($sex_filter == 'Macho') echo 'selected'; ?>>Macho</option>
                                <option value="Fêmea" <?php if ($sex_filter == 'Fêmea') echo 'selected'; ?>>Fêmea</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <label><input type="checkbox" name="favorites" value="1" <?php if ($favorite_filter) echo 'checked'; ?>> Apenas Favoritos</label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="boxed-btn4">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="row justify-content-center">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-lg-4 col-md-6">';
                        echo '<div class="single_service">';
                        echo '<div class="service_thumb service_icon_bg_1 d-flex align-items-center justify-content-center">';
                        echo '<div class="service_icon">';
                        echo '<img src="' . htmlspecialchars($row["image"]) . '" alt="">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="service_content text-center">';
                        echo '<h3 class="nome-animal">' . htmlspecialchars($row["name"]) . '</h3>';
                        echo '<p class="cidade">' . htmlspecialchars($row["location"]) . '<span>📍</span></p>';
                        echo '<a href="adopt.php?id=' . htmlspecialchars($row["id"]) . '" class="boxed-btn5">Quero Adotar </a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "<div class='col-md-12 text-center'><p>Nenhum animal encontrado.</p></div>";
                }
                $db->closeConnection(); // Fechar a conexão
                ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="footer_area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="footer_text text-center text-md-left">
                            <p>&copy; 2024 Todos os direitos reservados | Desenvolvido por <a href="#">Seu Nome</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/vendor/jquery-3.5.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
<style>
    .service_area {
        padding: 120px 0;
        background: linear-gradient(to bottom, #fff9f9, #ffffff);
    }

    /* Título da seção */
    .section_title h3 {
        font-size: 42px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 15px;
        text-transform: none;
        position: relative;
        display: inline-block;
    }

    .section_title h3:after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: #ff6b6b;
        border-radius: 2px;
    }

    .section_title p {
        color: #7f8c8d;
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    /* Cards dos pets */
    .single_service {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .single_service:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    /* Área da imagem */
    .service_thumb {
        position: relative;
        height: 280px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .service_thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .single_service:hover .service_thumb img {
        transform: scale(1.05);
    }

    /* Conteúdo do card */
    .service_content {
        padding: 25px 20px;
        text-align: center;
    }

    .service_content h3 {
        font-size: 24px;
        color: #2c3e50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .service_content .cidade {
        color: #7f8c8d;
        font-size: 16px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    /* Botão de adoção */
    .boxed-btn5 {
        background: #ff3500;
        color: #fff;
        display: inline-block;
        padding: 12px 30px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid #ff3500;
    }

    .boxed-btn5:hover {
        background: transparent;
        color: #ff3500;
    }

    /* Botão de favorito */
    .favorite-button {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        padding: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .heart-btn {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .heart-btn i {
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .heart-btn:hover i {
        transform: scale(1.1);
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .service_area {
            padding: 80px 0;
        }

        .section_title h3 {
            font-size: 32px;
        }

        .section_title p {
            font-size: 16px;
        }

        .service_thumb {
            height: 240px;
        }
    }
</style>