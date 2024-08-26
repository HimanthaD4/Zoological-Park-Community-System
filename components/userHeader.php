<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .header {
            background-color: #004d40;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-sizing: border-box;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .navigation {
            display: flex;
            justify-content: center;
            flex: 1;
            gap: 15px;
        }
        .header .navigation a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .header .navigation a:hover {
            text-decoration: none;
            
            color: #d2d4d2;
        }
        .header .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .header .user-info a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }
        .header .user-info a:hover {
            text-decoration: none;
        }
        .header .login {
            display: <?php echo isset($_SESSION['user_id']) ? 'none' : 'block'; ?>;
        }
        .header .logout {
            display: <?php echo isset($_SESSION['user_id']) ? 'block' : 'none'; ?>;
        }
        .content {
            margin-top: 60px; /* Adjust based on header height */
            padding: 20px;
        }
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            .header .navigation {
                margin-top: 10px;
                flex-direction: column;
                align-items: flex-start;
            }
            .header .user-info {
                margin-top: 10px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<header class="header">
    <div class="logo">Zooparc</div>
    <div class="navigation">
        <a href="http://localhost/zooparc/index.php">Home</a>
        <a href="http://localhost/zooparc/pages/member/member.php">Community</a>
        <a href="http://localhost/zooparc/pages/user/educational.php">Educational</a>
        <a href="http://localhost/zooparc/pages/user/event.php">Events</a>
        <a href="http://localhost/zooparc/pages/user/outlets.php">Shop</a>
        <a href="http://localhost/zooparc/pages/user/aboutUs.php">About Us</a>
    </div>
    <div class="user-info">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="http://localhost/zooparc/pages/logout.php" class="logout">Logout</a>
        <?php else: ?>
            <a href="http://localhost/zooparc/pages/auth.php" class="login">Login</a>
        <?php endif; ?>
    </div>
</header>
</body>
</html>
