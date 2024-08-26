<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn() || isAdmin()) {
    header('Location: ../auth.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = '';

    // Check if an image file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = basename($_FILES["image"]["name"]);
        } else {
            echo "Failed to upload image.";
            exit();
        }
    } else {
        // If no new image is uploaded, retain the existing image path
        $stmt = $conn->prepare("SELECT image_path FROM educational_content WHERE id = ? AND member_id = ?");
        $stmt->bind_param("ii", $content_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];
    }

    // Update the educational content in the database
    $stmt = $conn->prepare("UPDATE educational_content SET title = ?, content = ?, image_path = ? WHERE id = ? AND member_id = ?");
    $stmt->bind_param("sssii", $title, $content, $image_path, $content_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        header('Location: member.php');
        exit();
    } else {
        echo "Failed to update content: " . $stmt->error;
    }
}
?>
