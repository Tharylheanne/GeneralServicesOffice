<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM national_offices";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["noffice_name"].'</td>
          <td>'.$row["ncode_number"].'</td>
      ';
      ?>
      <td>
        <a href="nationaloffice_edit.php?noffice_id=<?php echo $row["noffice_id"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>