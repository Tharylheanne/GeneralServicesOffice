<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'gso_asset';

$connect = new mysqli($host, $username, $password, $database);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Query to fetch barangay options
$query = "SELECT elemName FROM elementary ORDER BY elemName ASC";
$result = $connect->query($query);

if ($result) {
    $elemOptions = array();

    while ($row = $result->fetch_assoc()) {
        $elemOptions[] = $row['elemName'];
    }

    echo json_encode($elemOptions);
} else {
    echo json_encode(array()); // Return an empty array if there was an error
}

$connect->close();
?>