<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: member.php');
    exit();
}

$content_id = $_GET['id'];

// Fetch the full educational content
$contentQuery = "SELECT * FROM educational_content WHERE id = ?";
$stmt = $conn->prepare($contentQuery);
$stmt->bind_param("i", $content_id);
$stmt->execute();
$contentResult = $stmt->get_result();
$content = $contentResult->fetch_assoc();

if (!$content) {
    header('Location: member.php');
    exit();
}
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
            background: url('../../images/11.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .bb {
            padding-bottom: 10px;
            padding-top: 10px;
            background: rgba(0, 0, 0, 0.5);
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }
        .content-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .content-text {
            font-size: 1.2rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>
    <div class="bb">
        <div class="container">
            <h1><?php echo htmlspecialchars($content['title']); ?></h1>
            <?php if ($content['image_path']): ?>
                <img src="../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>" class="content-image">
            <?php else: ?>
                <img src="../images/placeholder.jpg" alt="No image available" class="content-image">
            <?php endif; ?>
            <div class="content-text">
                <?php echo nl2br(htmlspecialchars($content['content'])); ?>
            </div>
        </div>
    </div>
</body>
</html>
