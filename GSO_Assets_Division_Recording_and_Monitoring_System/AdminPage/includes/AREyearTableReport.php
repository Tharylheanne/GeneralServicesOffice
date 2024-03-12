<?php
    require('./../database/connection.php');
    /*require('../login/login_session.php');*/

    // Check if an accountable person parameter is provided in the URL
    if (isset($_GET['dateYear'])) {
        $dateYear = urldecode($_GET['dateYear']);

        /*$formattedYear = date('m-d-Y', strtotime($YearDate));*/
        if (preg_match('/^\d{4}$/', $dateYear)) {
            $formattedYear = $dateYear . '01-01';
            $endDate = $dateYear . '12-31';

        // SQL query to retrieve property information
        $sql = "SELECT ap.*, gp.*, agp.*, ac.accountNumber AS classification,
                COALESCE(co.officeName, no.officeName) AS officeName,
                c.conditionName AS currentCondition
                FROM are_properties ap
                LEFT JOIN are_ics_gen_properties agp ON ap.ARE_ICS_id = agp.ARE_ICS_id
                LEFT JOIN generalproperties gp ON ap.propertyID = gp.propertyID
                LEFT JOIN account_codes ac ON gp.accountNumber = ac.accountNumber
                LEFT JOIN cityoffices co ON gp.officeName = co.officeName
                LEFT JOIN nationaloffices no ON gp.officeName = no.officeName
                LEFT JOIN conditions c ON agp.currentCondition = c.conditionName
                WHERE date_format(agp.dateReceived, '%Y') = ?";

        // Prepare the SQL statement
        $stmt = $connect->prepare($sql);

        // Bind parameters and execute the statement
        if ($stmt) {
            $stmt->bind_param("s", $dateYear);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check for errors in query execution
            if (!$result) {
                echo "Error in query execution: " . mysqli_error($connect);
                exit;
            }

            // Fetch and display the ARE properties
            if ($result->num_rows > 0) {
                echo "<h3 id='printTitle' style='text-align: center; line-height: 2em;'>Report on Physical Count of Property, Plant, and Equipment<br>Year: <span style='text-decoration: underline;'>$dateYear</span><br> (Type of Property, Plant, and Equipment) </h3>";

                // Display the table
                echo "<div class='table-responsive'>";
                echo "<div style='max-height:200%; overflow-y:auto;'>";
                echo "<table id='AREperYearTable' name = 'AREperYearTable' class='table table-bordered table-striped'>";
                // Table header
                echo "<thead>
                        <tr>
                            <th class='dateRecorded' rowspan='2' class='additional-details'>DATE RECORDED</th>
                            <th rowspan='2'>ARTICLE</th>
                            <th class='subcolumn' colspan='4' style='text-align:center;'>DESCRIPTION</th>
                            <th rowspan='2'>eNGAS PROPERTY NUMBER</th>
                            <th rowspan='2'>ACQUISITION DATE</th>
                            <th rowspan='2'>ACQUISITION COST</th>
                            <th rowspan='2'>PROPERTY NO.</th>
                            <th rowspan='2'>CLASSIFICATION</th>
                            <th rowspan='2'>EST. USEFUL LIFE</th>
                            <th rowspan='2'>UNIT OF MEASURE</th>
                            <th rowspan='2'>UNIT VALUE</th>
                            <th rowspan='2'>BALANCE PER CARD QTY</th>
                            <th rowspan='2'>ON HAND PER COUNT QTY</th>
                            <th class='subcolumn' colspan='2'>SHORTAGE/OVERAGE</th>
                            <th rowspan='2' style='white-space: nowrap;'>RESPONSIBILITY CENTER</th>
                            <th rowspan='2' style='white-space: nowrap;'>ACCOUNTABLE PERSON</th>
                            <th rowspan='2'>PREVIOUS CONDITION</th>
                            <th rowspan='2'>LOCATION</th>
                            <th rowspan='2'>CURRENT CONDITION</th>
                            <th rowspan='2'>DATE OF PHYSICAL INVENTORY</th>
                            <th rowspan='2'>REMARKS</th>
                            <th class='subcolumn additional-details' colspan='5'>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                        </tr>
                        <tr>
                            <th class='subcolumn'>BRAND</th>
                            <th class='subcolumn'>SERIAL NUMBER</th>
                            <th class='subcolumn'>PARTICULARS</th>
                            <th class='subcolumn' style='white-space: nowrap;'>MR / ARE NUMBER</th>
                            <th class='subcolumn'>SHORTAGE/OVERAGE QTY</th>
                            <th class='subcolumn'>SHORTAGE/OVERAGE VALUE</th>
                            <th class='subcolumn additional-details'>SUPPLIER</th>
                            <th class='subcolumn additional-details'>PO NO.</th>
                            <th class='subcolumn additional-details'>AIR/RIS NO.</th>
                            <th class='subcolumn additional-details'>NOTES</th>
                            <th class='subcolumn additional-details'>JEV NUMBER</th>
                        </tr>
                    </thead>";
                echo "<tbody>";

                // Fetch and display rows
                while ($row = $result->fetch_assoc()) {
                     echo '
                        <tr>
                            <td class="dateRecorded">' . (empty($row['dateReceived']) || $row['dateReceived'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['dateReceived']))) . '</td>
                            <td>' . $row['article'] . '</td>
                            <td>' . $row['brand'] . '</td>
                            <td>' . $row['serialNo'] . '</td>
                            <td>' . $row['particulars'] . '</td>
                            <td style="white-space: nowrap;">' . $row['AREno'] . '</td>
                            <td>' . $row['eNGAS'] . '</td>
                            <td>' . (empty($row['acquisitionDate']) || $row['acquisitionDate'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['acquisitionDate']))) . '</td>
                            <td>' . $row['acquisitionCost'] . '</td>
                            <td>' . $row['propertyNo'] . '</td>
                            <td style="white-space: nowrap;">' . $row['accountNumber'] . '</td>
                            <td>' . $row['estimatedLife'] . '</td>
                            <td>' . $row['unitOfMeasure'] . '</td>
                            <td>' . $row['unitValue'] . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>' . $row['onhandPerCount'] . '</td>
                            <td>' . $row['soQty'] . '</td>
                            <td>' . $row['soValue'] . '</td>
                            <td>' . $row['officeName'] . '</td>
                            <td style="white-space: nowrap;">' . $row['accountablePerson'] . '</td>
                            <td>' . $row['previousCondition'] . '</td>
                            <td>' . $row['location'] . '</td>
                            <td>' . $row['currentCondition'] . '</td>
                            <td>' . (empty($row['dateOfPhysicalInventory']) || $row['dateOfPhysicalInventory'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['dateOfPhysicalInventory']))) . '</td>
                            <td>' . $row['gpremarks'] . '</td>
                            <td class="additional-details">' . $row['supplier'] . '</td>
                            <td class="additional-details">' . $row['POnumber'] . '</td>
                            <td class="additional-details">' . $row['AIRNumber'] . '</td>
                            <td class="additional-details">' . $row['notes'] . '</td>
                            <td class="additional-details">' . $row['jevNo'] . '</td>
                        </tr>';
                    }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                echo "</div>";
            } else {
                echo "No ARE properties found for Year: $dateYear";
            }

            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $connect->error;
        }
    } else {
        echo "Accountable Person parameter not provided.";
    }
}
?>
