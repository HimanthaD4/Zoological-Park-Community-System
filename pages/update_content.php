<?php
include '../includes/functions.php';
session_start();

if (!isLoggedIn() || isAdmin()) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content_id = $_POST['contentId'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = basename($_FILES["image"]["name"]);
        }
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
