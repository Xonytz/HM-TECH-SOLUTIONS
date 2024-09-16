<?php
session_start();

// Check if the user is an Admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}

include 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $user_type = 'Customer';  // Ensure the user type is always 'Customer'

    // Check if email already exists
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
    } else {
        // Insert new customer into the database
        $sql = "INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $user_type);

        if ($stmt->execute()) {
            echo "<script>alert('Customer added successfully.'); window.location.href = 'view-all-customers.php';</script>";
        } else {
            echo "<script>alert('Error adding customer. Please try again.');</script>";
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Customer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/addcustomer.css">
    <link rel="icon" href="images/logo.png" type="image/png" />
</head>
<body>
    <!-- Header Section -->
    <header>
        <div class="profile">
            <img src="images/profile.png" alt="Profile Picture" class="profile-pic">
            <div class="dropdown">
                <button class="dropbtn">Admin</button>
                <div class="dropdown-content">
                    <a href="admin_dashboard.php">View Dashboard</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar Section -->
    <aside id="sidebar">
        <nav>
            <ul>
                <li><a href="admin_dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
                <li><a ><i class="fa fa-users"></i> Customer Management</a>
                    <ul>
                          <li><a href="view-all-customers.php"><i class="fas fa-users"></i> View All Customers</a></li>
                          <li><a href="add-new-customer.php"><i class="fas fa-user-plus"></i> Add New Customer</a></li>
                          <li><a href="delete-customer.php"><i class="fas fa-user-minus"></i> Delete Customer</a></li>

                    </ul>
                </li>
                <li><a ><i class="fa fa-user-cog"></i> Staff Management</a>
                    <ul>
                          <li><a href="#"><i class="fas fa-users"></i> View All Staffs</a></li>
                          <li><a href="#"><i class="fas fa-user-plus"></i> Add New Staff</a></li>
                          <li><a href="#"><i class="fas fa-user-minus"></i> Delete Staff</a></li>
                    </ul>
                </li>

                <li><a href="#"><i class="fa fa-project-diagram"></i> Projects Management</a>
                    <ul>
                        <li><a ><i class="fas fa-microchip"></i> Electronics & Telecommunications Projects</a></li>
                        <li><a href="#"><i class="fas fa-laptop-code"></i> Computer Projects</a></li>
                        <li><a href="#"><i class="fas fa-bolt"></i> Electrical Projects</a></li>
                    </ul>
                </li>
                <li><a ><i class="fa fa-box"></i> Product Inventory</a>
                    <ul>
                   
                    <li><a href="#"><i class="fas fa-box"></i> View Product Details</a></li>
                    <li><a href="#"><i class="fas fa-plus-circle"></i> Add New Product</a></li>
                    <li><a href="#"><i class="fas fa-edit"></i> Edit Product Information</a></li>
                    <li><a href="#"><i class="fas fa-trash-alt"></i> Delete Product</a></li>

                    </ul>
                </li>

                <li><a ><i class="fa fa-bell"></i> Announcements</a>
                  <ul>
                  <li><a href="#"><i class="fas fa-plus-circle"></i>Send Announcements</a></li>
                  </ul>
                </li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Section -->
    <main>
        <div class="form-container">
            <form method="POST" action="add-new-customer.php">
                <h2 style="color: #001f3f;">Add New Customer</h2>
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="submit-btn">Add Customer</button>
            </form>
        </div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>

</body>
</html>
