<?php 
    require('./../database/connection.php');

    $sql = "SELECT
                ap.AREno,
                gp.propertyID,
                gp.scannedDocs,
                gp.article,
                gp.brand,
                gp.serialNo,
                gp.particulars,
                gp.eNGAS,
                gp.acquisitionDate,
                gp.acquisitionCost,
                gp.propertyNo,
                gp.accountNumber,
                gp.estimatedLife,
                gp.unitOfMeasure,
                gp.unitValue,
                gp.quantity,
                gp.officeName,
                gp.accountablePerson,
                gp.gpremarks,
                agp.dateReceived,
                agp.onhandPerCount,
                agp.soQty,
                agp.soValue,
                agp.previousCondition,
                agp.location,
                agp.currentCondition,
                agp.dateOfPhysicalInventory,
                agp.remarks,
                agp.supplier,
                agp.POnumber,
                agp.AIRnumber,
                agp.notes,
                agp.jevNo,
                ac.accountNumber AS classification,
                COALESCE(co.officeName, no.officeName) AS officeName,
                c.conditionName AS currentCondition
            FROM
                are_properties ap
            LEFT JOIN
                are_ics_gen_properties agp ON ap.ARE_ICS_id = agp.ARE_ICS_id
            LEFT JOIN
                generalproperties gp ON ap.propertyID = gp.propertyID
            LEFT JOIN
                account_codes ac ON gp.accountNumber = ac.accountNumber
            LEFT JOIN
                cityoffices co ON gp.officeName = co.officeName
            LEFT JOIN
                nationaloffices no ON gp.officeName = no.officeName
            LEFT JOIN
                conditions c ON agp.currentCondition = c.conditionName
            WHERE
                ((gp.gpremarks IS NULL)
                OR (gp.gpremarks NOT LIKE '%with prs%' AND gp.gpremarks NOT LIKE '%with wmr%'))
                AND (agp.currentCondition <> 'Returned' OR agp.currentCondition IS NULL)
                AND gp.propertyID NOT IN (SELECT propertyID FROM prs_properties)
            ORDER BY
                CAST(SUBSTRING_INDEX(gp.propertyNo, '-', 1) AS UNSIGNED), 
                CAST(SUBSTRING_INDEX(gp.propertyNo, '-', -1) AS UNSIGNED)";

    $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($rows = mysqli_fetch_array($result)) {
        
        $formattedDateReceived = (!empty($rows["dateReceived"]) && $rows["dateReceived"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["dateReceived"])) : "";
        $formattedAcquisitionDate = (!empty($rows["acquisitionDate"]) && $rows["acquisitionDate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["acquisitionDate"])) : "";
        $formattedDateOfPhysicalInventory = (!empty($rows["dateOfPhysicalInventory"]) && $rows["dateOfPhysicalInventory"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["dateOfPhysicalInventory"])) : "";

        $scannedAREPath = $rows["scannedDocs"];

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedAREPath)) {
            // Extract the property number
            $propertyNo = $rows["propertyNo"];

            // Create the new filename
            $newFilename = "ARE_" . $rows["AREno"] . "(" . $propertyNo . ")";

            // Get the file extension
            $fileExtension = pathinfo($scannedAREPath, PATHINFO_EXTENSION);

            // Create the new link with the renamed file
            $scannedARELink = '<a href="' . $scannedAREPath . '" target="_blank">' . $newFilename . '</a>';
        } else {
            $scannedARELink = ''; // Empty link if scannedARE is null
        }

 ?>

 <tr>
    <td><?php echo isset($scannedARELink) ? $scannedARELink : ''; ?></td>
    <td><?php echo isset($formattedDateReceived) ? $formattedDateReceived : ''; ?></td>
    <td><?php echo isset($rows['article']) ? $rows['article'] : ''; ?></td>
    <td><?php echo isset($rows["brand"]) ? $rows["brand"] : ''; ?></td>
    <td><?php echo isset($rows["serialNo"]) ? $rows["serialNo"] : ''; ?></td>
    <td><?php echo isset($rows["particulars"]) ? $rows["particulars"] : ''; ?></td>
    <td style="white-space: nowrap;"><?php echo isset($rows["AREno"]) ? $rows["AREno"] : ''; ?></td>
    <td><?php echo isset($rows["eNGAS"]) ? $rows["eNGAS"] : ''; ?></td>
    <td><?php echo isset($formattedAcquisitionDate) ? $formattedAcquisitionDate : ''; ?></td>
    <td><?php echo isset($rows["acquisitionCost"]) ? $rows["acquisitionCost"] : ''; ?></td>
    <td><?php echo isset($rows["propertyNo"]) ? $rows["propertyNo"] : ''; ?></td>
    <td><?php echo isset($rows["accountNumber"]) ? $rows["accountNumber"] : ''; ?></td>
    <td><?php echo isset($rows["estimatedLife"]) ? $rows["estimatedLife"] : null; ?></td>
    <td><?php echo isset($rows["unitOfMeasure"]) ? $rows["unitOfMeasure"] : ''; ?></td>
    <td><?php echo isset($rows["unitValue"]) ? $rows["unitValue"] : ''; ?></td>
    <td><?php echo isset($rows["quantity"]) ? $rows["quantity"] : ''; ?></td>
    <td><?php echo isset($rows["onhandPerCount"]) ? $rows["onhandPerCount"] : ''; ?></td>
    <td><?php echo isset($rows["soQty"]) ? $rows["soQty"] : ''; ?></td>
    <td><?php echo isset($rows["soValue"]) ? $rows["soValue"] : ''; ?></td>
    <td><?php echo isset($rows["officeName"]) ? $rows["officeName"] : ''; ?></td>
    <td><?php echo isset($rows["accountablePerson"]) ? $rows["accountablePerson"] : ''; ?></td>
    <td><?php echo isset($rows["previousCondition"]) ? $rows["previousCondition"] : ''; ?></td>
    <td><?php echo isset($rows["location"]) ? $rows["location"] : ''; ?></td>
    <td><?php echo isset($rows["currentCondition"]) ? $rows["currentCondition"] : ''; ?></td>
    <td><?php echo isset($formattedDateOfPhysicalInventory) ? $formattedDateOfPhysicalInventory : ''; ?></td>
    <td><?php echo isset($rows["gpremarks"]) ? $rows["gpremarks"] : (isset($rows["remarks"]) ? $rows["remarks"] : ''); ?></td>
    <td><?php echo isset($rows["supplier"]) ? $rows["supplier"] : ''; ?></td>
    <td><?php echo isset($rows["POnumber"]) ? $rows["POnumber"] : ''; ?></td>
    <td><?php echo isset($rows["AIRnumber"]) ? $rows["AIRnumber"] : ''; ?></td>
    <td><?php echo isset($rows["notes"]) ? $rows["notes"] : ''; ?></td>
    <td><?php echo isset($rows["jevNo"]) ? $rows["jevNo"] : ''; ?></td>
    <td>
      <a href="manageActivePPETable.php?propertyID=<?php echo $rows['propertyID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
    </td>
 </tr>

 <?php 
    } // End of while loop
 ?>