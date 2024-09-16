<?php
include 'db-connect.php';
session_start(); // Start the session to manage user login status

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Check for Admin login
    if ($user_type == 'Admin') {
        $sql = "SELECT * FROM users WHERE email = ? AND user_type = 'Admin'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email']; // Set email session
                $_SESSION['user_type'] = 'Admin'; // Set user type session
                echo "<script>alert('Admin login successful!'); window.location.href = 'admin_dashboard.php';</script>";
            } else {
                echo "<script>alert('Incorrect admin password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('Admin user does not exist.'); window.location.href = 'login.php';</script>";
        }
    } 
    // Check for Staff login
    elseif ($user_type == 'Staff') {
        $sql = "SELECT * FROM users WHERE email = ? AND user_type = 'Staff'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_type'] = 'Staff';
                echo "<script>alert('Staff login successful!'); window.location.href = 'staff_dashboard.php';</script>";
            } else {
                echo "<script>alert('Incorrect staff password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('Staff user does not exist. window.location.href = 'login.php';');</script>";
        }
    } 
    // Check for Customer login
    elseif ($user_type == 'Customer') {
        $sql = "SELECT * FROM users WHERE email = ? AND user_type = 'Customer'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_type'] = 'Customer';
                echo "<script>alert('Customer login successful!'); window.location.href = 'customer_dashboard.php';</script>";
            } else {
                echo "<script>alert('Incorrect customer password.'); window.location.href = 'login.php';</script>";
            }
        } else {
            echo "<script>alert('Customer user does not exist.'); window.location.href = 'login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid user type selected.'); window.location.href = 'login.php';</script>";
    }
}
?>
