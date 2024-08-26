<?php
include '../../../includes/functions.php';
session_start();

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: ../../auth.php');
    exit();
}

// Get the logged-in user's ID from the session
$member_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = null;

    // Validate inputs
    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        $error = "An image is required.";
    } else {
        // Handle file upload
        if ($_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) { // 5MB max
                $file_new_name = uniqid('', true) . "." . $file_ext;
                $file_destination = '../../../uploads/' . $file_new_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $image_path = $file_new_name;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type or size.";
            }
        }
        
        // Insert the educational content if no error occurred
        if (!isset($error)) {
            $stmt = $conn->prepare("INSERT INTO educational_content (member_id, title, content, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $member_id, $title, $content, $image_path);

            if ($stmt->execute()) {
                // Redirect with a success message
                header('Location: http://localhost/zooparc/pages/admin/contents/adminContent.php?success=1');
                exit();
            } else {
                $error = "Failed to upload content: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Educational Content</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin: 20px;
        }
        .container h2 {
            color: #004d40;
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .form-group label {
            font-size: 1rem;
            color: #004d40;
            font-weight: 500;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 15px;
            font-size: 1rem;
            color: #333;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #00796b;
            box-shadow: 0 0 10px rgba(0, 121, 107, 0.2);
        }
        .btn-primary {
            background-color: #004d40;
            border: none;
            color: white;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #00796b;
            transform: translateY(-2px);
        }
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1rem;
            color: white;
            text-align: center;
        }
        .alert-success {
            background-color: #4caf50;
        }
        .alert-danger {
            background-color: #f44336;
        }
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include '../../../components/adminSidebar.php'; ?> 
    <div class="container">
        <h2>Upload Educational Content</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (required)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>
