<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZooParc - Welcome to Our Community</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner:wght@400..700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('images/113.webp') no-repeat center center fixed ;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            height: 100vh;
        }

        .hero-section {
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
           
        }

       

        .hero-section h1 {
            font-size: 4rem;
            z-index: 2;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
            color: #79d2a6;
            
        }

        .hero-section p {
            font-size: 1.5rem;
            margin-top: 20px;
            z-index: 2;
            font-family: "Edu VIC WA NT Beginner", cursive;
            
        }

        .hero-section .btn {
            margin-top: 30px;
            padding: 15px 30px;
            font-size: 1.2rem;
            z-index: 2;
            background-color: #339966;
            border: none;
            color: white;
            transition: background 0.3s ease;
            text-decoration: none;
        }

        .hero-section .btn:hover {
            background-color: #26734d;
        }

        .content-section {
            padding: 60px 20px;
            text-align: center;
            font-family: "Josefin Sans", sans-serif;
            background: rgba(0, 0, 0, 1.5);
        }

        .content-section h2 {
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #9fdfbf;
            
        }

        .content-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #e6e6e6;
            line-height: 1.6;
        }

        .icon-box {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }

        .icon-box .icon {
            font-size: 4rem;
            color: #73e600;
            margin-bottom: 10px;
        }

        .icon-box .icon-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ffffff;
        }

        .icon-box .icon-text {
            font-size: 1rem;
            color: #e6e6e6;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            padding: 30px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(0, 0, 0, 0.5);
        }

        .educational-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
            
        }

        .educational-card {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 30%;
            overflow: hidden;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }

        .educational-card:hover {
            transform: scale(1.05);
        }

        .educational-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            
        }

        .educational-card .card-body {
            padding: 15px;
        }

        .educational-card .card-title {
            font-size: 1.5rem;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .educational-card .card-text {
            color: #e6e6e6;
        }

        .btn-view-more {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            background: #00b359;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1.2rem;
            text-align: center;
            text-decoration: none;
            width: 200px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease, transform 0.3s ease;
            
        }

        .btn-view-more:hover {
            background: #00994d;
            transform: scale(1.05);
            text-decoration: none;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include 'includes/functions.php'; ?>
    <?php include 'components/userHeader.php'; ?>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Welcome to ZooParc</h1>
            <p>Your adventure begins here. Explore, learn, and be a part of our vibrant community.</p>
            <a href="pages/auth.php" class="btn">Join Us</a>
        </div>
    </div>

    <!-- Discover ZooParc Section -->
    <div class="content-section container mt-5">
        <h2>Discover ZooParc</h2>
        <p>At ZooParc, we're more than just a zoo. We're a community dedicated to the conservation and education of wildlife. Whether you're here to volunteer, learn, or just enjoy a day with the animals, there's something for everyone.</p>

        <div class="icon-box">
            <div>
                <i class="fas fa-paw icon"></i>
                <div class="icon-title">Our Animals</div>
                <div class="icon-text">Meet over 2,000 animals from 200 different species, including our famous giant pandas.</div>
            </div>
            <div>
                <i class="fas fa-leaf icon"></i>
                <div class="icon-title">Conservation</div>
                <div class="icon-text">Learn about our conservation efforts and how we're working to protect endangered species.</div>
            </div>
            <div>
                <i class="fas fa-users icon"></i>
                <div class="icon-title">Join the Community</div>
                <div class="icon-text">Become a volunteer or community member and contribute to our mission.</div>
            </div>
        </div>
    </div>

    <!-- Educational Content Section -->
    <div class="content-section container mt-5">
        <h2>Featured Educational Content</h2>
        <div class="educational-content">
            <?php
            include 'includes/db.php'; // Database connection

            // Fetch top 3 educational content
            $contentsQuery = "SELECT * FROM educational_content ORDER BY uploaded_at DESC LIMIT 3";
            $stmt = $conn->prepare($contentsQuery);
            $stmt->execute();
            $contentsResult = $stmt->get_result();

            if ($contentsResult->num_rows > 0):
                while ($content = $contentsResult->fetch_assoc()):
            ?>
                <div class="educational-card">
                    <?php if ($content['image_path']): ?>
                        <img src="uploads/<?php echo htmlspecialchars($content['image_path']); ?>" alt="<?php echo htmlspecialchars($content['title']); ?>">
                    <?php else: ?>
                        <img src="images/placeholder.jpg" alt="No image available">
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="card-title"><?php echo htmlspecialchars($content['title']); ?></div>
                        <div class="card-text"><?php echo nl2br(htmlspecialchars(substr($content['content'], 0, 100))); ?>...</div>
                        <!-- <a href="pages/educational_content.php?id=<?php echo $content['id']; ?>" class="btn-view-more">Read More</a> -->
                    </div>
                </div>
            <?php
            endwhile;
        else:
        ?>
            <p>No educational content available at the moment.</p>
        <?php endif; ?>
    </div>
    <a href="pages/member/member.php" class="btn-view-more">View All Content</a>
</div>

<!-- JavaScript and Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
