<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required data is received
    if (isset($_POST['propertyID'], $_POST['columnName'], $_POST['newValue'])) {
        // Retrieve the data sent via POST
        $propertyID = $_POST['propertyID'];
        $columnName = $_POST['columnName'];
        $newValue = $_POST['newValue'];

        // Perform any necessary validation and sanitization here

        // Connect to your database (replace dbname, username, password with your actual database credentials)
        $pdo = new PDO('mysql:host=localhost;dbname=gso_asset', 'root', 'password');

        // Update statement template for each table
        $updateStatements = [
            'generalproperties' => "UPDATE generalproperties SET $columnName = :newValue WHERE propertyID = :propertyID",
            'are_ics_gen_properties' => "UPDATE are_ics_gen_properties SET $columnName = :newValue WHERE propertyID = :propertyID",
            'are_properties' => "UPDATE are_properties SET $columnName = :newValue WHERE propertyID = :propertyID",
            'ics_properties' => "UPDATE ics_properties SET $columnName = :newValue WHERE propertyID = :propertyID"
        ];

        // Check if the table name exists in the updateStatements array
        if (array_key_exists($columnName, $updateStatements)) {
            // Prepare SQL statement to update the corresponding table
            $stmt = $pdo->prepare($updateStatements[$columnName]);

            // Bind parameters
            $stmt->bindParam(':newValue', $newValue);
            $stmt->bindParam(':propertyID', $propertyID);

            // Execute the SQL statement
            if ($stmt->execute()) {
                // Return a success message
                echo json_encode(['success' => true, 'message' => 'Data updated successfully']);
            } else {
                // Return an error message
                echo json_encode(['success' => false, 'message' => 'Failed to update data']);
            }
        } else {
            // Return an error message if the table name is invalid
            echo json_encode(['success' => false, 'message' => 'Invalid table name']);
        }
    } else {
        // Return an error message if required data is missing
        echo json_encode(['success' => false, 'message' => 'Missing required data']);
    }
} else {
    // Return an error message if the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>