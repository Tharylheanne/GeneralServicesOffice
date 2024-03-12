<?php
  require('./../database/connection.php');

  $sql = "SELECT
        c.*,
        cp.purposeName,
        UPPER(CASE
                WHEN c.classification IN ('City Office', 'National Office') THEN COALESCE(co.officeName, no.officeName)
                ELSE COALESCE(co.officeName, no.officeName, elem.elemName, high.highSchoolName, b.barangayName)
            END) AS responsibilityCenter,
        e.employeeName
        FROM
            clearance c
        LEFT JOIN
            clearancepurpose cp ON c.purpose = cp.purposeName
        LEFT JOIN
            cityoffices co ON c.office = co.officeName
        LEFT JOIN
            nationaloffices no ON c.office = no.officeName
        LEFT JOIN
            barangay b ON c.office = b.barangayName
        LEFT JOIN
            elementary elem ON c.office = elem.elemName
        LEFT JOIN
            highschool high ON c.office = high.highSchoolName
        LEFT JOIN
            employees e ON c.employeeName = e.employeeName
        ORDER BY
            SUBSTRING_INDEX(c.controlNo, '-', 1) ASC,
            CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(c.controlNo, '-', -1), '-', 1) AS SIGNED) ASC";

  $pre_stmt = $connect->prepare($sql) or die(mysqli_error($connect));
  $pre_stmt->execute();
  $result = $pre_stmt->get_result();

  while ($rows = mysqli_fetch_array($result)) {
    $formattedDateCleared = (!empty($rows["dateCleared"]) && $rows["dateCleared"] != "0000-00-00") ? date("m/d/Y", strtotime($rows["dateCleared"])) : " ";

    $scannedClearance = $rows["scannedDocs"]; // Path to the scanned ARE document

        // Conditionally create the "View Scanned Supporting document" link
        if (!empty($scannedClearance)) {
            $scannedClearanceLink = '<a href="' . $scannedClearance . '" target="_blank">View Scanned Document</a>';
        } else {
            $scannedClearanceLink = ''; // Empty link if scannedARE is null
        }
    ?>
    <tr>
      <td><?php echo $formattedDateCleared; ?></td>
      <td><?php echo $rows["controlNo"]; ?></td>
      <td><?php echo $scannedClearanceLink; ?></td>
      <td style="white-space: nowrap;"><?php echo $rows["employeeName"]; ?></td>
      <td><?php echo $rows["position"]; ?></td>
      <td><?php echo $rows["classification"]; ?></td>
      <td><?php echo $rows["responsibilityCenter"]; ?></td>
      <td><?php echo $rows["purpose"]; ?></td>
      <td><?php echo $rows["effectivityDate"]; ?></td>
      <td><?php echo $rows["remarks"]; ?></td>
      <td><?php echo $rows["clearedBy"]; ?></td>
      
      <td>
        <a href="manageClearanceEdit.php?clearanceID=<?php echo $rows['clearanceID']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
      </td>
    </tr>
    <?php
  }
?>