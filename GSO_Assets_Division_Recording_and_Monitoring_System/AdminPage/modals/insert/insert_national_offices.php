<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "db_gso");
if(!empty($_POST))
{

    $noffice_name = mysqli_real_escape_string($connect, $_POST["nationaloffice_name"]);  
    $ncode_number = mysqli_real_escape_string($connect, $_POST["nationaloffice_code"]);

            $query="SELECT COUNT(noffice_name) as num FROM national_offices WHERE noffice_name=?";
            $pre_stmt = $connect->prepare($query) or die(mysqli_error()); 
            $pre_stmt->bind_param("s",$noffice_name);
            $pre_stmt->execute();
            $result = $pre_stmt->get_result();
            $rows = mysqli_fetch_array($result);

            if ($rows['num']==0) 
            {
            $query="INSERT INTO `national_offices`(`noffice_name`,`ncode_number`) VALUES (?,?)";
            $pre_stmt = $connect->prepare($query)or die(mysqli_error()); 
            $pre_stmt->bind_param("ss",$noffice_name, $ncode_number);
            $pre_stmt->execute();

         date_default_timezone_set('Asia/Manila'); 
            $date_now =date('Y-m-d');
            $time_now=date('H:i:s');
            $action='Added an office';
            $employeeid=$_SESSION['employeeid']; 
            $query ="INSERT INTO activity_log (employeeid,firstname,date_log,time_log,action) values
                    (?,?,?,?,?)";        
            $stmt = $connect->prepare($query);
            $stmt->bind_param('issss', $employeeid,$_SESSION['firstname'],$date_now,$time_now,$action);
            $stmt->execute(); 
    echo "National Office Successfully Inserted";                
            }
            if($rows['num']!=0)
            {
                echo "National Office Already Exists";
            }  

}


 ?> 