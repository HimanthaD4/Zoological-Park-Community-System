<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: ../auth.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: member.php');
    exit();
}

$contentId = $_GET['id'];

// Fetch the specific educational content by ID
$contentQuery = "SELECT * FROM educational_content WHERE id = ?";
$stmt = $conn->prepare($contentQuery);
$stmt->bind_param("i", $contentId);
$stmt->execute();
$contentResult = $stmt->get_result();

if ($contentResult->num_rows === 0) {
    header('Location: member.php');
    exit();
}

$content = $contentResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($content['title']); ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Edu VIC WA NT Beginner', cursive;
            background: url('../../images/parrot.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2.5rem;
            color: #00b359;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bolder;
        }

        .content-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .content-text {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #ffffff;
            text-align: justify;
            margin-bottom: 20px;
        }

        .back-btn {
            display: block;
            background: #00b359;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #00994d;
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>

    <div class="container">
        <h1><?php echo htmlspecialchars($content['title']); ?></h1>

        <?php if ($content['image_path']): ?>
            <img src="../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>" class="content-image">
        <?php endif; ?>

        <div class="content-text">
            <?php echo nl2br(htmlspecialchars($content['content'])); ?>
        </div>

        <a href="http://localhost/zooparc/pages/user/educational.php" class="back-btn"><i class="fas fa-arrow-left"></i> Back to My Contents</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
