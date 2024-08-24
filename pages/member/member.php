<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$member_id = $_SESSION['user_id'];

// Fetch educational content created by the logged-in user
$contentsQuery = "SELECT * FROM educational_content WHERE member_id = ? ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($contentsQuery);
$stmt->bind_param("i", $member_id);
$stmt->execute();
$contentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
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
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .upload-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #00b359;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            width: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.3s ease;
        }
        .upload-btn:hover {
            background: #00994d;
            transform: scale(1.05);
            text-decoration: none;
            color: #fff;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 300px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-content {
            padding: 15px;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #ffffff;
            font-weight: bolder;
            padding-bottom: 10px;
        }
        .card-text {
            font-size: 1rem;
            color: #ffffff;
            height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word;
            margin-bottom: 10px;
        }
        .show-more-btn {
            display: block;
            background: #00b359;
            color: #fff;
            padding: 8px;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background 0.3s ease;
        }
        .show-more-btn:hover {
            background: #00994d;
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>
    <div class="bb">
        <div class="container">
            <a class="upload-btn" href="upload_education.php">Upload Educational Content</a>
            <h2>My Contents</h2>
            <div class="card-container">
                <?php if ($contentsResult->num_rows > 0): ?>
                    <?php while ($content = $contentsResult->fetch_assoc()): ?>
                        <div class="card">
                            <?php if ($content['image_path']): ?>
                                <img src="../../uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>">
                            <?php else: ?>
                                <img src="../images/placeholder.jpg" alt="No image available">
                            <?php endif; ?>
                            <div class="card-content">
                                <div class="card-title"><?php echo htmlspecialchars($content['title']); ?></div>
                                <div class="card-text">
                                    <?php 
                                    $contentPreview = strlen($content['content']) > 100 ? substr($content['content'], 0, 100) . '...' : $content['content'];
                                    echo nl2br(htmlspecialchars($contentPreview));
                                    ?>
                                </div>
                                <a href="viewContent.php?id=<?php echo $content['id']; ?>" class="show-more-btn">Show More</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No educational content found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>