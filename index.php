<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zoopac - Dashboard</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/functions.php'; ?>
    <?php include 'header.php'; ?>
    <div class="container mt-5">
       
        <h1>Welcome to Zoopac Zoo</h1>
        <?php if (!isLoggedIn()): ?>
            <a href="pages/login.php" class="btn btn-primary">Login</a>
        <?php else: ?>
            <a href="pages/member.php" class="btn btn-primary">Member Page</a>
        <?php endif; ?>
        <a href="pages/register.php" class="btn btn-secondary">Register</a>
    </div>
</body>
</html>
