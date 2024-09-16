<?php
session_start();

// Verify if the logged-in user is a Staff member
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Staff') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
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
                <button class="dropbtn">Staff</button>
                <div class="dropdown-content">
                    <a href="staff_dashboard.php">View Dashboard</a>
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
            <li><a href="staff_dashboard.php"><i class="fa fa-tachometer"></i> Dashboard</a></li>
            
            <!-- Profile Management -->
            <li><a><i class="fa fa-user"></i> Profile Management</a>
                <ul>
                    <li><a href="view-staff-profile.php"><i class="fas fa-id-card"></i> View Profile</a></li>
                    <li><a href="edit-staff-profile.php"><i class="fas fa-user-edit"></i> Edit Profile</a></li>
                    <li><a href="change-staff-password.php"><i class="fas fa-lock"></i> Change Password</a></li>
                </ul>
            </li>

            <!-- Task Management -->
            <li><a><i class="fa fa-tasks"></i> Task Management</a>
                <ul>
                    <li><a href="view-tasks.php"><i class="fas fa-tasks"></i> View Assigned Tasks</a></li>
                    <li><a href="add-task.php"><i class="fas fa-plus-circle"></i> Create New Task</a></li>
                    <li><a href="completed-tasks.php"><i class="fas fa-check-circle"></i> Completed Tasks</a></li>
                </ul>
            </li>

            <!-- Project Management -->
            <li><a><i class="fa fa-project-diagram"></i> Project Management</a>
                <ul>
                    <li><a href="view-projects.php"><i class="fas fa-list"></i> View Projects</a></li>
                    <li><a href="update-project-status.php"><i class="fas fa-tasks"></i> Update Project Status</a></li>
                </ul>
            </li>

            <!-- Product Inventory  -->
            <li><a><i class="fa fa-box"></i> Product Inventory</a>
                <ul>
                    <li><a href="view-products.php"><i class="fas fa-box"></i> View Product Details</a></li>
                    <li><a href="add-product.php"><i class="fas fa-plus-circle"></i> Add New Product</a></li>
                    <li><a href="edit-product.php"><i class="fas fa-edit"></i> Edit Product Information</a></li>
                </ul>
            </li>

            <!-- Announcements -->
            <li><a><i class="fa fa-bell"></i> Announcements</a>
                <ul>
                    <li><a href="announcements.php"><i class="fas fa-bullhorn"></i> View Announcements</a></li>
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
                <h3>Welcome <?php echo htmlspecialchars($_SESSION['email']); ?>!</h3>
                <p>Let's work as a Team !!</p>
               
            </div>
            <div class="widget" id="timestamp">
                   
            </div>
        
            
        </div>
        <br/><br/>




        
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>
    

    <script src="js/time.js"></script>
   
</body>
</html>


