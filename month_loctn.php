<?php
session_start();
$month=$_GET['month'];
$location=$_GET['location'];
$month_name=$_GET['month_name'];
// $month_name="August";
// $month='08';
// $location='India';

$type="leave.csv";
header("Content-Type: text/csv");
header("Content-Disposition:attachment; filename=".$type);
header("Content-Transfer-Encoding: UTF-8");
header("Pragma: no-cache");
header("Expires: 0");
include "db.php";
include "db2.php";

	$output=fopen("php://output","w");
	//$output=fopen("leave.csv","w");
 fputcsv($output,array('Name','Leave type','From date','To date','Leave Count','status','Functional maganer status','Location maganer status','functional mananger','Location manager'));

		//$year=
		$query="SELECT apply_leave.*,72daccounts.name,funcmgr_apply.funct_status,postnmgr_apply.post_status
	FROM apply_leave
		LEFT JOIN 72daccounts ON 72daccounts.memberID=apply_leave.user_id
		LEFT JOIN funcmgr_apply ON funcmgr_apply.apy_lv_id=apply_leave.id
		LEFT JOIN postnmgr_apply ON postnmgr_apply.apy_lv_id=apply_leave.id
				
		WHERE 72daccounts.location=? and apply_leave.removed_on is null and  frm_date LIKE '".$month."/%'";
		$result=$con->prepare($query);
		$result->bind_param('s',$location);
		$result->execute();
		$get=$result->get_result();
		while($row=$get->fetch_assoc())
		{
			$arr=[];		
			$query2=db2::$con->query("SELECT DISTINCT user_id from admin_user_list where admin_id='".$_SESSION['user_id']."'");
			while($row2=$query2->fetch_assoc())
			{

					$arr[]=$row2;
					if($row['user_id']==$row2['user_id'])
					{
						$array[]=$row;
					}
			}
			//$array[]=$row;
		}
		// echo "<pre>";
		// print_r($arr);
		// print_r($array);
// No Data For This Month	
		if(empty($array))
		{
			$value['name']="No Data For ".$month_name;

			fputcsv($output,Array($value['name']));
						fclose($output);
			// echo "<script>
			// 	location.href='leave-management.php?msg=No Data For This Month';
			// 		</script>";
		}
		else
		{	
		//	echo "no";
			

				foreach ($array as $key => $value) {
				$a[][]=$value['user_id'];
		}
/////////////////////////////////////////////////////////////////
foreach ($a as $key => $value) 
			{
								$query="SELECT 72daccounts.name  from apply_leave 
								LEFT JOIN user_funcmgr ON user_funcmgr.user_id=apply_leave.user_id 
								LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.funcMgr_id 
								where apply_leave.user_id=?";
								$result=$con->prepare($query);
								$result->bind_param('s',$value['0']);
								$result->execute();
								$result->bind_result($name);
								$result->fetch();
								$a[$key][1]=$name;
								$result->close();
					
			}
			//print_r($a);
			$count= count($a);
			foreach ($array as $key => $value) {
					foreach ($value as $key2 => $value2) {
							if($key2=='user_id')
							{
								for($i=0;$i<$count;$i++)
								{
									if($value2==$a[$i][0])
									{
										$array[$key]['f']=$a[$i][1];
									}
//									$a[$i][0]
								}

									
							}
					}

			}
///////////////////////////////////////////////////////////////////////////////////////////////////
			foreach ($a as $key => $value) 
			{
								$query="SELECT 72daccounts.name  from apply_leave 
								LEFT JOIN user_posimgr ON user_posimgr.user_id=apply_leave.user_id 
								LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.posiMgr_id 
								where apply_leave.user_id=?";
								$result=$con->prepare($query);
								$result->bind_param('s',$value['0']);
								$result->execute();
								$result->bind_result($name);
								$result->fetch();
								$a[$key][1]=$name;
								$result->close();
					
			}
			//print_r($a);
			$count= count($a);
//echo $a[3][1];
			foreach ($array as $key => $value) {
					foreach ($value as $key2 => $value2) {
							if($key2=='user_id')
							{
								for($i=0;$i<$count;$i++)
								{
									if($value2==$a[$i][0])
									{
										$array[$key]['p']=$a[$i][1];
									}
//									$a[$i][0]
								}

									
							}
					}

			}
////////////////////////////////////////////////////////////////////////////////////////////////////			
//	print_r($array);
			foreach ($array as $key => $value) {
fputcsv($output,Array($value['name'],$value['leave_type'],$value['frm_date'],$value['to_date'],$value['count'],$value['status'],$value['funct_status'],$value['post_status'],$value['f'],$value['p']));
	}
			fclose($output);
			
}


?>