<?php
include '../../includes/functions.php';
session_start();

if (!isLoggedIn() || isAdmin()) {
    header('Location: ../auth.php');
    exit();
}

$member_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content_id = $_POST['id'];

    // Validate content ID
    if (empty($content_id)) {
        header('Location: member.php');
        exit();
    }

    // Fetch the content to get the image path
    $stmt = $conn->prepare("SELECT image_path FROM educational_content WHERE id = ? AND member_id = ?");
    $stmt->bind_param("ii", $content_id, $member_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $content = $result->fetch_assoc();
        $image_path = $content['image_path'];

        // Delete content from database
        $stmt = $conn->prepare("DELETE FROM educational_content WHERE id = ? AND member_id = ?");
        $stmt->bind_param("ii", $content_id, $member_id);
        if ($stmt->execute()) {
            // Delete image file if it exists
            if ($image_path && file_exists('../../uploads/' . $image_path)) {
                if (!unlink('../../uploads/' . $image_path)) {
                    echo "Failed to delete image file.";
                }
            }
            header('Location: member.php');
            exit();
        } else {
            echo "Failed to delete content: " . $stmt->error;
        }
    } else {
        echo "Content not found or you don't have permission to delete it.";
    }
}
?>
