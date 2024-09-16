<?php
session_start();

// Verify if the logged-in user is an Admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
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

    <!-- Main Content Area -->
    <main>
        
    <div class="tables-container">
    <table>
    <caption><strong>Delete Customer</strong></caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php

include 'db-connect.php';

// SQL query to fetch data of customers from 'users' table
$sql = "SELECT id, name, email, user_type FROM users WHERE user_type = 'Customer'";
$result = $conn->query($sql);

// Check if query was successful
if ($result === false) {
    // Display SQL error
    echo "Error: " . $conn->error;
    exit();
}

// Check if there are results and display them in table rows
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["user_type"] . "</td>";
        // Add Edit and Delete buttons
        echo "<td><a href='edit_user.php?id=" . $row['id'] . "'>Edit</a></td>";
        echo "<td><a href='delete_user.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No customers found</td></tr>";
}
?>

           
        </tbody>
    </table>
</div>
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>
    

   
</body>
</html>
