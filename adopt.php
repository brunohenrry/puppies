<!-- adopt -->
<?php
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

$id = $_GET['id'];

$sql = "SELECT * FROM animals WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Animal não encontrado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Puppies</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="img/service/service_icon_1.png">
    <!-- Place favicon.ico in the root directory -->

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
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo">
                                <a href="index.php">
                                    <img src="img/logo_1.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="index.php">home</a></li>
                                        <li><a href="about.php">sobre</a></li>
                                        <!-- <li><a href="#">blog <i class="ti-angle-down"></i></a>
                                            <ul class="submenu">
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="single-blog.html">single-blog</a></li>
                                            </ul>
                                        </li> -->

                                        <li><a href="todos_animais.php">todos animais</a></li>
                                        <li><a href="service.php">Serviços</a></li>
                                        <li><a href="contato.php">Contato</a></li>
                                        <li><a href="admin.php">Painel Admin</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-lg-7 col-md-10">
                <div class="section_title text-center mb-95">
                    <div class="section_title text-center mb-95">
                        <div class="section_title text-center mb-95">
                            <h1>Detalhes do Animal</h1>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-7 col-md-10">
                            <div class="section_title text-center mb-95">
                                <div class=""></div>
                                <div class="container">
                                    <div class="row align-items-center">
                                        <img src="<?php echo $row['image']; ?>" alt="Imagem do Animal" class="img-fluid">

                                    </div>
                                    <div class="container">
                                        <div class="row justify-content-center">

                                        </div>
                                        <h2 class="nome-animal"><?php echo $row['name']; ?></h2>
                                        <p>Espécie: <?php echo $row['species']; ?></p>
                                        <p>Raça: <?php echo $row['breed']; ?></p>
                                        <p>Idade: <?php echo $row['age']; ?> anos</p>
                                        <p>Sexo: <?php echo $row['sex']; ?></p>
                                        <p>Descrição: <?php echo $row['description']; ?></p>
                                        <p>Localização: <?php echo $row['location']; ?></p>
                                        <p>Contato: <?php echo $row['contact_info']; ?></p>
                                        <a href="contact.php?id=<?php echo $row['id']; ?>" class="genric-btn success circle">Quero Adotar</a>
                                        <a href="https://api.whatsapp.com/send?text=Adote%20o%20animal%20<?php echo $row['name']; ?>%20em%20<?php echo $row['location']; ?>" class="genric-btn link">Compartilhar no WhatsApp</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                </div>
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
                            <h3 class="footer_title">Nossos Serviços</h3>
                            <ul class="links">
                                <li><a href="#">Seguro para Animais de Estimação</a></li>
                                <li><a href="#">Cirurgias para Animais</a></li>
                                <li><a href="#">Adoção de Animais</a></li>
                                <li><a href="#">Seguro para Cães</a></li>
                                <li><a href="#">Seguro para Gatos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">Links Rápidos</h3>
                            <ul class="links">
                                <li><a href="#">Sobre Nós</a></li>
                                <li><a href="#">Política de Privacidade</a></li>
                                <li><a href="#">Termos de Serviço</a></li>
                                <li><a href="#">Informações de Login</a></li>
                                <li><a href="#">Base de Conhecimento</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="img/logo_1.png" alt="Logo">
                                </a>
                            </div>
                            <p class="address_text">239 E 5th St, Barretos
                                BR 00000, SP
                            </p>
                            <div class="socail_links">
                                <ul>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right_text">
            <div class="container">
                <div class="bordered_1px"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            Direitos Autorais &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> Todos os direitos reservados | Este template é feito com <i class="ti-heart" aria-hidden="true"></i> por <a href="https://UNIFEB.com" target="_blank">UNIFEB</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
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
    <script src="js/gijgo.min.js"></script>

    <!--contact js-->
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>

    <script src="js/main.js"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0],
            //     icons: {
            //      rightIcon: '<span class="fa fa-caret-down"></span>'
            //  }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }

        });
        var timepicker = $('#timepicker').timepicker({
            format: 'HH.MM'
        });
    </script>
</body>

</html>