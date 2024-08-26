<?php
include '../../../includes/functions.php';
session_start();

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: ../../auth.php');
    exit();
}

if (!isAdmin()) {
    header('Location: http://localhost/zooparc/pages/auth.php');
    exit();
}

// Get the event ID from POST data
if (isset($_POST['eventId']) && !empty($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
    
    // Prepare SQL to delete event
    $deleteQuery = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $eventId);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Event deleted successfully.';
    } else {
        $_SESSION['error'] = 'Error deleting event. Please try again.';
    }

    $stmt->close();
} else {
    $_SESSION['error'] = 'Invalid event ID.';
}

header('Location: http://localhost/zooparc/pages/admin/events/adminEvent.php');
exit();
?>
