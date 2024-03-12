<?php
require('./../database/connection.php');

$sql = "SELECT * FROM employees";

$pre_stmt = $connect->prepare($sql) or die(mysqli_error());
$pre_stmt->execute();
$result = $pre_stmt->get_result();

$employeeCounts = array(); // Store the counts of each employeeName

function formatOfficeName($officeCode) {
    // Convert the entire office name to uppercase
    return strtoupper($officeCode);
}

while ($row = mysqli_fetch_array($result)) {
    $currentEmployeeName = $row["employeeName"];
    $officeCode = $row["office"];

    // Initialize the count for the employee name if it doesn't exist
    if (!isset($employeeCounts[$currentEmployeeName])) {
        $employeeCounts[$currentEmployeeName] = 0;
    }

    // Check if the employee name has been encountered before
    $employeeCounts[$currentEmployeeName]++;

    if ($employeeCounts[$currentEmployeeName] === 2) {
        $color = generateLightColor(); // Generate a light color for the second occurrence
        $highlightedNames = '<span class="highlight">' . $currentEmployeeName . '</span>';
    } elseif ($employeeCounts[$currentEmployeeName] === 1) {
        $color = 'transparent'; // No color for the first occurrence (unique names)
        $highlightedNames = '<span class="highlight">' . $currentEmployeeName . '</span>';
    } else {
        $color = 'transparent'; // No color for additional occurrences
        $highlightedNames = $currentEmployeeName;
    }

    // Format the office name
    $formattedOffice = formatOfficeName($officeCode);

    echo '
        <tr style="background-color:' . $color . ';">
            <td>' . $highlightedNames . '</td>
            <td>' . $row["tinNo"] . '</td>
            <td>' . $row["employeeID"] . '</td>
            <td>' . $formattedOffice . '</td>
            <td>' . $row["remarks"] . '</td>
            <td>
                <a href="employee_edit.php?idNumber=' . $row["idNumber"] . '" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp;</i>Edit</a>
            </td>
        </tr>';
}

function generateLightColor() {
    // Generate a light/pastel color in hexadecimal format
    $letters = 'BCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $letters[rand(0, strlen($letters) - 1)];
    }
    return $color;
}
?>