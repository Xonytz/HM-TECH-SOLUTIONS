<?php
session_start(); // Start the session

// Verify if the logged-in user is a Customer
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Customer') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}

include 'db-connect.php';

// Retrieve the logged-in customer's email from the session
$email = $_SESSION['email'];

// Prepare the SQL query to fetch the customer's details
$sql = "SELECT name, email FROM users WHERE email = ? AND user_type = 'Customer'";

// Prepare the statement
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

// Fetch the customer's details
if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
} else {
    echo "<script>alert('No customer details found.'); window.location.href = 'customer_dashboard.php';</script>";
    exit();
}

// Handle the form submission for updating customer profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Prepare the SQL query to update the customer's details
    $update_sql = "UPDATE users SET name = ?, email = ? WHERE email = ? AND user_type = 'Customer'";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("sss", $new_name, $new_email, $email);

    // Execute the update query
    if ($update_stmt->execute()) {
        $_SESSION['email'] = $new_email; // Update session email if changed
        echo "<script>alert('Profile updated successfully.'); window.location.href = 'view-customer-profile.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile.'); window.location.href = 'edit-customer-profile.php';</script>";
    }

    $update_stmt->close();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/y.css">
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
        <div class="widget-container">
            <div class="widget">
                <h3>Edit Customer Profile</h3>
                <form action="edit-customer-profile.php" method="post">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>

                    <button type="submit" class="btn">Update Profile</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>
</body>
</html>
