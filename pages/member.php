<?php
include '../includes/functions.php';
session_start();

if (!isLoggedIn() || isAdmin()) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <style>
        body {
            background-color: #e0f7fa;
            font-family: Arial, sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            margin-top: 50px;
        }
        h2 {
            color: #004d40;
        }
        .btn-logout {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-logout:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>
<?php include '../header.php'; ?>
    <div class="container">
        <h2>Member Dashboard</h2>
        <!-- Member dashboard content here -->
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>
