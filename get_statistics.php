<?php
include 'db-connect.php';

// Query to fetch statistics
$sql = "
    SELECT 
        COUNT(*) AS total_users,
        SUM(user_type = 'Admin') AS total_admins,
        SUM(user_type = 'Staff') AS total_staff,
        SUM(user_type = 'Customer') AS total_customers
    FROM users;
";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Return data as JSON
    echo json_encode([
        "total_users" => $row['total_users'],
        "total_admins" => $row['total_admins'],
        "total_staff" => $row['total_staff'],
        "total_customers" => $row['total_customers']
    ]);
} else {
    echo json_encode([
        "error" => "No data found"
    ]);
}

$conn->close();
?>
