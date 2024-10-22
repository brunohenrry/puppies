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

// Verifica se o ID foi passado e é um número
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "ID inválido.";
    exit;
}

$sql = "SELECT * FROM animals WHERE id=$id";
$result = $conn->query($sql);

// Verifica se a consulta retornou resultados
if ($result && $result->num_rows > 0) {
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
    <style>
        :root {
            --primary-color: #ff3500;
            --primary-light: #ff6347;
            --text-dark: #333;
            --background-light: #fff5f2;
        }

        .section_title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section_title h1 {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 600;
            position: relative;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
        }


        .contact-details {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-details h2 {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        .contact-details p {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            line-height: 1.6;
        }

        .contact-details .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .contact-details .info-item i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .contact-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .contact-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            min-width: 200px;
        }

        .email-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .phone-btn {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(255, 53, 0, 0.3);
        }

        .email-btn:hover {
            background-color: var(--primary-light);
        }

        .phone-btn:hover {
            background-color: var(--background-light);
        }

        .pet-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 2rem;
            border: 5px solid var(--background-light);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .contact-buttons {
                flex-direction: column;
            }

            .contact-btn {
                width: 100%;
            }

            .section_title h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container">
        <div class="section_title">
            <h1>Contato para Adoção</h1>
        </div>

        <div class="contact-details">
            <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="pet-image">
            <h2><?php echo $row['name']; ?></h2>
            
            <div class="info-item">
                <i class="ti ti-location-pin"></i>
                <p><?php echo $row['location']; ?></p>
            </div>
            
            <div class="info-item">
                <i class="ti ti-user"></i>
                <p>Responsável pela adoção</p>
            </div>
            
            <div class="info-item">
                <i class="ti ti-mobile"></i>
                <p><?php echo $row['contact_info']; ?></p>
            </div>

            <p>Para adotar o <?php echo $row['name']; ?>, entre em contato com o responsável através de uma das opções abaixo:</p>
            
            <div class="contact-buttons">
                <a href="mailto:<?php echo $row['contact_info']; ?>?subject=Adoção de <?php echo $row['name']; ?>" class="contact-btn email-btn">
                    <i class="ti ti-email"></i>
                    Enviar Email
                </a>
                <a href="tel:<?php echo $row['contact_info']; ?>" class="contact-btn phone-btn">
                    <i class="ti ti-mobile"></i>
                    Ligar Agora
                </a>
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