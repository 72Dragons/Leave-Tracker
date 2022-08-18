<?php 
include "db2.php";


class leave_add
{
	public static function add()
	{	
		leave_add::allid_bal();
		//$count_pub=leave_add::public_holiday();

		$query="SELECT bal_leave.*,staffinfo.joindate,staffinfo.firstname FROM bal_leave
			LEFT JOIN  staffinfo ON staffinfo.memberID=bal_leave.user_id
			order by bal_leave.id asc";
		$query=db2::$con->query($query);
		while($row=$query->fetch_assoc())
		{
	$row['today_date']=date("Y-m-d");
	//$row['today_date']='2025-01-01';
			//2025-01-01
		
						$datediff =strtotime($row['today_date']) - strtotime($row['joindate']);
						$row['date_diff']=round($datediff / (60 * 60 * 24));
						$row['maternity_more_than_80d']=date('Y-m-d', strtotime($row['joindate']. ' + 81 days'));
						$row['vacation_more_than_3m']=date('Y-m-d', strtotime($row['joindate']. ' + 91 days'));
						$row['vacation_more_than_6m']=date('Y-m-d', strtotime($row['joindate']. ' + 181 days'));
						$row['vacation_more_than_12m']=date('Y-m-d', strtotime($row['joindate']. ' + 366 days'));
						$row['sick_more_than_3m']=date('Y-m-d', strtotime($row['joindate']. ' + 91 days'));
		      			$row['one_yr_completed']=date('Y-01-01', strtotime('+2 year'));

						//$row['year_diff']=round((strtotime($row['one_yr_completed'])-strtotime(date('Y-01-01')))/(60 * 60 * 24));
						$row['year_diff']=round((strtotime($row['today_date'])-strtotime($row['one_yr_completed']))/(60 * 60 * 24));
						$row['year_diff_m1']=$row['year_diff']-1;
						$row['every_yr']=date('Y-m-d', strtotime($row['one_yr_completed']. ' + '.$row["year_diff"].' days'));


			if($row['today_date']==$row['maternity_more_than_80d'])
			{
						//echo "<script>alert('maternity');</script>";
						//$query3=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");	
					$query2=db2::$con->query("UPDATE bal_leave SET maternity_leave=182 where user_id='".$row['user_id']."'");	
			}	
			elseif(0<=$row['date_diff'] && $row['date_diff']<91)
			{
					//	echo "<script>alert('start');</script>";
						//echo "this";
						//echo $count_pub;
						//$query3=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");
						if($row['unpaid_status']==0 && $row['causaul_status']==0)
						{	
//						echo $count_pub;
//						$query2=db2::$con->query("UPDATE bal_leave SET unpaid_leave='30',public_holiday='$count_pub',maternity_leave='26 weeks',unpaid_status=1,public_status=1 where user_id='".$row['user_id']."'");
	$query2=db2::$con->query("UPDATE bal_leave SET causaul_leave=8,full_causaul_leave=4,half_causaul_leave=8,causaul_status=1,unpaid_leave='30',unpaid_status=1 where user_id='".$row['user_id']."'");	
						}
			}

			elseif($row['today_date']==$row['vacation_more_than_3m'] && $row['today_date']==$row['sick_more_than_3m'] )
			{
					//	echo "<script>alert('first');</script>";
						//$query3=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");	
						if($row['vacation_status']==0 && $row['sick_status']==0)
						{	
						$row['vacation_leave']=10;
						$query2=db2::$con->query("UPDATE bal_leave SET vacation_leave='".$row['vacation_leave']."',sick_leave='".$row['vacation_leave']."',vacation_status=1,sick_status=1 where user_id='".$row['user_id']."'");	
						}
			}	
			elseif($row['today_date']==$row['vacation_more_than_6m'])
			{
					//	echo "";
					//	echo "<script>alert('second');</script>";
						///$query3=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");	
						if($row['vacation_status']==1 && $row['sick_status']==1)
						{
						// $row['vacation_leave']=15-(10-$row['vacation_leave']);
						 $row['vacation_leave']=5+$row['vacation_leave'];
						$row['sick_leave']==10-$row['sick_leave'];
						$query2=db2::$con->query("UPDATE bal_leave SET vacation_leave='".$row['vacation_leave']."',sick_leave='".$row['sick_leave']."',vacation_status=2,sick_status=2 where user_id='".$row['user_id']."'");
						}
			}	
			elseif($row['today_date']==$row['vacation_more_than_12m'])
			{	
					//	echo " ";		
					//	echo "<script>alert('third');</script>";
						//$query3=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");	
						if($row['vacation_status']==2 && $row['sick_status']==2)
						{
						//$row['vacation_leave']=21-(15-$row['vacation_leave']);
							$row['vacation_leave']=6+$row['vacation_leave'];
						$row['sick_leave']==10-$row['sick_leave'];	
						$query2=db2::$con->query("UPDATE bal_leave SET vacation_leave='".$row['vacation_leave']."',sick_leave='".$row['sick_leave']."',vacation_status=3,sick_status=3 where user_id='".$row['user_id']."'");
						}
			}
		//	elseif($row['date_diff'] % 365 == 0 && $row['one_yr_completed']==date('Y-m-d'))
	//			elseif($row['one_yr_completed']==$row['today_date'])
		elseif($row['year_diff_m1'] % 365 ==0 || $row['one_yr_completed']==$row['today_date'])
			{
					//	echo "fourth";	
//						echo "<script>alert('fourth');</script>";
						$query4=db2::$con->query("UPDATE  holiday_list SET removed_on=CURRENT_TIMESTAMP");
						$query5=db2::$con->query("UPDATE public_holiday SET removed_on=CURRENT_TIMESTAMP");	
				//		$count_pub=leave_add::public_holiday();
						//leave_add::public_holiday();
						$row['vacation_leave']=21;
			//			$query3=db2::$con->query("UPDATE bal_leave SET vacation_leave='".$row['vacation_leave']."',sick_leave=10,vacation_status=4,sick_status=4,unpaid_leave='30',public_holiday='$count_pub',unpaid_status=1,public_status=1 where user_id='".$row['user_id']."'");	
	$query3=db2::$con->query("UPDATE bal_leave SET vacation_leave='".$row['vacation_leave']."',causaul_leave=8,full_causaul_leave=4,half_causaul_leave=8,causaul_status=1,sick_leave=10,vacation_status=4,sick_status=4,unpaid_leave='30',unpaid_status=1 where user_id='".$row['user_id']."'");	

			}

		$arr[]=$row;
		}
		//echo "<pre>";
		//print_r($arr);

	}



// 	public static function public_holiday()
// 	{

// 		$arr=[];
// 		$query=db2::$con->query("SELECT * from holiday_list where removed_on is null");
// 		while($row=$query->fetch_assoc())
// 		{
// 				if(isset($row))
// 				{
// 					$timestamp = strtotime($row['dates']);
// 					$day = date('D', $timestamp);
// 					$row['day']=$day;

// 					if($row['day']=="Sun")
// 					{
// 						$row['mon']=date('Y-m-d', strtotime($row['dates']. ' + 1 days'));
// 						$row['fri']=date('Y-m-d', strtotime('-2 day', strtotime($row['dates'])));


// 					}
// 					elseif($row['day']=='Sat')
// 					{
// 						$row['mon']=date('Y-m-d', strtotime($row['dates']. ' + 2 days'));
// 						$row['fri']=date('Y-m-d', strtotime('-1 day', strtotime($row['dates'])));						
// 					}


// 					if(isset($row['mon']) && $row['fri'])
// 					{
// 					$row2="";
// 					$query2=db2::$con->query("SELECT * FROM public_holiday WHERE  removed_on is null and holiday='".$row['holiday']."' AND holiday_date='".date('Y-m-d',strtotime($row['dates']))."' AND holiday_day='".$row['day']."'");
// 					if($query2->num_rows>0)
// 					{
						
// 						$row2=$query2->fetch_assoc();
// 						$query3=db2::$con->query("UPDATE public_holiday SET mon_date	='".$row['mon']."',sat_date='".$row['fri']."' where public_id='".$row2['public_id']."'");	
// 					}
// 					else
// 					{
// 							$query2=db2::$con->query("INSERT INTO public_holiday(holiday,holiday_date,holiday_day,mon_date,sat_date)VALUES('".$row['holiday']."','".date('Y-m-d',strtotime($row['dates']))."','".$row['day']."','".$row['mon']."','".$row['fri']."')");
// 					}
// 					}
// }

// 					$arr[]=$row;
					
		
// 	}

// 	$query4=db2::$con->query("SELECT holiday_date from public_holiday where removed_on is null");
// 	$ar=[];
// 	while($row2=$query4->fetch_assoc())
// 	{
// 		$data=explode("-",$row2['holiday_date'])[0];	
// 		if($data==date("Y"))
// 		{
// 			$ar[]=$row2;			
// 		}

// 	}
// 		return  count($ar);

// 	}



