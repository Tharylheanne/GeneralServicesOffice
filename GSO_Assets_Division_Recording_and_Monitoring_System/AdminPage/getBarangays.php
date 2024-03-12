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
$query = "SELECT barangayName FROM barangay ORDER BY barangayName ASC";
$result = $connect->query($query);

if ($result) {
    $barangayOptions = array();

    while ($row = $result->fetch_assoc()) {
        $barangayOptions[] = $row['barangayName'];
    }

    echo json_encode($barangayOptions);
} else {
    echo json_encode(array()); // Return an empty array if there was an error
}

$connect->close();
?>