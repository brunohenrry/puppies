<?php
session_start();
require 'db.php';

$user_id = $_SESSION['user_id']; // Obtém o ID do usuário logado

if (isset($_GET['id'])) {
    $animal_id = $_GET['id'];

    // Verifica se o animal pertence ao usuário logado
    $sql = "DELETE FROM animals WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $animal_id, $user_id);

    if ($stmt->execute()) {
        echo "Animal excluído com sucesso!";
    } else {
        echo "Você não tem permissão para excluir este animal!";
    }
    $stmt->close();
}
?>
