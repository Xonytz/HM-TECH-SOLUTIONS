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

    // Fetch user details
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Update user details
        $name = $_POST['name'];
        $email = $_POST['email'];
        $user_type = $_POST['user_type'];

        $update_sql = "UPDATE users SET name='$name', email='$email', user_type='$user_type' WHERE id = $user_id";
        
        if ($conn->query($update_sql) === TRUE) {
            echo "<script>alert('User details updated successfully.'); window.location.href = 'admin_dashboard.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "<script>alert('No user ID provided.'); window.location.href = 'admin_dashboard.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="css/adminedit.css" />
    <link rel="icon" href="images/logo.png" type="image/png" />
</head>
<body>
    <h2>Edit User Details</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
        <label for="user_type">User Type:</label>
        <select name="user_type" required>
            <option value="Admin" <?php if ($user['user_type'] == 'Admin') echo 'selected'; ?>>Admin</option>
            <option value="Staff" <?php if ($user['user_type'] == 'Staff') echo 'selected'; ?>>Staff</option>
            <option value="Customer" <?php if ($user['user_type'] == 'Customer') echo 'selected'; ?>>Customer</option>
        </select><br><br>
        <input type="submit" value="Update User">
        <button class="return-button" onclick="window.location.href='admin_dashboard.php';">Back</button>
    </form>
</body>
</html>
