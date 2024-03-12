<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "db_gso");
if(!empty($_POST))
{

    $office_name = mysqli_real_escape_string($connect, $_POST["cityoffice_name"]);  
    $ocode_number = mysqli_real_escape_string($connect, $_POST["cityoffice_code"]);

            $query="SELECT COUNT(office_name) as num FROM city_offices WHERE office_name=?";
            $pre_stmt = $connect->prepare($query) or die(mysqli_error()); 
            $pre_stmt->bind_param("s",$office_name);
            $pre_stmt->execute();
            $result = $pre_stmt->get_result();
            $row = mysqli_fetch_array($result);

            if ($row['num']==0) 
            {
            $query="INSERT INTO `city_offices`(`office_name`,`ocode_number`) VALUES (?,?)";
            $pre_stmt = $connect->prepare($query)or die(mysqli_error()); 
            $pre_stmt->bind_param("ss",$office_name, $ocode_number);
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
    echo "City Office Successfully Inserted";                
            }
            if($row['num']!=0)
            {
                echo "City Office Already Exists";
            }  

}


 ?>