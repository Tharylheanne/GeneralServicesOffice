<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM cityoffices";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["officeName"].'</td>
          <td>'.$row["officeCode"].'</td>
      ';
      ?>
      <td>
        <a href="cityoffice_edit.php?officeID=<?php echo $row["officeID"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>