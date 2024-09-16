<?php
session_start();

// Only allow admins to access this page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}

include 'db-connect.php';

// Check if user ID is passed
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // SQL to delete user
    $sql = "DELETE FROM users WHERE id = $user_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User deleted successfully.'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "<script>alert('No user ID provided.'); window.location.href = 'admin_dashboard.php';</script>";
}
?>
