<?php
include 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $user_type = $_POST['user_type'];

    // Prevent users from signing up as Admin
    if ($user_type == 'Admin') {
        echo "<script>alert('You are not allowed to register as Admin.'); window.location.href = 'login.php';</script>";
        exit();
    }

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $user_type);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful. Please sign in.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error occurred during registration. Please try again.');</script>";
        }
    }
}
?>
