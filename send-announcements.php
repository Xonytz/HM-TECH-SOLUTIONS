<?php
session_start();

// Verify if the logged-in user is an Admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'Admin') {
    echo "<script>alert('Unauthorized access. Redirecting to login.'); window.location.href = 'login.php';</script>";
    exit();
}

include 'db-connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientType = $_POST['recipient_type'];
    $recipientId = $_POST['recipient_id'];
    $message = $_POST['message'];
    
    // Validate inputs
    if (empty($message)) {
        $error = "Message cannot be empty.";
    } else {
        $query = "";
        if ($recipientType === 'individual') {
            $query = "INSERT INTO announcements (recipient_id, recipient_type, message) VALUES (?, ?, ?)";
        } else if ($recipientType === 'group') {
            $query = "INSERT INTO announcements (recipient_id, recipient_type, message) VALUES (NULL, ?, ?)";
        }
        
        if ($stmt = $conn->prepare($query)) {
            if ($recipientType === 'individual') {
                $stmt->bind_param("sss", $recipientId, $recipientType, $message);
            } else {
                $stmt->bind_param("ss", $recipientType, $message);
            }
            $stmt->execute();
            $stmt->close();
            $success = "Announcement sent successfully!";
        } else {
            $error = "Error preparing statement: " . $conn->error;
        }
    }
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
    <link rel="stylesheet" href="css/n.css">
    <link rel="icon" href="images/logo.png" type="image/png" />
    <script>
        function toggleRecipientField() {
            const recipientType = document.querySelector('input[name="recipient_type"]:checked').value;
            const recipientField = document.getElementById('recipient-field');
            recipientField.style.display = recipientType === 'individual' ? 'block' : 'none';
        }
    </script>
   
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
                  <li><a href="send-announcements.php"><i class="fas fa-plus-circle"></i>Send Announcements</a></li>
                  </ul>
                </li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Main Content Area -->
    <main>
    <h1>Send Announcements</h1>
        
        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form action="send-announcements.php" method="POST">
            <div>
                <label><input type="radio" name="recipient_type" value="individual" onclick="toggleRecipientField()" checked> Individual</label>
                <label><input type="radio" name="recipient_type" value="group" onclick="toggleRecipientField()"> Group</label>
            </div>

            <div id="recipient-field">
                <label for="recipient_id">Select Recipient:</label>
                <select name="recipient_id" id="recipient_id">
                    <?php
                    // Fetch users for individual announcement
                    $sql = "SELECT id, name FROM users WHERE user_type = 'Customer' OR user_type = 'Staff'"; // Customize as needed
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"" . $row['id'] . "\">" . $row['name'] . "</option>";
                        }
                    } else {
                        echo "<option value=\"\">No recipients available</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="message">Announcement Message:</label>
                <textarea name="message" id="message" rows="5" required></textarea>
            </div>

            <button type="submit">Send Announcement</button>
        </form>


       
    </main>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 HM Tech Solutions | All Rights Reserved.</p>
    </footer>
    

   
</body>
</html>
