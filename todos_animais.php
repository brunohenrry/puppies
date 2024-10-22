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
    public function searchAnimals($search, $species_filter, $sex_filter, $breed_filter, $age_filter) {
        $sql = "SELECT * FROM animals WHERE 1";

        if (!empty($search)) {
            $sql .= " AND (name LIKE '%$search%' OR location LIKE '%$search%')";
        }

        if (!empty($species_filter)) {
            $sql .= " AND species = '$species_filter'";
        }
        if (!empty($sex_filter)) {
            $sql .= " AND sex = '$sex_filter'";
        }
        if (!empty($breed_filter)) {
            $sql .= " AND breed LIKE '%$breed_filter%'";
        }
        if (!empty($age_filter)) {
            $sql .= " AND age = $age_filter";
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

// Realizando a busca de animais com base nos filtros
$result = $db->searchAnimals($search, $species_filter, $sex_filter, $breed_filter, $age_filter);
?>

<!DOCTYPE html>
<html class="no-js" lang="zxx">
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
<?php
include('navbar.php');
?>

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
                <form method="get" action="adopt.php" class="mb-5">
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
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Contato</h3>
                            <ul class="address_line">
                                <li>+555 0000 565</li>
                                <li><a href="mailto:demomail@gmail.com">puppies@gmail.com</a></li>
                                <li>700, Green Lane, Barretos, SP</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Informações</h3>
                            <ul>
                                <li><a href="#">Sobre Nós</a></li>
                                <li><a href="#">Serviços</a></li>
                                <li><a href="#">Contato</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Links Rápidos</h3>
                            <ul>
                                <li><a href="#">Adote Um Animal</a></li>
                                <li><a href="#">Nossos Serviços</a></li>
                                <li><a href="#">Doações</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Redes Sociais</h3>
                            <ul class="social_links">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <p class="footer-text">© 2023 Todos os direitos reservados | Design por <a href="#">YourName</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/vendor/jquery-3.5.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
