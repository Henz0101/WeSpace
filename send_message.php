<?php
require_once 'configuration/config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO chat (sender_id, receiver_id, messages) 
            VALUES (:sender_id, :receiver_id, :message)
        ");
        $stmt->execute([
            ':sender_id' => $sender_id,
            ':receiver_id' => $receiver_id,
            ':message' => $message
        ]);
        header("Location: chat.php");
    } catch (PDOException $e) {
        echo "Error sending message: " . $e->getMessage();
    }
}
?>
