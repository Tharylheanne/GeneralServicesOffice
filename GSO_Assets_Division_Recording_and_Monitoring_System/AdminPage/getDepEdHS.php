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

// Query to fetch high school names
$query = "SELECT highSchoolName FROM highschool ORDER BY highSchoolName ASC";
$result = $connect->query($query);

if ($result) {
    $highSchoolOptions = array();

    while ($row = $result->fetch_assoc()) {
        $highSchoolOptions[] = $row['highSchoolName'];
    }

    echo json_encode($highSchoolOptions);
} else {
    echo json_encode(array()); // Return an empty array if there was an error
}

$connect->close();
?>