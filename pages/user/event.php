<?php
include '../../includes/functions.php';
session_start();

// Fetch events
$eventsQuery = "SELECT * FROM events ORDER BY event_date DESC";
$stmt = $conn->prepare($eventsQuery);
$stmt->execute();
$eventsResult = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Events</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('../../images/elephant.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.7);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 300px;
            overflow: hidden;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
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
            display: flex;
            flex-direction: column;
            flex: 1;
        }
        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: #ffffff;
            font-weight: bolder;
        }
        .card-text {
            font-size: 1rem;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include '../../components/userHeader.php'; ?>
    <div class="container">
        <h1>All Events</h1>
        
        <!-- Display Success or Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card-container">
            <?php if ($eventsResult->num_rows > 0): ?>
                <?php while ($event = $eventsResult->fetch_assoc()): ?>
                    <div class="card">
                        <?php if ($event['image_path']): ?>
                            <img src="../../uploads/<?php echo htmlspecialchars($event['image_path']); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>">
                        <?php else: ?>
                            <img src="../../images/placeholder.jpg" alt="No image available">
                        <?php endif; ?>
                        <div class="card-content">
                            <div class="card-title"><?php echo htmlspecialchars($event['title']); ?></div>
                            <div class="card-text"><?php echo nl2br(htmlspecialchars($event['description'])); ?></div>
                            <div class="card-text"><strong>Category:</strong> <?php echo htmlspecialchars($event['category']); ?></div>
                            <div class="card-text"><strong>Tags:</strong> <?php echo htmlspecialchars($event['tags']); ?></div>
                            <div class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></div>
                            <div class="card-text"><strong>Assigned Member:</strong> <?php echo htmlspecialchars($event['member_name']); ?></div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-white">No events found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
