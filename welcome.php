<?php
session_start(); // Resume session

// Redirect to login if no user session exists
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Gradient with smooth transitions */
            background: linear-gradient(135deg, #FFB3BA, #FFC3A0);
            font-family: 'Arial', sans-serif;
            overflow: hidden;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .hello-animation {
            font-size: 5rem;
            font-family: 'Pacifico', cursive;
            color: #333;
            position: relative;
            animation: fadeIn 2s ease-in-out, float 3s ease-in-out infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hello-animation">Hello</div>
    </div>

    <script>
        // Redirect after 5 seconds
        setTimeout(function() {
            window.location.href = "home.php";
        }, 5000); // 5000ms = 5 seconds
    </script>
</body>
</html>
