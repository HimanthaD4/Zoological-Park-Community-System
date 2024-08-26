<?php
include '../../../includes/functions.php';
session_start();

// Ensure user is logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Get the logged-in user's ID from the session
$member_id = $_SESSION['user_id'];

// Include the database connection
require_once '../../../includes/db.php';

// Fetch members from the database
$query = "SELECT id, username FROM users WHERE role = 'member'";
$result = $conn->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $tags = trim($_POST['tags']);
    $event_date = trim($_POST['event_date']);
    $assigned_member_id = trim($_POST['assigned_member_id']); // Retrieve selected member ID
    $image_path = null;
    $error = '';
    $success = '';

    // Validate inputs
    if (empty($title) || empty($description) || empty($category) || empty($event_date) || empty($assigned_member_id)) {
        $error = "Title, description, category, event date, and assigned member are required.";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        $error = "Image upload is required.";
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
        } else {
            $error = "Failed to upload image.";
        }
    }

    // If no errors, insert the event
    if (empty($error)) {
        // Fetch member's name based on the selected member ID
        $member_query = $conn->prepare("SELECT username FROM users WHERE id = ?");
        $member_query->bind_param("i", $assigned_member_id);
        $member_query->execute();
        $member_query->bind_result($member_name);
        $member_query->fetch();
        $member_query->close();

        // Insert event into database with member's name
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, category, tags, image_path, member_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $title, $description, $event_date, $category, $tags, $image_path, $member_name);

        if ($stmt->execute()) {
            header('Location: http://localhost/zooparc/pages/admin/events/adminEvent.php');
            exit();
        } else {
            $error = "Failed to schedule event: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Event</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            background-color: #f0f2f5;
        }
        .container {
            margin-left: 250px; /* Sidebar width */
            padding: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            max-width: 900px;
            margin: 20px auto;
        }
        .container h2 {
            color: #004d40;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 1.1rem;
            color: #004d40;
        }
        .form-control {
            border-radius: 5px;
            border: 1px solid #004d40;
            padding: 12px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 15px;
            height: 40px;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .form-control:focus {
            border-color: #00796b;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #004d40;
            border: none;
            color: white;
            padding: 12px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #00796b;
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: white;
        }
        .alert-success {
            background-color: #4caf50;
        }
        .alert-danger {
            background-color: #f44336;
        }
        .image-preview {
            margin-bottom: 15px;
        }
        .image-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            .container {
                margin-left: 200px;
            }
        }
        @media (max-width: 480px) {
            .container {
                margin-left: 0;
                padding: 10px;
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
    <script>
        function previewImage(input) {
            const file = input.files[0];
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#eventDate", {
                dateFormat: "Y-m-d",
            });
        });
    </script>
</head>
<body>
    <?php include '../../../components/adminSidebar.php'; ?> 
    <div class="container">
        <h2>Schedule Event</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Animal Encounters">Animal Encounters</option>
                    <option value="Feeding Sessions">Feeding Sessions</option>
                    <option value="Zoo Tours">Zoo Tours</option>
                    <option value="Educational Workshops">Educational Workshops</option>
                    <option value="Conservation Talks">Conservation Talks</option>
                    <option value="Animal Adoption Events">Animal Adoption Events</option>
                    <option value="Wildlife Photography">Wildlife Photography</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Tags (comma-separated)</label>
                <input type="text" id="tags" name="tags" class="form-control">
            </div>
            <div class="form-group">
                <label for="eventDate">Event Date</label>
                <input type="text" id="eventDate" name="event_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="assigned_member">Assign Member</label>
                <select id="assigned_member" name="assigned_member_id" class="form-control" required>
                    <option value="">Select Member</option>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['username']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="image">Event Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" onchange="previewImage(this)" required>
                <div class="image-preview mt-3">
                    <img id="imagePreview" src="#" alt="Image Preview">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Schedule Event</button>
        </form>
    </div>
</body>
</html>
