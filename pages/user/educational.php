<?php
include '../../includes/functions.php';
session_start();

// Fetch all educational content
$contentsQuery = "SELECT * FROM educational_content ORDER BY uploaded_at DESC";
$stmt = $conn->prepare($contentsQuery);
$stmt->execute();
$contentsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Content</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Edu VIC WA NT Beginner', cursive;
            background: url('../../images/lion.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #00994d;
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
        }
    </style>
</head>
<body>
    <?php include '../../components\userHeader.php'; ?>

    <!-- Upload Button -->
    <div class="container">
      
        
        <h2>Educational Contents</h2>
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
                            <div class="card-text"><?php echo nl2br(htmlspecialchars($content['content'])); ?></div>
                        </div>
                    </div>
                    
                <?php endwhile; ?>
            <?php else: ?>
                <p>No educational content found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- JavaScript and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
