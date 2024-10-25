<?php
session_start();
require_once 'db.php';

// Verifique se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não está logado.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$animal_id = $_POST['animal_id'];

// Remove o animal dos favoritos
$sql_delete = "DELETE FROM favorites WHERE user_id = ? AND animal_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("ii", $user_id, $animal_id);

if ($stmt_delete->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao remover dos favoritos.']);
}

$stmt_delete->close();
$conn->close();
?>
