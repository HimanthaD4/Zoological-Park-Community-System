<?php
include '../../../includes/functions.php';
session_start();

// Check if user is logged in and is an admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../../auth.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contentId = $_POST['contentId'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image'];

    if (empty($title) || empty($content)) {
        $_SESSION['error'] = 'Title and content are required.';
        header('Location: http://localhost/zooparc/pages/admin/contents/adminContent.php');
        exit();
    }

    // Handle image upload if provided
    if ($image['error'] === UPLOAD_ERR_OK) {
        $imagePath = basename($image['name']);
        $uploadDir = '../../../uploads/';
        $uploadFile = $uploadDir . $imagePath;

        if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
            $imageSql = ", image_path = ?";
            $imageParam = $imagePath;
        } else {
            $_SESSION['error'] = 'Image upload failed.';
            header('Location: http://localhost/zooparc/pages/admin/contents/adminContent.php');
            exit();
        }
    } else {
        $imageSql = "";
        $imageParam = null;
    }

    // Update content
    $sql = "UPDATE educational_content SET title = ?, content = ? $imageSql WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($imageSql) {
        $stmt->bind_param('sssi', $title, $content, $imageParam, $contentId);
    } else {
        $stmt->bind_param('ssi', $title, $content, $contentId);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Content updated successfully.';
    } else {
        $_SESSION['error'] = 'Failed to update content.';
    }

    header('Location: http://localhost/zooparc/pages/admin/contents/adminContent.php');
    exit();
}
?>
