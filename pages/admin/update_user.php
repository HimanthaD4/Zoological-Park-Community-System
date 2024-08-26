<?php
include '../../includes/functions.php';
include '../../includes/db.php';
session_start();

// Check if the user is logged in and is an admin
if (!isLoggedIn() || !isAdmin()) {
    header('Location: ../index.php');
    exit();
}

// Handle update user action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($role)) {
        $errorMessage = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $email, $role, $userId);
        if ($stmt->execute()) {
            $successMessage = "User details updated successfully.";
        } else {
            $errorMessage = "Error updating user details.";
        }
    }
}

header('Location: adminUsers.php'); // Redirect to the user management page after update
exit();
?>
