<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM elementary";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["elemName"].'</td>
      ';
      ?>
      <td>
        <a href="elemEdit.php?elemID=<?php echo $row["elemID"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>