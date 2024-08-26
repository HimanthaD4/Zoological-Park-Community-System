<?php
include '../../../includes/functions.php';
include '../../../includes/db.php';
session_start();

if (!isLoggedIn()) {
    header('Location: ../../auth.php');
    exit();
}

if (!isAdmin()) {
    header('Location: http://localhost/zooparc/pages/auth.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_id = $_POST['eventId'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $tags = trim($_POST['tags']);
    $event_date = trim($_POST['event_date']);
    $member_name = trim($_POST['member_name']);
    $new_image_path = null;

    if (empty($title) || empty($description) || empty($category) || empty($event_date) || empty($member_name)) {
        $error = "All fields are required.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) {
                $file_new_name = uniqid('', true) . "." . $file_ext;
                $file_destination = '../../../uploads/' . $file_new_name;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $new_image_path = $file_new_name;
                } else {
                    $error = "Failed to upload new image.";
                }
            } else {
                $error = "Invalid file type or size.";
            }
        }

        if (empty($new_image_path)) {
            $stmt = $conn->prepare("SELECT image_path FROM events WHERE id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $event = $result->fetch_assoc();
            $new_image_path = $event['image_path'];
        }

        if (empty($error)) {
            $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, event_date = ?, category = ?, tags = ?, image_path = ?, member_name = ? WHERE id = ?");
            $stmt->bind_param("sssssssi", $title, $description, $event_date, $category, $tags, $new_image_path, $member_name, $event_id);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Event updated successfully.";
                header('Location: http://localhost/zooparc/pages/admin/events/adminEvent.php');
                exit();
            } else {
                $error = "Failed to update event: " . $stmt->error;
            }
        }
    }

    if (isset($error)) {
        $_SESSION['error'] = $error;
        header('Location: http://localhost/zooparc/pages/admin/events/adminEvent.php');
        exit();
    }
}
?>
