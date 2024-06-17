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

$sql = "DELETE FROM animals WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    // Exclusão bem-sucedida
    echo '<script>alert("Animal removido com sucesso!"); window.location.href = "todos_animais.php";</script>';
} else {
    // Erro na query SQL
    echo '<script>alert("Erro ao remover animal: ' . $conn->error . '"); window.location.href = "todos_animais.php";</script>';
}

$conn->close();
?>
