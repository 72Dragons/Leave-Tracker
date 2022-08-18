<?php 
$servername = "localhost";
$username = "db_bot";
$password = "dragon";
$db_name="leave_tracker";

// Create connection
$con = new mysqli($servername, $username, $password,$db_name);

//mysqli_query($con,"UPDATE staffinfo SET joinDate='2022-04-01' WHERE staffID='2' LIMIT 1");

// $query="DELETE FROM apply_leave";
// mysqli_query($con,$query);

//$query="SELECT * FROM bal_leave";
$query="SELECT * FROM apply_leave";
//$query="SELECT * FROM staffinfo";
// $query="SELECT * FROM apply_leave WHERE user_id='3'";

$arr = array();
$sql = mysqli_query($con,$query);
if(mysqli_num_rows($sql)>0){
    while($row = mysqli_fetch_assoc($sql)){
        //echo $row['name'] . '<br/>';
        $arr[] = $row;
    }
}else{
    echo "no";
}

echo json_encode($arr);

// $year = date('Y');
// mysqli_query($con,"UPDATE apply_leave SET year = '$year' WHERE user_id='3' AND leave_type='Casual Leave'");

// echo getLeaveTakenDays(3,'Casual Leave');

// function getLeaveTakenDays($member_id,$leave_type){

//     $servername = "localhost";
//     $username = "db_bot";
//     $password = "dragon";
//     $db_name="leave_tracker";

//     // Create connection
//     $con = new mysqli($servername, $username, $password,$db_name);

//     $year = date('Y');
//     $query="SELECT * FROM apply_leave WHERE user_id='$member_id' AND (leave_type='$leave_type' AND  year = '$year')";
    
//     $return = 0;
//     $sql = mysqli_query($con,$query);
//     if(mysqli_num_rows($sql)>0){
//         $arr = array();
//         while($row = mysqli_fetch_assoc($sql)){
//             $arr[] = $row['count'];
//         }
//         $return = array_sum($arr);
//     }
//     return $return;
// }
?>