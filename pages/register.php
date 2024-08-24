<?php
include '../includes/functions.php';
if (isLoggedIn()) {
    header('Location: member.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        // Proceed with registration
        if (register($username, $email, $password)) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Registration failed";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoopac - Register</title>
    <style>
        body {
            background: url('../images/112.webp') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #ffffff;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-left: 700px;
        }
        h2 {
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            color: #ffffff;
            display: block;
            margin-bottom: 5px;
            font-size: 16px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 5px;
            padding: 10px;
            color: #000000;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 5px;
        }
        .form-control:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.5);
        }
        .btn-primary {
            background-color: #00b359;
            border: none;
            border-radius: 5px;
            padding: 15px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #00994d;
        }
        .btn-link {
            color: #ccffe6;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 16px;
        }
        .btn-link:hover {
            color: #99ffcc;
        }
        .alert-danger {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
            color: rgba(255, 0, 0, 0.9);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-link">Login</a>
        </form>
    </div>
</body>
</html>
