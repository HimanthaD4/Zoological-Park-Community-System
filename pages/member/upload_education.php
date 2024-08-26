<?php
include '../../includes/functions.php';
include '../../components/userHeader.php';

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: ../auth.php');
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
    } else {
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_error = $_FILES['image']['error'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) { // 5MB max
                $file_new_name = uniqid('', true) . "." . $file_ext;
                $file_destination = '../../uploads/' . $file_new_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $image_path = $file_new_name;
                } else {
                    $error = "Failed to upload image.";
                }
            } else {
                $error = "Invalid file type or size.";
            }
        }

        // Insert the educational content
        $stmt = $conn->prepare("INSERT INTO educational_content (member_id, title, content, image_path) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $member_id, $title, $content, $image_path);

        if ($stmt->execute()) {
            header('Location: http://localhost/zooparc/pages/user/educational.php');
            exit();
        } else {
            $error = "Failed to upload content: " . $stmt->error;
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
        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background: url('../../images/bear.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container styling */
        .container {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        /* Header styling */
        .container h2 {
            font-size: 24px;
            color: #ffffff;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Alert message styling */
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        /* Form group styling */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group textarea,
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ffffff;
            box-sizing: border-box;
            background-color: #333;
            color: #ffffff;
            transition: border-color 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus,
        .form-group input[type="file"]:focus {
            border-color: #3a9d23;
            background-color: #444;
        }

        /* Button styling */
        .btn-primary {
            background-color: #3a9d23;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #317b1e;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            .container h2 {
                font-size: 20px;
            }

            .btn-primary {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Upload Educational Content</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <textarea style="color: #fff;" class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Image (optional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>
