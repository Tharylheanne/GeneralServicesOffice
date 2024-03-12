<?php
  require('./../database/connection.php');
    $sql = "SELECT * FROM highschool";
    $pre_stmt = $connect->prepare($sql) or die (msqli_error());
    $pre_stmt->execute();
    $result = $pre_stmt->get_result();

    while ($row = mysqli_fetch_array($result)) {
      echo'
        <tr>
          <td>'.$row["highSchoolName"].'</td>
      ';
      ?>
      <td>
        <a href="highSchoolEdit.php?highSchoolID=<?php echo $row["highSchoolID"]; ?>" class="btn btn-primary btn-sm"><i class="fa fa-edit">&nbsp</i>Edit</a>
      </td>
      <?php
    }
    ?>