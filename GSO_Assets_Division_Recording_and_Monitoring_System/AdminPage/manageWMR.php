<?php 
    require('./../database/connection.php');

    $sql = "SELECT 
                ip.*, 
                gp.*, 
                agp.*, 
                wmr.*,
                pwgp.*, 
                ac.accountNumber AS classification,
                COALESCE(co.officeName, no.officeName) AS officeName
            FROM 
                ics_properties ip
            LEFT JOIN 
                are_ics_gen_properties agp ON ip.ARE_ICS_id = agp.ARE_ICS_id
            LEFT JOIN 
                generalproperties gp ON ip.propertyID = gp.propertyID
            LEFT JOIN 
                wmr_properties wmr ON gp.propertyID = wmr.propertyID
            LEFT JOIN 
                prs_wmr_gen_properties pwgp ON gp.propertyID = pwgp.propertyID 
            LEFT JOIN 
                account_codes ac ON gp.accountNumber = ac.accountNumber
            LEFT JOIN 
                cityoffices co ON gp.officeName = co.officeName
            LEFT JOIN 
                nationaloffices no ON gp.officeName = no.officeName
            LEFT JOIN 
                conditions c ON agp.currentCondition = c.conditionName
            WHERE 
                ((gp.gpremarks LIKE '%with wmr%')
                OR (agp.currentCondition = 'Returned'))
                OR (wmr.propertyID IN (SELECT propertyID FROM generalproperties))
            ORDER BY
                CAST(SUBSTRING_INDEX(wmr.wmrNo, '-', 1) AS UNSIGNED), 
                CAST(SUBSTRING_INDEX(wmr.wmrNo, '-', -1) AS UNSIGNED)";

    $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($rows = mysqli_fetch_array($result)) {
        
        $formattedDateReturned = (!empty($rows["dateReturned"]) && $rows["dateReturned"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["dateReturned"])) : "";
        $formattedAcquisitionDate = (!empty($rows["acquisitionDate"]) && $rows["acquisitionDate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["acquisitionDate"])) : "";
        $formattediirupDate = (!empty($rows["iirupDate"]) && $rows["iirupDate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["iirupDate"])) : "";
        $formattedDateOfSaleAuction = (!empty($rows["formattedDateOfSaleAuction"]) && $rows["formattedDateOfSaleAuction"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["formattedDateOfSaleAuction"])) : "";
        $formattedORdate = (!empty($rows["ORdate"]) && $rows["ORdate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["ORdate"])) : "";
        $formattedORdate = (!empty($rows["ORdate"]) && $rows["ORdate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["ORdate"])) : "";
        $formattedTransferDate = (!empty($rows["transferDate"]) && $rows["transferDate"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["transferDate"])) : "";


        $scanneWMRSPath = $rows["scannedDocs"];

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scanneWMRSPath)) {
            // Extract the property number
            $propertyNo = $rows["propertyNo"];

            // Create the new filename
            $newFilename = "WMR_" . $rows["WMRno"] . "(" . $propertyNo . ")";

            // Get the file extension
            $fileExtension = pathinfo($scanneWMRSPath, PATHINFO_EXTENSION);

            // Create the new link with the renamed file
            $scannedWMRLink = '<a href="' . $scanneWMRSPath . '" target="_blank">' . $newFilename . '</a>';
        } else {
            $scannedWMRLink = ''; // Empty link if scannedARE is null
        }

 ?>

 <tr>
    <td><?php echo isset($scannedWMRLink) ? $scannedWMRLink : ''; ?></td>
    <td><?php echo isset($formattedDateReturned) ? $formattedDateReturned : ''; ?></td>
    <td><?php echo isset($rows['itemNo']) ? $rows['itemNo'] : ''; ?></td>
    <td><?php echo isset($rows['wmrNo']) ? $rows['wmrNo'] : ''; ?></td>
    <td><?php echo isset($rows['article']) ? $rows['article'] : ''; ?></td>
    <td><?php echo isset($rows["brand"]) ? $rows["brand"] : ''; ?></td>
    <td><?php echo isset($rows["serialNo"]) ? $rows["serialNo"] : ''; ?></td>
    <td><?php echo isset($rows["particulars"]) ? $rows["particulars"] : ''; ?></td>
    <td style="white-space: nowrap;"><?php echo isset($rows["ICSno"]) ? $rows["ICSno"] : ''; ?></td>
    <td><?php echo isset($rows["eNGAS"]) ? $rows["eNGAS"] : ''; ?></td>
    <td><?php echo isset($formattedAcquisitionDate) ? $formattedAcquisitionDate : ''; ?></td>
    <td><?php echo isset($rows["acquisitionCost"]) ? $rows["acquisitionCost"] : ''; ?></td>
    <td><?php echo isset($rows["propertyNo"]) ? $rows["propertyNo"] : ''; ?></td>
    <td><?php echo isset($rows["accountNumber"]) ? $rows["accountNumber"] : ''; ?></td>
    <td><?php echo isset($rows["estimatedLife"]) ? $rows["estimatedLife"] : null; ?></td>
    <td><?php echo isset($rows["unitOfMeasure"]) ? $rows["unitOfMeasure"] : ''; ?></td>
    <td><?php echo isset($rows["unitValue"]) ? $rows["unitValue"] : ''; ?></td>
    <td><?php echo isset($rows["onhandPerCount"]) ? $rows["onhandPerCount"] : ''; ?></td>
    <td><?php echo isset($rows["officeName"]) ? $rows["officeName"] : ''; ?></td>
    <td style="white-space: nowrap;"><?php echo isset($rows["accountablePerson"]) ? $rows["accountablePerson"] : ''; ?></td>
    <td>
        <?php 
            echo isset($rows["gpremarks"]) ? $rows["gpremarks"] : '';
            if (isset($rows["gpremarks"]) && isset($rows["currentCondition"])) {
                echo " ; ";
            }
            echo isset($rows["currentCondition"]) ? $rows["currentCondition"] : ''; 
        ?>
    </td>
    <td><?php echo isset($rows["withAttachment"]) ? $rows["withAttachment"] : ''; ?></td>
    <td><?php echo isset($rows["withCoverPage"]) ? $rows["withCoverPage"] : ''; ?></td>
    <td><?php echo isset($rows["iirup"]) ? $rows["iirup"] : ''; ?></td>
    <td><?php echo isset($formattediirupDate) ? $formattediirupDate : ''; ?></td>
    <td><?php echo isset($rows["modeOfDisposal"]) ? $rows["modeOfDisposal"] : ''; ?></td>
    <td><?php echo isset($formattedDateOfSaleAuction) ? $formattedDateOfSaleAuction : ''; ?></td>
    <td><?php echo isset($formattedORdate) ? $formattedORdate : ''; ?></td>
    <td><?php echo isset($rows["ORNumber"]) ? $rows["ORNumber"] : ''; ?></td>
    <td><?php echo isset($rows["amount"]) ? $rows["amount"] : ''; ?></td>
    <td><?php echo isset($rows["partDestroyedOrThrown"]) ? $rows["partDestroyedOrThrown"] : ''; ?></td>
    <td><?php echo isset($rows["remarks"]) ? $rows["remarks"] : ''; ?></td>
    <td><?php echo isset($rows["currentStatus"]) ? $rows["currentStatus"] : ''; ?></td>
    <td><?php echo isset($rows["remarks"]) ? $rows["remarks"] : ''; ?></td>

    <td>
      <a href="manageWMREditTable.php?propertyID=<?php echo $rows['propertyID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
    </td>
 </tr>

 <?php 
    } // End of while loop
 ?>