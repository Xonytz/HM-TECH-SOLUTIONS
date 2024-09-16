<?php
session_start(); // Start the session

// Verify if the logged-in user is a Customer
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Customer') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}

include 'db-connect.php';

// Initialize variables
$oldPassword = $newPassword = $confirmPassword = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch and sanitize user inputs
    $oldPassword = trim($_POST['old_password']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);
    $customerEmail = $_SESSION['email']; // Get the current user's email from session

    // Validate old password
    if (empty($oldPassword)) {
        $errors[] = 'Please enter your old password.';
    }

    // Validate new password
    if (empty($newPassword)) {
        $errors[] = 'Please enter a new password.';
    } elseif (strlen($newPassword) < 6) {
        $errors[] = 'Password must be at least 6 characters long.';
    }

    // Validate confirm password
    if (empty($confirmPassword)) {
        $errors[] = 'Please confirm your new password.';
    } elseif ($newPassword !== $confirmPassword) {
        $errors[] = 'New password and confirm password do not match.';
    }

    // Proceed if no errors
    if (empty($errors)) {
        // Check if the old password matches the current password in the database
        $sql = "SELECT password FROM users WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $customerEmail);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            $stmt->close();

            // Verify the old password
            if (password_verify($oldPassword, $hashedPassword)) {
                // Hash the new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $sql = "UPDATE users SET password = ? WHERE email = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ss", $newHashedPassword, $customerEmail);
                    if ($stmt->execute()) {
                        echo "<script>alert('Password changed successfully. Please login again.'); window.location.href = 'logout.php';</script>";
                    } else {
                        $errors[] = 'Failed to update the password. Please try again.';
                    }
                    $stmt->close();
                }
            } else {
                $errors[] = 'Old password is incorrect.';
            }
        }
    }
}
?>


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/k.css">
    <link rel="icon" href="images/logo.png" type="image/png" />
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="profile">
            <img src="images/profile.png" alt="Profile Picture" class="profile-pic">
            <div class="dropdown">
                <button class="dropbtn">Customer</button>
                <div class="dropdown-content">
                    <a href="customer_dashboard.php">View Dashboard</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Section -->
    <aside id="sidebar">
    <nav>
        <ul>
            <!-- Dashboard Overview -->
            <li><a href="customer_dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
            
            <!-- Profile Management -->
            <li><a><i class="fa fa-user"></i> Profile Management</a>
                <ul>
                    <li><a href="view-customer-profile.php"><i class="fas fa-id-card"></i> View Profile</a></li>
                    <li><a href="edit-customer-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                    <li><a href="change-customer-password.php"><i class="fas fa-lock"></i> Change Password</a></li>
                </ul>
            </li>

            <!-- Orders Management -->
            <li><a><i class="fa fa-shopping-cart"></i> Orders Management</a>
                <ul>
                    <li><a href="view-orders.php"><i class="fas fa-shopping-bag"></i> View Orders</a></li>
                    <li><a href="track-order.php"><i class="fas fa-shipping-fast"></i> Track Order</a></li>
                    <li><a href="order-history.php"><i class="fas fa-history"></i> Order History</a></li>
                </ul>
            </li>

            <!-- Wishlist -->
            <li><a href="wishlist.php"><i class="fa fa-heart"></i> Wishlist</a></li>

            <!-- Product Catalog -->
            <li><a><i class="fa fa-box"></i> Product Catalog</a>
                <ul>
                    <li><a href="view-products.php"><i class="fas fa-boxes"></i> View All Products</a></li>
                    <li><a href="categories.php"><i class="fas fa-th-list"></i> Browse by Category</a></li>
                    <li><a href="search-products.php"><i class="fas fa-search"></i> Search Products</a></li>
                </ul>
            </li>

            <!-- Support -->
            <li><a><i class="fa fa-headset"></i> Support</a>
                <ul>
                    <li><a href="contact-support.php"><i class="fas fa-envelope"></i> Contact Support</a></li>
                    <li><a href="faq.php"><i class="fas fa-question-circle"></i> FAQ</a></li>
                </ul>
            </li>

            <!-- Announcements -->
            <li><a><i class="fa fa-bell"></i> Announcements</a>
                <ul>
                    <li><a href="view-announcements.php"><i class="fas fa-bullhorn"></i> View Announcements</a></li>
                </ul>
            </li>

            <!-- Logout -->
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</aside>

    <!-- Main Content Area -->
    <main>
    <div class="container">
        <h2>Change Password</h2>

        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo '<p>' . htmlspecialchars($error) . '</p>';
            }
            echo '</div>';
        }
        ?>

        <form action="change-customer-password.php" method="post">
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" name="old_password" id="old_password" required>
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <br/>

            <div class="form-group">
                <button type="submit" class="btn">Change Password</button>
            </div>
        </form>
    </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>
</body>
</html>
