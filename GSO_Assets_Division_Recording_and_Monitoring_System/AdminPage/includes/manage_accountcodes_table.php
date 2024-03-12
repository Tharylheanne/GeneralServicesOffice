<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM account_codes";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["account_title"].'</td>
          <td>'.$row["account_number"].'</td>
      ';
      ?>
      <td>
        <a href="accountcodes_edit.php?account_code_id=<?php echo $row["account_code_id"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>