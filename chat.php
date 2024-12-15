<?php
require_once 'configuration/config.php'; // Include database configuration
session_start(); // Start or resume the session

// Redirect to login if the user isn't logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page
    exit();
}

// Set sender and receiver IDs
$sender_id = $_SESSION['user_id']; // Logged-in user's ID
$receiver_id = 2; // Replace with chat partner's ID (hardcoded for now)

// Fetch messages from the database
$messages = [];
try {
    $stmt = $pdo->prepare("
        SELECT sender_id, receiver_id, messages 
        FROM chat 
        WHERE (sender_id = :sender_id AND receiver_id = :receiver_id) 
           OR (sender_id = :receiver_id AND receiver_id = :sender_id)
        ORDER BY id ASC
    ");
    $stmt->execute([
        ':sender_id' => $sender_id,
        ':receiver_id' => $receiver_id
    ]);
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching messages: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Buz</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap">
    <style>
        /* CSS styles here (unchanged from your original code) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Open Sans', sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }
        .chat-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }
        .chat-messages .message {
            margin-bottom: 15px;
            max-width: 70%;
        }
        .chat-messages .message.sent {
            margin-left: auto;
            text-align: right;
        }
        .chat-messages .message .bubble {
            padding: 10px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            color: #fff;
        }
        .chat-messages .message.sent .bubble {
            background-color: #4caf50;
        }
        .chat-messages .message.received .bubble {
            background-color: #007bff;
        }
        .chat-input {
            padding: 10px;
            border-top: 1px solid #ddd;
            display: flex;
            align-items: center;
        }
        .chat-input input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
        }
        .chat-input button {
            margin-left: 10px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .chat-input button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            Chatting with: <span id="chat-username">User 2</span>
            <span style="float: right;">👤 Logged in as: <?= htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <div class="chat-messages">
            <?php foreach ($messages as $message): ?>
                <div class="message <?= $message['sender_id'] == $sender_id ? 'sent' : 'received' ?>">
                    <div class="bubble"><?= htmlspecialchars($message['messages']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="chat-input">
            <form method="POST" action="send_message.php">
                <input type="text" name="message" placeholder="Type a message..." required>
                <input type="hidden" name="sender_id" value="<?= $sender_id ?>">
                <input type="hidden" name="receiver_id" value="<?= $receiver_id ?>">
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
</body>
</html>
