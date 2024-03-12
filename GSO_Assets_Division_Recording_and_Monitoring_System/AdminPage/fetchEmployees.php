<?php
if (isset($_GET['office'])) {
    $selectedOffice = $_GET['office'];
    
    // Your database connection code here
    // Make sure to establish a database connection and handle errors properly

    // Example connection code:
    // Database connection parameters (update with your actual database details)
    $dbHost = 'localhost';
    $dbName = 'gso_asset';
    $dbUsername = 'root';
    $dbPassword = '';
    $connect = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    // Check if the database connection is successful
    if ($connect->connect_error) {
        die("Connection failed: " . $connect->connect_error);
    }

    // Prepare and execute a SQL query to fetch employees in the selected office
    $sql = "SELECT employeeName FROM employees WHERE office = ? ORDER BY employeeName";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("s", $selectedOffice);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the results as an associative array
    $employees = array();
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row['employeeName'];
    }

    // Return the employees as a JSON response
    echo json_encode($employees);

    // Close the database connection
    $connect->close();
} else {
    // If the 'office' parameter is not set, return an empty array
    echo json_encode(array());
}
?>