	public static function allid_bal()
	{
		$query="SELECT memberID FROM staffinfo";
		$query=db2::$con->query($query);
		while($row=$query->fetch_assoc())
		{

			// $row2="";
					$query2=db2::$con->query("SELECT * FROM bal_leave WHERE  removed_on is null and user_id='".$row['memberID']."'");
					if($query2->num_rows>0)
					{
						// echo "this";
						// $row2=$query2->fetch_assoc();
						// $query3=db2::$con->query("UPDATE public_holiday SET mon_date ='".$row['mon']."',sat_date='".$row['fri']."' where public_id='".$row2['public_id']."'");	
					}
					else
					{
						//echo "new";
						$query2=db2::$con->query("INSERT INTO bal_leave(user_id)VALUES('".$row['memberID']."')");
					}
			$arr[]=$row;
		}	
// echo "<pre>";
// 		print_r($arr);
	}
}


$_GET['api'] = 'add';
if(!empty($_GET['api'])){
     if($_GET['api'] == 'add'){
     echo 	json_encode(leave_add::add());
    }
    elseif($_GET['api']=='public_holiday')
    {
    	 json_encode(leave_add::public_holiday());
    }
     elseif($_GET['api']=='allid_bal')
    {
    	 json_encode(leave_add::allid_bal());
    }

}
 ?>