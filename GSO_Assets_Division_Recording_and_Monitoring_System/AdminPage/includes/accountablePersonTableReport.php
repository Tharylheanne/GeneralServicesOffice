<?php
    require('./../database/connection.php');
    /*require('../login/login_session.php');*/

    // Check if an accountable person parameter is provided in the URL
    if (isset($_GET['accountablePerson'])) {
        $accountablePerson = urldecode($_GET['accountablePerson']);

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
                WHERE gp.accountablePerson = ?";

        // Prepare the SQL statement
        $stmt = $connect->prepare($sql);

        // Bind parameters and execute the statement
        if ($stmt) {
            $stmt->bind_param("s", $accountablePerson);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check for errors in query execution
            if (!$result) {
                echo "Error in query execution: " . mysqli_error($connect);
                exit;
            }

            // Fetch and display the ARE properties
            if ($result->num_rows > 0) {
                echo "<h3 id='printTitle' style='text-align: center; line-height: 2em;'>Report on Physical Count of Property, Plant, and Equipment<br>Accountable Employee: <span style='text-decoration: underline;'>$accountablePerson</span></h3>";

                // Display the table
                echo "<div class='table-responsive'>";
                echo "<div style='max-height:200%; overflow-y:auto;'>";
                echo "<table id='AREaccountablePersontable' class='table table-bordered table-striped'>";
                // Table header
                echo "<thead>
                        <tr>
                            <th class='dateRecorded' rowspan='2' class='additional-details'>DATE RECEIVED</th>
                            <th rowspan='2'>ARTICLE</th>
                            <th class='subcolumn' colspan='4' style='text-align:center;'>DESCRIPTION</th>
                            <th rowspan='2' style='text-align:center;'>eNGAS PROPERTY NUMBER</th>
                            <th rowspan='2'style='text-align:center;'>ACQUISITION DATE</th>
                            <th rowspan='2'style='text-align:center;'>ACQUISITION COST</th>
                            <th rowspan='2'style='text-align:center;'>PROPERTY NO.</th>
                            <th rowspan='2'style='text-align:center;'>CLASSIFICATION</th>
                            <th rowspan='2'style='text-align:center;'>EST. USEFUL LIFE</th>
                            <th rowspan='2'style='text-align:center;'>UNIT OF MEASURE</th>
                            <th rowspan='2'style='text-align:center;'>UNIT VALUE</th>
                            <th rowspan='2'style='text-align:center;'>BALANCE PER CARD QTY</th>
                            <th rowspan='2'style='text-align:center;'>ON HAND PER COUNT QTY</th>
                            <th class='subcolumn' colspan='2'style='text-align:center;'>SHORTAGE/OVERAGE</th>
                            <th rowspan='2'style='text-align:center;'>RESPONSIBILITY CENTER</th>
                            <th rowspan='2'style='text-align:center;'>ACCOUNTABLE PERSON</th>
                            <th rowspan='2'style='text-align:center;'>PREVIOUS CONDITION</th>
                            <th rowspan='2'style='text-align:center;'>LOCATION</th>
                            <th rowspan='2'style='text-align:center;'>CURRENT CONDITION</th>
                            <th rowspan='2'style='text-align:center;'>DATE OF PHYSICAL INVENTORY</th>
                            <th rowspan='2'style='text-align:center;'>REMARKS</th>
                            <th class='subcolumn additional-details' colspan='5'style='text-align:center;'>ADDITIONAL DETAILS FOR RECONCILIATION PURPOSES</th>
                        </tr>
                        <tr>
                            <th class='subcolumn'style='text-align:center;'>BRAND</th>
                            <th class='subcolumn'style='text-align:center;'>SERIAL NUMBER</th>
                            <th class='subcolumn'style='text-align:center;'>PARTICULARS</th>
                            <th class='subcolumn'style='text-align:center;'>MR / ARE NUMBER</th>
                            <th class='subcolumn'style='text-align:center;'>SHORTAGE/OVERAGE QTY</th>
                            <th class='subcolumn'style='text-align:center;'>SHORTAGE/OVERAGE VALUE</th>
                            <th class='subcolumn additional-details'style='text-align:center;'>SUPPLIER</th>
                            <th class='subcolumn additional-details'style='text-align:center;'>PO NO.</th>
                            <th class='subcolumn additional-details'style='text-align:center;'>AIR/RIS NO.</th>
                            <th class='subcolumn additional-details'style='text-align:center;'>NOTES</th>
                            <th class='subcolumn additional-details'style='text-align:center;'>JEV NUMBER</th>
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
                            <td>' . $row['AREno'] . '</td>
                            <td>' . $row['eNGAS'] . '</td>
                            <td>' . (empty($row['acquisitionDate']) || $row['acquisitionDate'] === '0000-00-00' ? '' : date('m/d/Y', strtotime($row['acquisitionDate']))) . '</td>
                            <td>' . $row['acquisitionCost'] . '</td>
                            <td>' . $row['propertyNo'] . '</td>
                            <td>' . $row['accountNumber'] . '</td>
                            <td>' . $row['estimatedLife'] . '</td>
                            <td>' . $row['unitOfMeasure'] . '</td>
                            <td>' . $row['unitValue'] . '</td>
                            <td>' . $row['quantity'] . '</td>
                            <td>' . $row['onhandPerCount'] . '</td>
                            <td>' . $row['soQty'] . '</td>
                            <td>' . $row['soValue'] . '</td>
                            <td>' . $row['officeName'] . '</td>
                            <td>' . $row['accountablePerson'] . '</td>
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
                echo "No ARE properties found for Accountable Person: $accountablePerson";
            }

            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $connect->error;
        }
    } else {
        echo "Accountable Person parameter not provided.";
    }
?>