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

// Verifica se o animal já está favoritado
$sql_check = "SELECT * FROM favorites WHERE user_id = ? AND animal_id = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $user_id, $animal_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Este animal já está nos seus favoritos.']);
} else {
    // Adiciona o animal aos favoritos
    $sql_insert = "INSERT INTO favorites (user_id, animal_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $animal_id);
    
    if ($stmt_insert->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao adicionar aos favoritos.']);
    }
}

$stmt_check->close();
$stmt_insert->close();
$conn->close();
?>
