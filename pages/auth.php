<?php
include '../includes/functions.php';
session_start();

if (isLoggedIn()) {
    if (isAdmin()) {
        header('Location: admin/adminDashboard.php');
        exit();
    } else {
        header('Location: ../index.php');
        exit();
    }
}

$showRegister = isset($_POST['showRegister']) ? true : false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$showRegister) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        $role = login($email, $password);
        if ($role) {
            if ($role === 'admin') {
                header('Location: admin/adminDashboard.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $showRegister) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } else {
        if (register($username, $email, $password)) {
            header('Location: http://localhost/zooparc/pages/auth.php');
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
    <title>ZooParc - Login/Register</title>
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            overflow: hidden;
            background: url('../images/tiger.jpg') no-repeat center center fixed;
            background-size: cover;
            transition: background-image 0.5s ease-in-out;
        }
        .container {
            display: flex;
            height: 100%;
            transition: transform 0.5s ease;
        }
        .form-container {
            width: 50%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .form-container.left {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            backdrop-filter: blur(8px);
            transform: translateX(0);
        }
        .form-container.right {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            backdrop-filter: blur(8px);
            transform: translateX(100%);
        }
        .form-content {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
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
        .show-register .container {
            transform: translateX(-50%);
        }
        body.show-register {
            background-image: url('../images/register.jpeg');
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container left">
            <div class="form-content">
                <h2>Login as Volunteers </h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="#" class="btn btn-link" id="showRegister">Register</a>
                </form>
            </div>
        </div>
        <div class="form-container right">
            <div class="form-content">
                <h2>Register as Volunteer</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="hidden" name="showRegister" value="1">
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
                    <a href="#" class="btn btn-link" id="showLogin">Login</a>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('showRegister').addEventListener('click', function(event) {
            event.preventDefault();
            document.body.classList.add('show-register');
        });

        document.getElementById('showLogin').addEventListener('click', function(event) {
            event.preventDefault();
            document.body.classList.remove('show-register');
        });
    </script>
</body>
</html>
