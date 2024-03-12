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

// Query to fetch city offices
$query = "SELECT officeName FROM nationaloffices ORDER BY officeName ASC";
$result = $connect->query($query);

if ($result) {
    $nationalOfficeOptions = array();

    while ($row = $result->fetch_assoc()) {
        $nationalOfficeOptions[] = $row['officeName'];
    }

    echo json_encode($nationalOfficeOptions);
} else {
    echo json_encode(array()); // Return an empty array if there was an error
}

$connect->close();
?>