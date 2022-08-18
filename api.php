<?php
include "db.php";
class api
{


public static function sick_chk($details,$files)
{
	global $con;
	// $details['leaveType'] = 'Sick Leave';
 //    $details['fromDate'] = '06/30/2022';
 //   $details['user_id'] = '1';
 //   $files['name']="";


$date =date('Y-m-d', strtotime($details['fromDate']));
$sick_da=date_sub(date_create($date),date_interval_create_from_date_string("1 days"));
$sick_bfr=date_format($sick_da,"j-n-Y");

    $query=$con->query("SELECT * FROM cal  WHERE user_id='".$details['user_id']."' and dates='".$sick_bfr."' and status='Approved' and removed_on is null");
   $count_sick=$query->num_rows;
	if($count_sick==1 && empty($files['name']))
	{
		echo  "note";
		die();
	}


}


public function apply_leave($details,$files)
{
	//prin_r($details);
	// exit;
	global $con;
	$obj=new api();
		
		if($details['leaveType']=="Sick Leave")
		{
			$sick_stat=$obj->sick_chk($details,$files);			
		}

	$qu=$con->query("SELECT * FROM apply_leave WHERE user_id='".$details['user_id']."' and frm_date='".$details['fromDate']."' and to_date='".$details['toDate']."' and removed_on is null");
	$co=$qu->num_rows;
	if($co>0)
	{
		echo  "You have Already applied a leave for this dates";
		die();
	}

	if(empty($files['name']))
	{
		$path=null;
		$obj=new api();
		// $date_range=$obj->date_range($details);
		// $obj->insert_dt_rg($details,$date_range);
		$days=$obj->apply_leave_data($details,$path);
	}
	else
	{
		$obj=new api();
		// $date_range=$obj->date_range($details);
		// $obj->insert_dt_rg($details,$date_range);

		$name=$files['name'];
		$name2=str_replace(" ","_",$name);
		$name3=date("Y_m_d_h_i_s",time())."_".$name2;
		$a=explode(".",$name);
		$a2=strtolower(end($a));
		if($a2=='jpg' || $a2=='jpeg' || $a2=='gif' || $a2=='png')
		{
		$tmpname=$files['tmp_name'];
		$path="images/".$name3;
		move_uploaded_file($tmpname, $path);
		$obj=new api();
		$days=$obj->apply_leave_data($details,$path);
		}
		else
		{
			echo "image should be in jpg, jpeg, gif, png format";
		}
	}
}


public  static function apply_leave_data($details,$path)
{
			////prin_r($details);
								global $con;
								$obj=new api();
								$days=$details['leaveCount'];
								$remain_bal=$obj->bal_leave($details,$days);

								if($remain_bal==true)
								{	

									$date_range=$obj->date_range($details);
									$obj->insert_dt_rg($details,$date_range);
								
									$year = date('Y');
									$status="pending";
									$name=json_decode($obj->name($details),true);
									$query="INSERT INTO apply_leave(
									user_id,
									name,
									leave_type,
									image,
									frm_date,
									to_date,
									count,
									full_causaul_leave,
									half_causaul_leave,
									reason,
									status,
									year
									)VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
									;
									$result=$con->prepare($query);
									$result->bind_param('isssssssssss',$details['user_id'],$name,$details['leaveType'],$path,$details['fromDate'],$details['toDate'],$days,$details['full_causaul_leave'],$details['half_causaul_leave'],$details['reason'],$status,$year);
									if($result->execute())
									{
										$id=$result->insert_id;
										$status="pending";
										$query="INSERT INTO funcmgr_apply(apy_lv_id,funct_status)VALUES(?,?)";
										$result=$con->prepare($query);
										$result->bind_param('is',$id,$status);
										if($result->execute())
										{
		//									$functn_id=$result->insert_id;
										//	$obj->send_mail($details,$id);
										//echo "";
										//				return false;
										}

										$query="INSERT INTO postnmgr_apply(apy_lv_id,post_status)VALUES(?,?)";
										$result=$con->prepare($query);
										//$result->bind_param('i',$details['user_id']);
										$result->bind_param('is',$id,$status);
										if($result->execute())
										{
												//		$postn_id=$result->insert_id;
									$obj->send_mail($details,$id);
		//								echo " leave inserted ";
										}

									

									}
								}
								else
								{
								echo "you dont have remaining leaves";
								}	//$obj=new api();

}

public static function bal_leave($details,$days)
	{
		// echo "//<pre>";
		// //prin_r($details);
								global $con;
								//echo $days;

								if($details['leaveType']=='Casual Leave')
								{
											$query="SELECT causaul_leave,full_causaul_leave,half_causaul_leave FROM bal_leave WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('i',$details['user_id']);
											if($result->execute())
											{
												$result->bind_result($casual_leave,$full_causaul_leave,$half_causaul_leave);
												$result->fetch();
											//	echo $casual_leave;
										//	echo 	$bal=$casual_leave-$days;
												if($casual_leave>0)
												{
														$main_total=" ";
														$total_full=" ";
														$total_half=" ";
														if(($details['fromType']==2 || $details['fromType']==3) && ($details['toType']==2 || $details['toType']==3))
														{
															$main_total=$casual_leave-$details['leaveCount'];
															$total_full=$full_causaul_leave;
															$total_half=$half_causaul_leave-2;

														}
														elseif((($details['fromType']==2 || $details['fromType']==3) && ($details['toType']==1)) ||  (($details['toType']==2 || $details['toType']==3) && ($details['fromType']==1)))
														{
															$main_total=$casual_leave-$details['leaveCount'];
															$total_full=$full_causaul_leave-($details['leaveCount']-0.5);
															$total_half=$half_causaul_leave-1;
														}
														elseif($details['fromType']==1 && $details['toType']==1)
														{
															
															$main_total=$casual_leave-$details['leaveCount'];
															$total_full=$full_causaul_leave-$details['leaveCount'];
															$total_half=$half_causaul_leave;
														}

															if($total_full<0 || $total_half<0)
															{
																return false;
															}
															else 
															{
																return true;
															}
															
														// $result->close();
														// $query="UPDATE bal_leave SET causaul_leave=? WHERE user_id=?";
														// $result=$con->prepare($query);
														// $result->bind_param('ii',$bal,$details['user_id']);
														// if($result->execute())
														// {
														// return true;
														// }

												}
												else
												{
												return false;
												}
											}
								}

								elseif($details['leaveType']=='Sick Leave')
								{
										$query="SELECT sick_leave FROM bal_leave WHERE user_id=?";
										$result=$con->prepare($query);
										$result->bind_param('i',$details['user_id']);
										if($result->execute())
										{
												$result->bind_result($sick_leave);
												$result->fetch();
												//echo $casual_leave;
												$bal=$sick_leave-$days;
												if($bal>=0)
												{
													$result->close();
														// $query="UPDATE bal_leave SET sick_leave=? WHERE user_id=?";
														// $result=$con->prepare($query);
														// $result->bind_param('ii',$bal,$details['user_id']);
														// if($result->execute())
														// {
														return true;
														//}

												}
												else
												{
												return false;
												}
										}
								}


								elseif($details['leaveType']=='Annual Leave')
								{
									$query="SELECT annual_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$days;
										//echo $bal;
										if($bal>=0)
										{
											// $result->close();
											// $query="UPDATE bal_leave SET annual_leave=? WHERE user_id=?";
											// $result=$con->prepare($query);
											// $result->bind_param('ii',$bal,$details['user_id']);
											// if($result->execute())
											// {
											return true;
											//}

										}
										else
										{
										return false;
										}
									}
								}

								elseif($details['leaveType']=='Vacation Leave')
								{
									$query="SELECT vacation_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$days;
										echo "bal=". $bal;
										if($bal>=0)
										{
											$result->close();
											// $query="UPDATE bal_leave SET vacation_leave=? WHERE user_id=?";
											// $result=$con->prepare($query);
											// $result->bind_param('ii',$bal,$details['user_id']);
											// if($result->execute())
											// {
											return true;
											//}

										}
										else
										{
										return false;
										}
									}
								}

								elseif($details['leaveType']=='Unpaid Leave')
								{
									$query="SELECT unpaid_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$days;
										//echo $bal;
										if($bal>=0)
										{
											$result->close();
											// $query="UPDATE bal_leave SET unpaid_leave=? WHERE user_id=?";
											// $result=$con->prepare($query);
											// $result->bind_param('ii',$bal,$details['user_id']);
											// if($result->execute())
											// {
											return true;
											//}

										}
										else
										{
										return false;
										}
									}
								}
									elseif($details['leaveType']=='Maternity Leave')
								{
	return true;
										
								}



	}




// public static function send_mail($details,$id)
// {
// 		global $con;
// 		 echo "//<pre>";
// 			  //prin_r($details);
// 		 	  echo "dfdf".$id;
// 		// echo "<br>";
// 		foreach ($details as $key => $value)
// 		{
// 			$query="SELECT 72daccounts.memberID as login_id,72daccounts.username as admin
// 			 	,(SELECT 72daccounts.username FROM user_funcmgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.user_id WHERE user_funcmgr.user_id=?)  AS user
// 			 	,(SELECT 72daccounts.name FROM user_funcmgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.user_id WHERE user_funcmgr.user_id=?) as user_name
// 				FROM user_funcmgr
// 				LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.funcMgr_id
// 					WHERE user_funcmgr.user_id=?";
// 		$result=$con->prepare($query);
// 	//	$result->bind_param('iii',$details['user_id'],$details['user_id'],$details['user_id']);
// 	  $result->bind_param('ii',$details['user_id'],$details['user_id']);
// 		$result->execute();
// 		$get=$result->get_result();
// 				  $array=Array();
// 		while($row=$get->fetch_assoc())
// 		{
// 			$array[]=$row;
// 		}
// 	  //prin_r($array);

// 		$result->close();
// 		$query="SELECT 72daccounts.memberID as login_id,72daccounts.username as admin,(SELECT 72daccounts.username FROM user_posimgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.user_id WHERE user_posimgr.user_id=?) as user,(SELECT 72daccounts.name FROM user_posimgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.user_id WHERE user_posimgr.user_id=?)  as user_name FROM user_posimgr
// 		LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.posiMgr_id
// 		WHERE user_posimgr.user_id=?";
// 		$result=$con->prepare($query);
// 		$result->bind_param('iii',$details['user_id'],$details['user_id'],$details['user_id']);
// 		$result->execute();
// 		$get=$result->get_result();
// 		while($row=$get->fetch_assoc())
// 		{
// 			$array[]=$row;
// 		}

// 		}
// 			//prin_r($array);
// 		//	if($array[0]['admin']==$array[1]['admin'])
// 		if($array[0]['admin']!=$array[1]['admin'])
// 		{
// 								foreach ($array as $key => $value){
// 																	$array[0]['apply_id']=$id;
// 																	$array[0]['type']=$details['leaveType'];
// 																	$array[0]['count']=$details['leaveCount'];
// 																	$array[0]['user_id']=$details['user_id'];
// 																	$array[0]['fromDate']=$details['fromDate'];
// 																	$array[0]['toDate']=$details['toDate'];

// 																	$array[1]['apply_id']=$id;
// 																	$array[1]['type']=$details['leaveType'];
// 																	$array[1]['count']=$details['leaveCount'];
// 																	$array[1]['user_id']=$details['user_id'];
// 																	$array[1]['fromDate']=$details['fromDate'];
// 																	$array[1]['toDate']=$details['toDate'];
// 								}
// 		}
// 		else
// 		{
// 								foreach ($array as $key => $value){
// 																	$array[0]['apply_id']=$id;
// 																	$array[0]['type']=$details['leaveType'];
// 																	$array[0]['count']=$details['leaveCount'];
// 																	$array[0]['user_id']=$details['user_id'];
// 																	$array[0]['fromDate']=$details['fromDate'];
// 																	$array[0]['toDate']=$details['toDate'];
// 																	unset($array[1]);

// 								}
// 		}


// 				//prin_r($array);
// 		//

// 		require_once "login_db.php";
// 			$login=new login();
// 			$login->mangr_mail($array);
// }



public static function send_mail($details,$id)
{
		global $con;
		 // echo "//<pre>";
			//   //prin_r($details);
		 	 // echo "dfdf".$id;
		// echo "<br>";
		foreach ($details as $key => $value)
		{
					$query="SELECT 72daccounts.memberID as login_id,72daccounts.username as admin
					FROM user_funcmgr
					LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.funcMgr_id
					WHERE user_funcmgr.user_id=?";
					$result=$con->prepare($query);
					//	$result->bind_param('iii',$details['user_id'],$details['user_id'],$details['user_id']);
					$result->bind_param('i',$details['user_id']);
					$result->execute();
					$get=$result->get_result();
					$array=Array();
					while($row=$get->fetch_assoc())
					{
						$query2="SELECT 72daccounts.username  as user,72daccounts.name as user_name  FROM user_funcmgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.user_id WHERE user_funcmgr.user_id=?";
						$result2=$con->prepare($query2);
						$result2->bind_param('i',$details['user_id']);
						$result2->execute();
						$get2=$result2->get_result();
						$row[]=$get2->fetch_assoc();
						//$array["fun_mgr"][]=$row;
						$array[]=$row;
					}
		}
		////prin_r($array);

			$result->close();
		foreach ($details as $key => $value)
		{
					$query="SELECT 72daccounts.memberID as login_id,72daccounts.username as admin
					FROM user_posimgr
					LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.posiMgr_id
					WHERE user_posimgr.user_id=?";
					$result=$con->prepare($query);
					//	$result->bind_param('iii',$details['user_id'],$details['user_id'],$details['user_id']);
					$result->bind_param('i',$details['user_id']);
					$result->execute();
					$get=$result->get_result();
					$array2=Array();
					while($row2=$get->fetch_assoc())
					{		
						$query3="SELECT 72daccounts.username as user,72daccounts.name as user_name FROM user_posimgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_posimgr.user_id WHERE user_posimgr.user_id=?";
						$result3=$con->prepare($query3);
						$result3->bind_param('i',$details['user_id']);
						$result3->execute();
						$get3=$result3->get_result();
						$row2[]=$get3->fetch_assoc();
						//$array["postn_mgr"][]=$row2;
						$array2[]=$row2;
					}


		}
			$dataget=array_merge($array,$array2);
			$main=array_unique($dataget, SORT_REGULAR);
	//	//prin_r($main);

			foreach ($main as $key => $value) {
	
						$main[$key]['apply_id']=$id;
						$main[$key]['type']=$details['leaveType'];
						$main[$key]['count']=$details['leaveCount'];
						$main[$key]['user_id']=$details['user_id'];
						$main[$key]['fromDate']=$details['fromDate'];
						$main[$key]['toDate']=$details['toDate'];

																	


		}
		////prin_r($main);

		
		require_once "login_db.php";
			$login=new login();
		//	$login->mangr_mail($array);
				$login->mangr_mail($main);
}

public static function insert_dt_rg($details,$date_range)
{

	global $con;
	$obj=new api();
	$name=json_decode($obj->name($details),true);
		$tooltip="Holiday Pending for ".$name;
		$status="Pending";
				////prin_r($date_range);
						$fromDate = date("j-n-Y", strtotime($details['fromDate']));
						$toDate = date("j-n-Y", strtotime($details['toDate']));
						// $fromDate = '20-4-2022';
						// $toDate = '20-4-2022';
						if($fromDate == $toDate){
							$toDate='';
						}
						foreach ($date_range as $key=> $value) {
							if($fromDate == $value){
								$query="INSERT INTO cal(user_id,name,tooltip,dates,status,type)VALUES(?,?,?,?,?,?)";
			 					$result=$con->prepare($query);
			 					$result->bind_param('isssss',$details['user_id'],$name,$tooltip,$value,$status,$details['fromType']);
			 					if(!$result->execute())
			 					{
			 						echo "error";
			 						return false;
			 					}
							}elseif($toDate == $value){
								$query="INSERT INTO cal(user_id,name,tooltip,dates,status,type)VALUES(?,?,?,?,?,?)";
			 					$result=$con->prepare($query);
			 					$result->bind_param('isssss',$details['user_id'],$name,$tooltip,$value,$status,$details['toType']);
			 					if(!$result->execute())
			 					{
			 						echo "error";
			 						return false;
			 					}
							}else{
								$full=1;
								$query="INSERT INTO cal(user_id,name,tooltip,dates,status,type)VALUES(?,?,?,?,?,?)";
			 					$result=$con->prepare($query);
			 					$result->bind_param('isssss',$details['user_id'],$name,$tooltip,$value,$status,$full);
			 					if(!$result->execute())
			 					{
			 						echo "error";
			 						return false;
			 					}
							}

			 			}

}


public static function date_range($details)
{
			$begin = new DateTime($details['fromDate']);
			$end = new DateTime($details['toDate']);
			$end = $end->modify( '+1 day' );

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			//$t=[];
			foreach($daterange as $date)
			{
			$t[]=$date->format("j-n-Y");
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			return $t;
			//$jsondata=json_encode($t,true);
		//echo  $jsondata;
			//$final_array[$key]['range']=$t;
}


public static function name($details)
	{
		global $con;
		$query="SELECT name FROM 72daccounts WHERE memberID=?";
		$result=$con->prepare($query);
		$result->bind_param('i',$details['user_id']);
		$result->execute();
		$result->bind_result($name);
		$result->fetch();
		return json_encode($name,true);
	}

public static function count_days($details)
	{
		$to=strtotime($details['to_date']);
		$from=strtotime($details['frm_date']);
		$days=[];
		$days[]=($to-$from)/60/60/24+1;
		return json_encode($days,true);
	}


public static function insert_holiday($details)
	{
			////prin_r($details);
			global $con;
			$queryholiday = $con->query("SELECT * FROM holiday_list WHERE dates = '".$details['holiday_date']."' and removed_on is null");
			$COUNT = $queryholiday->num_rows;
			if($COUNT>=1){
				echo "Can't create duplicate dates";
				return;
			}
			$obj=new api();
			$obj->holiday_cal($details);

			$query="INSERT INTO holiday_list(day,dates,holiday)VALUES(?,?,?)";
			$result=$con->prepare($query);
			$result->bind_param('sss',$details['holiday_day'],$details['holiday_date'],$details['holiday_title']);
			if($result->execute())
			{
			//echo "inserted";
			}

	}


public static function del_holiday($details)
{
	//01/01/2021
	//1-1-2021
						global $con;
						$query="UPDATE holiday_list SET removed_on=CURRENT_TIMESTAMP WHERE id=?";
						$result=$con->prepare($query);
						$result->bind_param('i',$details['holiday_id']);
						if($result->execute())
						{
								$date=date_create($details['holiday_date']);
								$dates=date_format($date,"j-n-Y");
							//	$query="DELETE FROM cal WHERE dates=? and name=?";
								$query="UPDATE cal SET removed_on= CURRENT_TIMESTAMP WHERE dates=? and name=?";
								$result=$con->prepare($query);
								$result->bind_param('ss',$dates,$details['holiday_name']);
								if($result->execute())
								{
									return true;
								}
								else
								{
									return false;
								}
						}


}

public static function holiday_cal($details)
{
	global $con;

				$holiday_date=date_create($details['holiday_date']);
				$holiday=date_format($holiday_date,"j-n-Y");
				$tooltip="Holiday for ". $details['holiday_title'];
				$status="holiday";
				$type='4';
				$query="INSERT INTO cal(name,tooltip,dates,status,type)VALUES(?,?,?,?,?)";
				$result=$con->prepare($query);
				$result->bind_param('sssss',$details['holiday_title'],$tooltip,$holiday,$status,$type);
				if($result->execute())
				{
				echo "holiday date inserted ";
				}

}

public static function holiday_list()
	{
				global $con;
				$array=[];
				$query="SELECT * from holiday_list where  removed_on is null";
				$result=$con->prepare($query);
				$result->execute();
				$get=$result->get_result();
				while($row=$get->fetch_assoc())
				{
					if(date('Y')==explode('/',$row['dates'])[2])
					{
					$array[]=$row;					
					}
	
				}

				
				if(!empty($array))
				{
						////prin_r($array);
						$c=array();
						foreach ($array as $key => $value)
						{
								foreach ($value as $key2 => $value2)
								{
									if($key2=='dates')
									{
										$date=date_create($value2);
										$c['date']=date_format($date,"d-F-Y");
									}

									if($key2=='dates')
									{
										$date=date_create($value2);
										$c['up_date']=date('D', strtotime($value['day'])).", ".date_format($date,"j M Y");
									}
									// 1 Oct 2020
									// 01-Oct-2020
									if($key2=='dates')
									{
										$date=date_create($value2);
										$c['2nd_up_date']=date_format($date,"d-M-Y");
									}


									$c[$key2]=$value2;
									//     	 //prin_r($c);
									//

								}
								$d[]=$c;
						}
						////prin_r($d);
						$jsondata=json_encode($d,true);
						return  $jsondata;

				}
				else
				{
				// echo "no";
				$jsondata=json_encode($d[]=null,true);
				return  $jsondata;
				}
	}


public static function workingday_cal($details)
{
	global $con;

				$holiday_date=date_create($details['working_date']);
				$holiday=date_format($holiday_date,"j-n-Y");
				$tooltip="Working for ". $details['working_title'];
				$status="Working";
				$type='5';
				$query="INSERT INTO cal(name,tooltip,dates,status,type)VALUES(?,?,?,?,?)";
				$result=$con->prepare($query);
				$result->bind_param('sssss',$details['working_title'],$tooltip,$holiday,$status,$type);
				if($result->execute())
				{
				echo "working date inserted ";
				}

}


public static function insert_Workinglist($details)
{
		// //prin_r($details);

	global $con;
			$obj=new api();
	 	 	$select_data=json_decode($obj->working_list(),true);
	//		ho $all_data;
			$all_data=json_decode($obj->all_week(),true);




	 	 	if($select_data!=null)
	 	 	{
	 	 	//	echo "yes";

	 	 			$a=[];
					foreach ($select_data as $key => $value) {
						foreach ($value as $key2 => $value2) {
							if($key2=="dates")
							{
								$a[]=$value2;
							}
						}

					}
					$date=date_create($details['working_date']);
				    $workingdate=date_format($date,"Y-m-j");

					if(in_array($details['working_date'],$a))
					{
						echo "This date is already in working_list";
					}
					elseif(in_array($workingdate,$all_data['all']))
					{
							echo "This date is not holiday_date date";
					}
					else
					{
							$obj=new api();
							// $obj->del_cal_holiday($details);
							$obj->workingday_cal($details);


									$query="INSERT INTO working_list(day,dates,holiday)VALUES(?,?,?)";
									$result=$con->prepare($query);
									$result->bind_param('sss',$details['working_day'],$details['working_date'],$details['working_title']);
									if($result->execute())
									{
									//echo "inserted";
									}




	 	 			}
	 	 	}
	 	 	else
	 	 	{

	 	 	// 		$a=[];
					// foreach ($select_data as $key => $value) {
					// 	foreach ($value as $key2 => $value2) {
					// 		if($key2=="dates")
					// 		{
					// 			$a[]=$value2;
					// 		}
					// 	}

					// }
					$date=date_create($details['working_date']);
				    $workingdate=date_format($date,"Y-m-j");

					// if(in_array($details['working_date'],$a))
					// {
					// 	echo "This date is already in working_list";
					// }
					if(in_array($workingdate,$all_data['all']))
					{
							echo "This date is not holiday_date date";
					}
					else
					{
							$obj=new api();
							// $obj->del_cal_holiday($details);
							$obj->workingday_cal($details);


									$query="INSERT INTO working_list(day,dates,holiday)VALUES(?,?,?)";
									$result=$con->prepare($query);
									$result->bind_param('sss',$details['working_day'],$details['working_date'],$details['working_title']);
									if($result->execute())
									{
									//echo "inserted";
									}

	 	 			}
          //	  echo  $data;
					}

}



public static function del_working_list($details)
{
						global $con;
						$query="UPDATE working_list SET removed_on=CURRENT_TIMESTAMP WHERE id=?";
						$result=$con->prepare($query);
						$result->bind_param('i',$details['Working_id']);
						$result->execute();
						{
								$date=date_create($details['Working_date']);
								$dates=date_format($date,"j-n-Y");
								//$query="DELETE FROM cal WHERE dates=? and name=?";
								$query="UPDATE cal SET removed_on= CURRENT_TIMESTAMP WHERE dates=? and name=?";
								$result=$con->prepare($query);
								$result->bind_param('ss',$dates,$details['Working_name']);
								if($result->execute())
								{
									return true;
								}
								else
								{
									return false;
								}
						}
}

public static function working_list()
	{
			global $con;
			$query="SELECT * from  working_list where removed_on is null";
			$result=$con->prepare($query);
			$result->execute();
			$get=$result->get_result();
			while($row=$get->fetch_assoc())
			{
			$array[]=$row;
			}

			if(!empty($array))
			{
			//		//prin_r($array);

			//		//prin_r($array);
			$c=array();
			foreach ($array as $key => $value)
			{
			foreach ($value as $key2 => $value2)
			{


			if($key2=='dates')
			{
			$date=date_create($value2);
			$c['date']=date_format($date,"d-F-Y");
			}

			if($key2=='dates')
			{
			$date=date_create($value2);
			$c['up_date']=date('D', strtotime($value['day'])).", ".date_format($date,"j M Y");
			}

			if($key2=='dates')
			{
			$date=date_create($value2);
			$c['2nd_up_date']=date_format($date,"d-M-Y");
			}

			if($key2=='dates')
			{
			$date=date_create($value2);
			$c['3nd_up_date']=date_format($date,"Y-m-j");
			}




			$c[$key2]=$value2;
			//     	 //prin_r($c);
			//
			}
			$d[]=$c;
			}
					////prin_r($d);
			$jsondata=json_encode($d,true);
			return $jsondata;
			}
			else
			{
			// echo "no";
			$jsondata=json_encode($d[]=null,true);
			return  $jsondata;
			}

}


public static function user_lv_history($user_id)
{
				//apply_leave.id,
			//	echo $user_id;
				global $con;
				$array=[];
				$query="SELECT apply_leave.*,
				funcmgr_apply.funct_status,
				funcmgr_apply.func_approved_date,
				funcmgr_apply.removed_on,
				postnmgr_apply.post_status,
				postnmgr_apply.post_approved_date,
				postnmgr_apply.removed_on
				FROM apply_leave
				LEFT JOIN funcmgr_apply ON funcmgr_apply.apy_lv_id=apply_leave.id
				LEFT JOIN postnmgr_apply ON postnmgr_apply.apy_lv_id=apply_leave.id
				WHERE
				apply_leave.user_id=?  and
				funcmgr_apply.removed_on is NULL AND
				apply_leave.removed_on is NULL and
				postnmgr_apply.removed_on is NULL
				ORDER BY apply_leave.id DESC ";
				$result=$con->prepare($query);
				$result->bind_param('i',$user_id);
				$result->execute();
				$get=$result->get_result();

				while($row=$get->fetch_assoc())
				{
							$array[]=$row;
				}
				////prin_r($array);



						//			//prin_r($array);
				$result->close();
				$query="SELECT apply_leave.*,
				funcmgr_apply.funct_status,
				funcmgr_apply.func_approved_date,
				funcmgr_apply.removed_on,
				postnmgr_apply.post_status,
				postnmgr_apply.post_approved_date,
				postnmgr_apply.removed_on
				FROM apply_leave
				LEFT JOIN funcmgr_apply ON funcmgr_apply.apy_lv_id=apply_leave.id
				LEFT JOIN postnmgr_apply ON postnmgr_apply.apy_lv_id=apply_leave.id
				WHERE
				apply_leave.user_id=?  and
				funcmgr_apply.removed_on is NOT NULL and
				apply_leave.removed_on is  NULL and
				postnmgr_apply.removed_on is NOT NULL and
				funcmgr_apply.funct_status='approved' and
				postnmgr_apply.post_status='approved'
				ORDER BY apply_leave.id DESC ";
				$result=$con->prepare($query);
				$result->bind_param('i',$user_id);
				$result->execute();
				$get=$result->get_result();
				$array2=[];
				while($row=$get->fetch_assoc())
				{
							$array2[]=$row;
				}
				////prin_r($array2);

				if(!empty($array2) && !empty($array2))
				{
					$final_array=array_merge($array,$array2);
					$obj=new api();
					$obj->final_array($final_array);

				}
				elseif(empty($array) && !empty($array2))
				{
						$final_array=$array2;
					$obj=new api();
					$obj->final_array($final_array);
				}
				elseif(!empty($array) && empty($array2))
				{

				$result->close();
				$final_array=$array;
					$obj=new api();
					return $obj->final_array($final_array);
				}
				elseif(empty($array) && empty($array2))
				{

						$jsondata=json_encode($d[]=NULL,true);
						return   $jsondata;
				}

}





public static function final_array($final_array)
				{
					////prin_r($final_array);
				foreach ($final_array as $key => $value)
				{
					foreach ($value as $key2 => $value2)
					{

						if($value['func_approved_date']!='' && $value['post_approved_date']!='')
						{
							if($value['func_approved_date']>$value['post_approved_date'])
							{
							$c['final_approved_date']=$value['func_approved_date'];
							}
							else
							{
							$c['final_approved_date']=$value['post_approved_date'];
							}
						}
						elseif($value['func_approved_date']==null || $value['post_approved_date']==null)
						{
							$c['final_approved_date']="null";
						}
						else
						{
							$c['final_approved_date']="null";
						}

						if($key2=="frm_date")
						{
							$date=date_create($value2);
							$c['from']=date_format($date,"d-M-Y");
						}

						if($key2=="to_date")
						{
						$date=date_create($value2);
						$c['to']=date_format($date,"d-M-Y");
						}

						if($key2=="created_on")
						{
							$date=date_create($value2);
							$c['Req_date']=date_format($date,"d-F-Y h:m");
						}
						if($key2=="count")
						{
							$c['leave_count']=$value2." days";
						}

						if($value['funct_status']=='approved' && $value['post_status']=='approved')
						{
							$c['final_status']="Approved";
						}
						elseif($value['funct_status']=='denied' || $value['post_status']=='denied')
						{
							$c['final_status']="Denied";
						}
						else
						{
							$c['final_status']="Pending";
						}


						$c[$key2]=$value2;
					}
					$d[]=$c;
				}
		//		//prin_r( $d);
		///////////////////////////////////////////////////////////////////////////////////
						$obj=new api();
						$obj->update_status_cal($d);
		///////////////////////////////////////////////////////////////////////////////////////

						$jsondata=json_encode($d,true);
					//echo $jsondata;
					return $jsondata;
				}


public static function update_status_cal($d)
{
	//	//prin_r($d);
	global $con;
		foreach ($d as $key => $value)
		{
					$begin = new DateTime($value['frm_date']);
					$end = new DateTime($value['to_date']);
					$end = $end->modify( '+1 day' );

					$interval = new DateInterval('P1D');
					$daterange = new DatePeriod($begin, $interval ,$end);
					$t=[];
					foreach($daterange as $date)
					{
					$t[]=$date->format("j-n-Y");
					}
					$d[$key]['range']=$t;
		}


			////prin_r($d);
			foreach ($d as $key => $value) {
			//echo 	$value['name'];
			//echo $value['final_status'];
					$tooltip="Holiday ".$value['final_status']." for ".$value['name'];
		foreach ($value as $key2 => $value2)
		 {
			if($key2=='range')
			{
					foreach ($value2 as $key3 => $value3) {
						$query="UPDATE cal SET tooltip=?,status=? WHERE dates=? AND name=?";
						$result=$con->prepare($query);
						$result->bind_param('ssss',$tooltip,$value['final_status'],$value3,$value['name']);
						$result->execute();

							//echo "";



					}
			}
		}
}
		// 	return $t;
}

public static function all_user_id()
{
	global $con;
$array=[];
	////prin_r($_SESSION);
	$query=$con->prepare("SELECT user_id from user_funcmgr where funcMgr_id=?");
	$query->bind_param('i',$_SESSION['user_id']);
	$query->execute();
	$get=$query->get_result();
	while($row=$get->fetch_assoc())
	{
	$array[]=$row['user_id'];
	}

	$query->close();
	$query=$con->prepare("SELECT  user_id from user_posimgr where posiMgr_id=?");
	$query->bind_param('i',$_SESSION['user_id']);
	$query->execute();
	$get=$query->get_result();
	while($row=$get->fetch_assoc())
	{
	if(!in_array($row['user_id'],$array))
	{
	$array[]=$row['user_id'];
	}
	}


	return $array;
}

public static function admin_lv_history()
{
	global $con;
	$query="SELECT apply_leave.*,
				funcmgr_apply.funct_status,
				funcmgr_apply.func_approved_date,
				postnmgr_apply.post_approved_date,
				funcmgr_apply.removed_on,
				postnmgr_apply.removed_on,
				postnmgr_apply.post_status
				  from apply_leave
			LEFT JOIN funcmgr_apply ON  funcmgr_apply.apy_lv_id=apply_leave.id
		   LEFT JOIN postnmgr_apply ON postnmgr_apply.apy_lv_id=apply_leave.id
			WHERE
			  apply_leave.removed_on is null AND
			  funcmgr_apply.removed_on is null AND
			  postnmgr_apply.removed_on is null
			  ORDER BY apply_leave.id DESC";
			$result=$con->prepare($query);
			$result->execute();
			$get=$result->get_result();

			while($row=$get->fetch_assoc())
			{
			$obj=new api();
				$user_list=$obj->all_user_id();
		// 		echo "//<pre>";
		// //prin_r($user_list);
				foreach ($user_list as $key => $value) {
					if($row['user_id']==$value)
					{
				$array[]=$row;
					}
				}

			}
		// 	echo "//<pre>";
		// //prin_r($array);

           if(!empty($array))
				{
				//	//prin_r($array);

					foreach ($array as $key => $value)
					{

							////prin_r($value);
							foreach ($value as $key2 => $value2)
							{
								if($value['func_approved_date']!='' && $value['post_approved_date']!='')
								{
										if($value['func_approved_date']>$value['post_approved_date'])
										{
											$c['final_approved_date']=$value['func_approved_date'];
										}
										else
										{
											$c['final_approved_date']=$value['post_approved_date'];
										}
								}
								elseif($value['func_approved_date']==null || $value['post_approved_date']==null)
								{
									$c['final_approved_date']="";
								}
								else
								{
									$c['final_approved_date']="";
								}


								if($value['funct_status']=='approved' && $value['post_status']=='approved')
								{
										$c['final_status']="Approved";
								}
								elseif($value['funct_status']=='denied' || $value['post_status']=='denied')
								{
									$c['final_status']="Denied";

								}
								else
								{
									$c['final_status']="Pending";
								}

								if($key2=="frm_date")
								{
									$date=date_create($value2);
					     			$c['from']=date_format($date,"d-M-Y");
								}

								if($key2=="to_date")
								{
									$date=date_create($value2);
					     			$c['to']=date_format($date,"d-M-Y");
								}

								if($key2=="created_on")
								{
									$date=date_create($value2);
					     			$c['Req_date']=date_format($date,"d-F-Y h:m");
								}
								if($key2=="count")
								{
					     			$c['leave_count']=$value2." days";
								}
								if($key2=="created_on")
								{
									$date=date_create($value2);
					     			$c['Req_date']=date_format($date,"d-F-Y h:m");
								}

								$c[$key2]=$value2;
							}
					$d[]=$c;
					}
					//					//prin_r($d);

					///////////////////////////////////////////////////////////////////////////////////
				$obj=new api();
				$obj->update_status_cal($d);
						///////////////////////////////////////////////////////////////////////////////////////
					 $jsondata=json_encode($d,true);
					return  $jsondata;
					 //echo $jsondata;
					// $obj=new api();
					// $obj->datepickr_approved($d);
			}
			else
			{
		////prin_r($d);
		$jsondata=json_encode($d[]=NULL,true);
							return  $jsondata;
						//	echo $jsondata;
	}
}




public static function all_user_id_admin($details)
{
			global $con;
			////prin_r($details);
			$query=$con->prepare("SELECT user_id from user_funcmgr where funcMgr_id=?");
			$query->bind_param('i',$details['user_id']);
			$query->execute();
			$get=$query->get_result();
			while($row=$get->fetch_assoc())
			{
			$array[]=$row['user_id'];
			}

			$query->close();
			$query=$con->prepare("SELECT  user_id from user_posimgr where posiMgr_id=?");
			$query->bind_param('i',$details['user_id']);
			$query->execute();
			$get=$query->get_result();
			while($row=$get->fetch_assoc())
			{
			if(!in_array($row['user_id'],$array))
			{
			$array[]=$row['user_id'];
			}
			}

			return $array;
}

public static function admin_select_his($details)
{
	 //echo "//<pre>";
	$array=[];
			//	//prin_r($details);
				////prin_r($_SESSION);
			 // $stime = date("d-m-Y", strtotime($_POST['stime']));
			 //        $etime = date("d-m-Y", strtotime($_POST['etime']));
			//$stime = date("d-m-Y", strtotime($_POST['stime']));
			 	// $stime= '04/19/2022';
			 	// $etime= '04/20/2022';
		 	$obj=new api();


			$stime= date("m/d/Y", strtotime($_POST['stime']));
		 	$etime= date("m/d/Y", strtotime($_POST['etime']));
		 	//echo $stime ." ".$etime;
		 	//$date_list='';
		 	$date_list=$obj->date_range_user_list($_POST['stime'],$_POST['etime']);
			////prin_r ($date_list);
			global $con;
			$query="SELECT apply_leave.*,
						funcmgr_apply.funct_status,
						funcmgr_apply.func_approved_date,
						postnmgr_apply.post_approved_date,
						funcmgr_apply.removed_on,
						postnmgr_apply.removed_on,
						postnmgr_apply.post_status
						  from apply_leave
					LEFT JOIN funcmgr_apply ON  funcmgr_apply.apy_lv_id=apply_leave.id
				   LEFT JOIN postnmgr_apply ON postnmgr_apply.apy_lv_id=apply_leave.id
					WHERE
					  apply_leave.user_id=? and
					  -- apply_leave.frm_date>=? and
					  apply_leave.removed_on is null AND
					  funcmgr_apply.removed_on is null AND
					  postnmgr_apply.removed_on is null
					  ORDER BY apply_leave.id DESC";
					$result=$con->prepare($query);
		//			$result->bind_param('is',$details['name_id'],$stime);
					$result->bind_param('i',$details['name_id']);
					$result->execute();
					$get=$result->get_result();
					while($row=$get->fetch_assoc())
					{
		$user_list=$obj->all_user_id_admin($details);
		$row['date_list']=$obj->date_range_user_list($row['frm_date'],$row['to_date']);
		// echo "//<pre>";
		// 		//prin_r($date_list);
		//if(in_array($etime,$date_list)  || in_array($stime,$date_list))
		//{
				foreach ($user_list as $key => $value) {
							if($row['user_id']==$value)
							{


											foreach ($row['date_list'] as $key2 => $value2) {
												 if(in_array($value2, $date_list))
												 {
												 	if(!in_array($row,$array))
												 	{
												 	$array[]=$row;
												 	}
												 }
												}


							}
						}
		//			}

			}

				// 		echo "//<pre>";
				// //prin_r($array);


				if(!empty($array))
				{
		           if(!empty($array))
						{
						//	//prin_r($array);

							foreach ($array as $key => $value)
							{

									////prin_r($value);
									foreach ($value as $key2 => $value2)
									{
										if($value['func_approved_date']!='' && $value['post_approved_date']!='')
										{
												if($value['func_approved_date']>$value['post_approved_date'])
												{
													$c['final_approved_date']=$value['func_approved_date'];
												}
												else
												{
													$c['final_approved_date']=$value['post_approved_date'];
												}
										}
										elseif($value['func_approved_date']==null || $value['post_approved_date']==null)
										{
											$c['final_approved_date']="";
										}
										else
										{
											$c['final_approved_date']="";
										}


										if($value['funct_status']=='approved' && $value['post_status']=='approved')
										{
												$c['final_status']="Approved";
										}
										elseif($value['funct_status']=='denied' || $value['post_status']=='denied')
										{
											$c['final_status']="Denied";

										}
										else
										{
											$c['final_status']="Pending";
										}

										if($key2=="frm_date")
										{
											$date=date_create($value2);
							     			$c['from']=date_format($date,"d-M-Y");
										}

										if($key2=="to_date")
										{
											$date=date_create($value2);
							     			$c['to']=date_format($date,"d-M-Y");
										}

										if($key2=="created_on")
										{
											$date=date_create($value2);
							     			$c['Req_date']=date_format($date,"d-F-Y h:m");
										}
										if($key2=="count")
										{
							     			$c['leave_count']=$value2." days";
										}
										if($key2=="created_on")
										{
											$date=date_create($value2);
							     			$c['Req_date']=date_format($date,"d-F-Y h:m");
										}

										$c[$key2]=$value2;
									}
							$d[]=$c;
							}
							//					//prin_r($d);

							///////////////////////////////////////////////////////////////////////////////////
						$obj=new api();
						$obj->update_status_cal($d);
								///////////////////////////////////////////////////////////////////////////////////////
							 $jsondata=json_encode($d,true);
							return  $jsondata;
							 //echo $jsondata;
							// $obj=new api();
							// $obj->datepickr_approved($d);
					}
					else
					{
				////prin_r($d);
				$jsondata=json_encode($d[]=NULL,true);
									return  $jsondata;
								//	echo $jsondata;
			}
		}else
		{
			return false;
		}
}

public static function get_his_user_dates($user_id,$stime,$etime)
{
		// echo "//<pre>";
		$obj=new api();
			$stime= date("m/d/Y", strtotime($_POST['stime']));
		 	$etime= date("m/d/Y", strtotime($_POST['etime']));
		 	$date_list=$obj->date_range_user_list($_POST['stime'],$_POST['etime']);
		 	////prin_r($date_list);

		$jsonDecode = json_decode($obj->user_lv_history($user_id), true);
		$array=[];
		foreach ($jsonDecode as $key => $value) {
		$jsonDecode[$key]['date_range']=$obj->date_range_user_list($value['frm_date'],$value['to_date']);
		}

		////prin_r($jsonDecode);


		foreach ($jsonDecode as $key => $value) {
			foreach ($value['date_range'] as $key2 => $value2) {
					if(in_array($value2,$date_list))
					{
						if(!in_array($jsonDecode[$key],$array))
						{
							$array[]=$jsonDecode[$key];
						}
					}

				}
		}
		// echo "//<pre>";
		// //prin_r($array);
		if(empty($array))
		{
			return null;
		}
		else
		{
		return 	 $jsondata=json_encode($array,true);
		}


}




public static function del_user_details($details)
{
		global $con;
	$query="SELECT name,frm_date,to_date,status FROM apply_leave WHERE id=? and user_id=?";
	$result=$con->prepare($query);
	$result->bind_param('ii',$details['apply_id'],$details['user_id']);
	$result->execute();
	$get=$result->get_result();
	while($row=$get->fetch_assoc())
	{
		$array[]=$row;
	}
	//	//prin_r($array);
	$jsondata=json_encode($array,true);
	return $jsondata;
}


public static function del_cal($del_cal)
{
	////prin_r($del_cal);
	global $con;
	foreach ($del_cal as $key => $value) {
												$begin = new DateTime($value['frm_date']);
												$end = new DateTime($value['to_date']);
												$end = $end->modify( '+1 day' );

												$interval = new DateInterval('P1D');
												$daterange = new DatePeriod($begin, $interval ,$end);
												//$t=[];
												foreach($daterange as $date)
												{
												$t[]=$date->format("j-n-Y");
												}
	}
	////prin_r($t);
	foreach ($t as $key => $value) {
	//		$query="DELETE FROM cal WHERE name=? AND dates=?";
		$query="UPDATE cal SET removed_on= CURRENT_TIMESTAMP WHERE  name=? and dates=?";
			$result=$con->prepare($query);
			$result->bind_param('ss',$del_cal[0]['name'],$value);
			if($result->execute())
			{
				echo "deleeted";
			}

	}


}

public static function del_user($details)
{
	global $con;
		////prin_r($details);
		$select_time = $con->query("SELECT `frm_date` FROM apply_leave WHERE id='".$details['apply_id']."' and status = 'approved'");
		$get_time = $select_time->fetch_assoc()['frm_date'];
		if($get_time){
			$time = date("Y-m-d", strtotime($get_time));
			if($time <= date("Y-m-d")){
				echo "You cannot delete past approved holidays";
				return;
			}
		}
		// var_dump($get_time);exit;
		$obj=new api();
		$del_data=json_decode($obj->del_user_details($details),true);

		// echo "//<pre>";
		// //prin_r($del_data);
		$obj->del_cal($del_data);

		$query="UPDATE apply_leave SET removed_on=CURRENT_TIMESTAMP WHERE id=? AND user_id=?";//CURRENT_TIMESTAMP
		//$query="DELETE FROM apply_leave WHERE id=? AND user_id=?";
		$result=$con->prepare($query);
		$result->bind_param('ii',$details['apply_id'],$details['user_id']);
		if($result->execute())
		{
				$result->close();

				$query="UPDATE  funcmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['apply_id']);
				if($result->execute())
				{
					echo "functional manager deleted";
				}
					$result->close();
				$query="UPDATE  postnmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['apply_id']);
				if($result->execute())
				{
					echo "postion manager deleted";
				}
				if($details['leave_type'] == 'Annual Leave'){
					$title = 'annual_leave';
				}elseif($details['leave_type'] == 'Casual Leave'){
					$title = 'causaul_leave';
				}elseif($details['leave_type'] == 'Sick Leave'){
					$title = 'sick_leave';
				}elseif($details['leave_type'] == 'Unpaid Leave'){
					$title = 'unpaid_leave';
				}
				$select_num = $con->query("SELECT `$title` FROM bal_leave WHERE user_id='".$details['user_id']."'");
				$get_num = $select_num->fetch_assoc()[$title];

				//////////////////////////
				if($del_data[0]['status']=='approved')
				{
					////////////////////////////
							$query_num="UPDATE bal_leave SET `$title`=? WHERE user_id=?";
							$result_num=$con->prepare($query_num);
							$new_count = $get_num+$details['count'];
							$result_num->bind_param('si',$new_count,$details['user_id']);
							if($result_num->execute())
							{
								echo "count +";
							}
				}

		}
}



public static function del_admin($details)
{

			global $con;
			$query="SELECT COUNT(id) FROM user_funcmgr WHERE funcMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($func_count);
			$result->fetch();
			//		echo $func_count;


			$result->close();
			$query="SELECT COUNT(id) FROM  user_posimgr WHERE posiMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($postn_count);
			$result->fetch();
			//		echo $postn_count;
			if(($func_count=='1' and $postn_count=='1') || ($func_count=='1' && $postn_count!='1') || ($func_count!='1' && $postn_count=='1'))
			{
				if($details['funct_status']=='approved' && $details['post_status']=='approved')
				{
								$result->close();
								$query="UPDATE  funcmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
								$result=$con->prepare($query);
								$result->bind_param('i',$details['apply_id']);
								if($result->execute())
								{
									echo "functional manager deleted";
								}
								$result->close();
								$query="UPDATE  postnmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
								$result=$con->prepare($query);
								$result->bind_param('i',$details['apply_id']);
								if($result->execute())
								{
									echo "postion manager deleted";
								}
				}
				else
				{
				//	//prin_r($details);
					$obj=new api();
					$result->close();
					$del_data=json_decode($obj->del_user_details($details),true);
					$obj->del_cal($del_data);

						//$result->close();
						$query="UPDATE apply_leave SET removed_on=CURRENT_TIMESTAMP WHERE id=? AND user_id=?";
						$result=$con->prepare($query);
						$result->bind_param('ii',$details['apply_id'],$details['user_id']);
						if($result->execute())
						{
								$result->close();
								$query="UPDATE  funcmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
								$result=$con->prepare($query);
								$result->bind_param('i',$details['apply_id']);
								if($result->execute())
								{
									echo "functional manager deleted";
								}
								$result->close();
								$query="UPDATE  postnmgr_apply SET removed_on=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
								$result=$con->prepare($query);
								$result->bind_param('i',$details['apply_id']);
								if($result->execute())
								{
									echo "postion manager deleted";
								}
						}
				}
			}

			elseif($func_count!='1' && $postn_count!='1')
			{
				echo "Your are not the manager for this user";
			}
}


public static function send_mail2($details)
{
	global $con;
//	echo "//<pre>";
	 //prin_r($details);
	 // echo $details['user_id'];
	//$array=[];


	foreach ($details as $key => $value)
	{
			$query="SELECT 72daccounts.username as admin,72daccounts.memberID
				
					FROM user_funcmgr
					LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.funcMgr_id
     				WHERE user_funcmgr.user_id=?";
		
			$result=$con->prepare($query);
			$result->bind_param('i',$details['user_id']);
			$result->execute();
			$get=$result->get_result();
			$array=[];
			while($row=$get->fetch_assoc())
					{
						$query2="SELECT 72daccounts.username  as user,72daccounts.name as user_name  FROM user_funcmgr LEFT JOIN 72daccounts ON 72daccounts.memberID=user_funcmgr.user_id WHERE user_funcmgr.user_id=?";
						$result2=$con->prepare($query2);
						$result2->bind_param('i',$details['user_id']);
						$result2->execute();
						$get2=$result2->get_result();
						$row[]=$get2->fetch_assoc();
						//$array["fun_mgr"][]=$row;
						$array[]=$row;
					}
				}



			foreach ($array as $key => $value) {
				if($details['login_id']==$value['memberID'])
		{
		
						if($details['funct_status']=="approved" && $details['post_status']=="approved")
						{
							$array['status']="approved";
						}
						elseif($details['funct_status']=="denied" || $details['post_status']=="denied")
						{
							$array['status']="denied";
						}
				
			}
			else
			{
				unset($array[$key]);
			}		
				}


//	print_r($array);
				include "login_db.php";
							$login=new login();
							$login->mangr_mail2($array);
}




public static function approved_status($details)
{
	global $con;
		// 	$obj=new api();
		// $obj->update_unpaid($details);
		////prin_r($details);
	//	global $con;
			$query="SELECT COUNT(id) FROM user_funcmgr WHERE funcMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($func_count);
			$result->fetch();
			//	echo $func_count;


			$result->close();
			$query="SELECT COUNT(id) FROM  user_posimgr WHERE posiMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($postn_count);
			$result->fetch();
			//	echo $postn_count;

			if($func_count=='1' && $postn_count!='1')
			{
					$result->close();
					$obj=new api();
					$obj->FuncMgr_status_approved($details);
			}
			elseif($func_count!='1' && $postn_count=='1')
			{
					$result->close();
					$obj=new api();
					$obj->postMgr_status_approved($details);
			}
			elseif($func_count=='1' && $postn_count=='1')
			{
					$result->close();
					$obj=new api();
				//	$obj->FuncMgr_status_approved($details);
				//	$obj->postMgr_status_approved($details);
					$obj->Coman_approved($details);
					//$obj->postMgr_status_approved2($details);
			}
			elseif($func_count!='1' && $postn_count!='1')
			{
				echo "Your are not the manager for this user";
			}
}


public static function FuncMgr_status_approved($details)
{

	 //	//prin_r($details);
				global $con;
				$query="SELECT funct_status FROM funcmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					 $result->execute();
					$result->bind_result($funct_status);
					$result->fetch();
					if($funct_status=='approved'  && $details['funct_status']=='approved')
					{
						echo "Functional Manager Already Approved";
					}
					elseif($funct_status=='pending' && $details['funct_status']=='approved')
					{
						$result->close();
						$obj=$obj=new api();
						$data=$obj->get_postn_status($details);
						if($data=='pending')
						{
							// $result->close();
							$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Approved";
							}
							/////////////////////////////////
							// $obj=new api();
							// $obj->bal_add($details);
							/////////////////////////////
						}
						elseif($data=='approved')
						{
							//$result->close();
							////prin_r($details);
							$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
			     			//	echo "status updated in main  approved";
							}

							$obj=new api();
							$obj->bal_minus($details);
							$obj->send_mail2($details);

						}
						elseif($data=='denied')
						{
							//$result->close();
							//$obj=new api();
							//$result=$obj->bal_minus($details);
							// if($result)
							// {
									$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['apply_id']);
									if($result->execute())
									{
									echo "Functional Manager Approved";
									}
							// }
							// else
							// {
							// 		echo "You cannot approved. Since you dont have bal";
							// }

						}
					}
					elseif($funct_status=='denied' && $details['funct_status']=='approved')
					{
						$result->close();
						$obj=$obj=new api();
						$data=$obj->get_postn_status($details);
						if($data=='pending')
						{
							// $result->close();
							$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='pending' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							/////////////////////////////////
							//	 $obj=new api();
							 //$obj->bal_minus($details);
							/////////////////////////////
						}
						elseif($data=='approved')
						{
							//$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							$obj=new api();
							$obj->bal_minus($details);
							$obj->send_mail2($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
						//	$obj=new api();
						//	$result=$obj->bal_minus($details);
							// if($result)
							// {
									$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['apply_id']);
									if($result->execute())
									{
									echo "Functional Manager Approved";
									}
							// }
							// else
							// {
							// 		echo "You cannot approved. Since you dont have bal";
							// }

						}
					}


}

public static function Coman_approved($details)
{
	// 	Array
	// (
	//     [apply_id] => 22
	//     [login_id] => 1
	//     [user_id] => 3
	//     [type] => Annual_Leave
	//     [count] => 2
	//     [funct_status] => approved
	//     [post_status] => approved
	// )
	// //prin_r($details);
				global $con;
				$query="SELECT funct_status FROM funcmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					 $result->execute();
					$result->bind_result($funct_status);
					$result->fetch();

					if($funct_status=='approved'  && $details['funct_status']=='approved')
					{
						//echo " comman manager already approved ";
						echo "You Have Already Approved";
					}
					elseif($funct_status=='pending' && $details['funct_status']=='approved')
					{
						$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
								//echo " functional approved ";
								echo "Leave Approved";
							}
								$result->close();
							$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
									//echo " positional approved ";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							$obj=new api();
							$result=$obj->bal_minus($details);
							$obj->send_mail2($details);

					}
					elseif($funct_status=='denied' && $details['funct_status']=='approved')
					{
						$result->close();
						$query="UPDATE funcmgr_apply SET funct_status='approved',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
						$result=$con->prepare($query);
						$result->bind_param('i',$details['apply_id']);
						if($result->execute())
						{
							//echo " functional approved ";
							echo "Leave Approved";
						}
						$result->close();
						$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
						$result=$con->prepare($query);
						$result->bind_param('i',$details['apply_id']);
						if($result->execute())
						{
							//echo " positional approved ";
						}
					//	$result->close();
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
						$obj=new api();
						$obj->bal_minus($details);
						//$obj->bal_add($details);
						$obj->send_mail2($details);

					}
}

public static function postMgr_status_approved($details)
{
	////prin_r($details);
	global $con;
					$query="SELECT post_status FROM postnmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					$result->execute();
					$result->bind_result($postn_status);
					$result->fetch();
					if($postn_status=='approved'  && $details['post_status']=='approved')
					{
						//echo "positional already approved";
						echo "Location Manager Already Approved";
					}
					elseif($postn_status=='pending'  && $details['post_status']=='approved')
					{
							$result->close();
						$obj=$obj=new api();
						$data=$obj->get_Funtn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Location Manager Approved";
							}
							// $obj=new api();
							// $obj->bal_add($details);
						}
						elseif($data=='approved')
						{
							//$result->close();

							$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo "positional approved";
								echo "Location Manager Approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							$obj=new api();
							$obj->bal_minus($details);

						}
						elseif($data=='denied')
						{
							//$result->close();
							//$obj=new api();
							//$result=$obj->bal_minus($details);
							// if($result)
							// {
									$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['apply_id']);
									if($result->execute())
									{
									echo "Location Manager Approved";
									}
							// }
							// else
							// {
							// 		echo "You cannot approved. Since you dont have bal";
							// }
							// $obj=new api();
							// $obj->bal_add($details);
						}
					}
					elseif($postn_status=='denied'  && $details['post_status']=='approved')
					{
							$result->close();
						$obj=$obj=new api();
						$data=$obj->get_Funtn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							  echo "Location Manager Approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='pending' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							//$obj=new api();
							//$obj->bal_minus($details);
						}
						elseif($data=='approved')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Location Manager Approved";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='approved' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  approved";
							}
							$obj=new api();
							$obj->bal_minus($details);
							$obj->send_mail2($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
							//$obj=new api();
							//$result=$obj->bal_minus($details);
							// if($result)
							// {
									$query="UPDATE postnmgr_apply SET post_status='approved',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['apply_id']);
									if($result->execute())
									{
									echo "Location Manager Approved";
									}
							// }
							// else
							// {
							// 		echo "You cannot approved. Since you dont have bal";
							// }
							// $obj=new api();
							// $obj->bal_add($details);
						}
					}
}





public static function denied_status($details)
{
			 //	//prin_r($details);
			global $con;
			$query="SELECT COUNT(id) FROM user_funcmgr WHERE funcMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($func_count);
			$result->fetch();
			//echo $func_count;


			$result->close();
			$query="SELECT COUNT(id) FROM  user_posimgr WHERE posiMgr_id=? and user_id=?";
			$result=$con->prepare($query);
			$result->bind_param('ii',$details['login_id'],$details['user_id']);
			$result->execute();
			$result->bind_result($postn_count);
			$result->fetch();
			//echo $postn_count;



			if($func_count=='1' && $postn_count!='1')
			{
					$result->close();
					$obj=new api();
					$obj->FuncMgr_status_denied($details);
			}
			elseif($func_count!='1' && $postn_count=='1')
			{
					$result->close();
					$obj=new api();
					$obj->postMgr_status_denied($details);

			}
			elseif($func_count=='1' && $postn_count=='1')
			{
					$result->close();
					$obj=new api();
					// $obj->FuncMgr_status_denied($details);
					// $obj->postMgr_status_denied($details);
					$obj->Coman_denied($details);

			}
			elseif($func_count!='1' && $postn_count!='1')
			{
				echo "Your are not the manager for this user";
			}

}


public static function FuncMgr_status_denied($details)
{
				//	//prin_r($details);
					global $con;
					$query="SELECT funct_status FROM funcmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					 $result->execute();
					$result->bind_result($funct_status);
					$result->fetch();
					//echo $funct_status;
					if($funct_status=='denied'  && $details['funct_status']=='denied')
					{
						echo "Functional Manager Already Denied";
					}
					elseif($funct_status=='pending' && $details['funct_status']=='denied')
					{
						$result->close();
						$obj=new api();
						$data=$obj->get_postn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}

							$obj->send_mail2($details);
							//$obj=new api();
							//$obj->bal_add($details);
						}
						elseif($data=='approved')
						{
							//$result->close();
							//echo $details['apply_id'];
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
					//		echo " status updated in main  denied";
							}
	    					 $obj->send_mail2($details);
						//	$obj=new api();
						//	$obj->bal_add($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied.";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
						//	echo " status updated in main  denied";
							}
							 //$obj=new api();
							//$obj->bal_add($details);
						}
					}
					elseif($funct_status=='approved' && $details['funct_status']=='denied')
					{
						$result->close();
						$obj=new api();
						$data=$obj->get_postn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
							$obj->send_mail2($details);
							//$obj=new api();//changes
							//$obj->bal_add($details);
						}
						elseif($data=='approved')
						{
							//$result->close();
							//echo $details['apply_id'];
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
							$obj=new api();
							$obj->bal_add($details);
         					 $obj->send_mail2($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Functional Manager Denied.";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
						//	$obj=new api();
						//	$obj->bal_add($details);
						}
					}
}

public static function Coman_denied($details)
{
				//prin_r($details);
					global $con;
					$query="SELECT funct_status FROM funcmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					 $result->execute();
					$result->bind_result($funct_status);
					$result->fetch();
					//echo $funct_status;
					if($funct_status=='denied'  && $details['funct_status']=='denied')
					{
						echo "You have Already Denied ";
					}
					elseif($funct_status=='pending' && $details['funct_status']=='denied')
					{
							$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
								//echo " functional denied ";
								echo "Leave Denied";
							}
							$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
								//	echo " positional denied ";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
					//		$result->close();
							$obj=new api();
							$obj->send_mail2($details);
							// $obj->bal_add($details);
					}
					elseif($funct_status=='approved' && $details['funct_status']=='denied')
					{
						$result->close();
							$query="UPDATE funcmgr_apply SET funct_status='denied',func_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
								//	echo " functional denied ";
									echo "Leave Denied";
							}
							$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
									//	echo " positional denied ";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
								//echo " status updated in main  denied";
							}
							//$result->close();
							$obj=new api();
							$obj->bal_add($details);
							//$obj->bal_minus($details);
							$obj->send_mail2($details);


					}
}


public static function postMgr_status_denied($details)
{
	// //prin_r($details);
				global $con;
					$query="SELECT post_status FROM postnmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					$result->execute();
					$result->bind_result($postn_status);
					$result->fetch();
					if($postn_status=='denied'  && $details['post_status']=='denied')
					{
						echo "Location Manager Already Denied";
					}
					elseif($postn_status=='pending' && $details['post_status']=='denied')
					{
						$result->close();
						$obj=$obj=new api();
						$data=$obj->get_Funtn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo "positional denied";
								echo "Location Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
     					 $obj->send_mail2($details);
						//	$obj=new api();
							//$obj->bal_add($details);
						}
						elseif($data=='approved')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							 //echo "positional denied";
							echo "Location Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
	   					    $obj->send_mail2($details);
							//$obj=new api();
							//$obj->bal_add($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Location Manager Denied.";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo "status updated in main  denied";
							}
							// $obj=new api();
							// $obj->bal_add($details);
						}
					}
					elseif($postn_status=='approved' && $details['post_status']=='denied')
					{
						$result->close();
						$obj=$obj=new api();
						$data=$obj->get_Funtn_status($details);
						if($data=='pending')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo "positional denied";
								echo "Location Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
	//						echo " status updated in main  denied";
							}
							 $obj->send_mail2($details);


							//$obj=new api();
							//$obj->bal_add($details);
						}
						elseif($data=='approved')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Location Manager Denied";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
							$obj=new api();
							$obj->bal_add($details);
        					 $obj->send_mail2($details);
						}
						elseif($data=='denied')
						{
							//$result->close();
							$query="UPDATE postnmgr_apply SET post_status='denied',post_approved_date=CURRENT_TIMESTAMP WHERE apy_lv_id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							echo "Location Manager Denied.";
							}
							$result->close();
							$query="UPDATE apply_leave SET status='denied' WHERE id=?";
							$result=$con->prepare($query);
							$result->bind_param('i',$details['apply_id']);
							if($result->execute())
							{
							//echo " status updated in main  denied";
							}
							//$obj=new api();
							//$obj->bal_add($details);
						}
					}
}


public static function bal_minus($details)
{
	//prin_r($details);
	// [apply_id] => 6
 //    [login_id] => 1
 //    [user_id] => 3
 //    [type] => Casual Leave
 //    [count] => 1
 //    [funct_status] => approved
 //    [post_status] => approved
 //     [fromType] => 0
 //     [toType] => 2
									global $con;
								//echo $days;
								if($details['type']=='Casual Leave')
								{
											$query="SELECT causaul_leave,full_causaul_leave,half_causaul_leave FROM bal_leave WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('i',$details['user_id']);
											if($result->execute())
											{
												$result->bind_result($casual_leave,$full_causaul_leave,$half_causaul_leave);
												$result->fetch();
											//	echo $casual_leave;
											$bal=$casual_leave-$details['count'];
											$full_causaul_leave_count=$full_causaul_leave-$details['fromType'];
											$half_causaul_leave_count=$half_causaul_leave-$details['toType'];
												if($casual_leave>0)
												{
													
														$result->close();
														$query="UPDATE bal_leave SET causaul_leave=?,full_causaul_leave=?,half_causaul_leave=? WHERE user_id=?";
														$result=$con->prepare($query);
														$result->bind_param('sssi',$bal,$full_causaul_leave_count,$half_causaul_leave_count,$details['user_id']);
														if($result->execute())
														{
														return true;
														}

												}
												else
												{
												return false;
												}
											}
								}
								// if($details['type']=='Casual Leave')
								// {
								// 		$query="SELECT causaul_leave FROM bal_leave WHERE user_id=?";
								// 		$result=$con->prepare($query);
								// 		$result->bind_param('i',$details['user_id']);
								// 		if($result->execute())
								// 		{
								// 			$result->bind_result($casual_leave);
								// 			$result->fetch();
								// 			//echo $casual_leave;
								// 		  $bal=$casual_leave-$details['count'];
								// 			if($bal>=0)
								// 			{
								// 					$result->close();
								// 					$query="UPDATE bal_leave SET causaul_leave=? WHERE user_id=?";
								// 					$result=$con->prepare($query);
								// 					$result->bind_param('si',$bal,$details['user_id']);
								// 					if($result->execute())
								// 					{
								// 								//	return true;
								// 								//echo " you leave is deducted ";
								// 					}

								// 			}
								// 			else
								// 			{
								// 			return false;
								// 			}
								// 		}
								// }

								elseif($details['type']=='Sick Leave')
								{
										$query="SELECT sick_leave FROM bal_leave WHERE user_id=?";
										$result=$con->prepare($query);
										$result->bind_param('i',$details['user_id']);
										if($result->execute())
										{
												$result->bind_result($sick_leave);
												$result->fetch();
												//echo $casual_leave;
												$bal=$sick_leave-$details['count'];
												if($bal>=0)
												{
													$result->close();
														$query="UPDATE bal_leave SET sick_leave=? WHERE user_id=?";
														$result=$con->prepare($query);
														$result->bind_param('si',$bal,$details['user_id']);
														if($result->execute())
														{
														//return true;
													//	echo " you leave is deducted ";
														}

												}
												else
												{
												return false;
												}
										}
								}


								elseif($details['type']=='Annual Leave')
								{
									$query="SELECT annual_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$details['count'];
										//echo $bal;
										if($bal>=0)
										{
												$result->close();
											$query="UPDATE bal_leave SET annual_leave=? WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('si',$bal,$details['user_id']);
											if($result->execute())
											{
										//	return true;
										//echo " you leave is deducted ";
											}

										}
										else
										{
										return false;
										}
									}
								}
								elseif($details['type']=='Vacation Leave')
								{
									$query="SELECT vacation_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$details['count'];
										//echo $bal;
										if($bal>=0)
										{
												$result->close();
											$query="UPDATE bal_leave SET vacation_leave=? WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('si',$bal,$details['user_id']);
											if($result->execute())
											{
										//	return true;
										//echo " you leave is deducted ";
											}

										}
										else
										{
										return false;
										}
									}
								}
								elseif($details['type']=='Unpaid Leave')
								{
									$query="SELECT unpaid_leave FROM bal_leave WHERE user_id=?";
									$result=$con->prepare($query);
									$result->bind_param('i',$details['user_id']);
									if($result->execute())
									{
										$result->bind_result($annual_leave);
										$result->fetch();
										//echo $casual_leave;
										$bal=$annual_leave-$details['count'];
										//echo $bal;
										if($bal>=0)
										{
												$result->close();
											$query="UPDATE bal_leave SET unpaid_leave=? WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('si',$bal,$details['user_id']);
											if($result->execute())
											{
										//	return true;
									//	echo " you leave is deducted ";
											}

										}
										else
										{
										return false;
										}
									}
								}
}

public static function bal_add($details)
{
	////prin_r($details);
				global $con;
				if($details['type']=='Casual Leave')
								{
											$query="SELECT causaul_leave,full_causaul_leave,half_causaul_leave FROM bal_leave WHERE user_id=?";
											$result=$con->prepare($query);
											$result->bind_param('i',$details['user_id']);
											if($result->execute())
											{
												$result->bind_result($casual_leave,$full_causaul_leave,$half_causaul_leave);
												$result->fetch();
											//	echo $casual_leave;
											$bal=$casual_leave+$details['count'];
											$full_causaul_leave_count=$full_causaul_leave+$details['fromType'];
											$half_causaul_leave_count=$half_causaul_leave+$details['toType'];
												// if($casual_leave>0)
												// {
													
														$result->close();
														$query="UPDATE bal_leave SET causaul_leave=?,full_causaul_leave=?,half_causaul_leave=? WHERE user_id=?";
														$result=$con->prepare($query);
														$result->bind_param('sssi',$bal,$full_causaul_leave_count,$half_causaul_leave_count,$details['user_id']);
														if($result->execute())
														{
															//return true;
														}

												// }
												// else
												// {
												// return false;
												// }
											}
								}
				// if($details['type']=='Casual Leave')
				// {

				// $query="SELECT causaul_leave FROM bal_leave WHERE user_id=?";
				// $result=$con->prepare($query);
				// $result->bind_param('i',$details['user_id']);
				// $result->execute();
				// $result->bind_result($leave_count);
				// $result->fetch();
				// $total=$leave_count+$details['count'];
				// $result->close();
				// $query="UPDATE bal_leave SET causaul_leave=? WHERE user_id=?";
				// $result=$con->prepare($query);
				// $result->bind_param('si',$total,$details['user_id']);
				// if($result->execute())
				// {
				// 	//echo " causal leave added ";
				// }
				// }
				elseif($details['type']=='Sick Leave')
				{
				$query="SELECT sick_leave FROM bal_leave WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['user_id']);
				$result->execute();
				$result->bind_result($leave_count);
				$result->fetch();
				$total=$leave_count+$details['count'];
				$result->close();
				$query="UPDATE bal_leave SET sick_leave=? WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('si',$total,$details['user_id']);
				if($result->execute())
				{
					//echo " sick leave added ";
				}
				}
				elseif($details['type']=='Annual Leave')
				{
					//$result->close();
				$query="SELECT annual_leave FROM bal_leave WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['user_id']);
				$result->execute();
				$result->bind_result($leave_count);
				$result->fetch();
				$total=$leave_count+$details['count'];
				$result->close();
				$query="UPDATE bal_leave SET annual_leave=? WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('si',$total,$details['user_id']);
						if($result->execute())
					{
						//echo " annual leave added ";
					}

				}
				elseif($details['type']=='Vacation Leave')
				{
					//$result->close();
				$query="SELECT vacation_leave FROM bal_leave WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['user_id']);
				$result->execute();
				$result->bind_result($leave_count);
				$result->fetch();
				$total=$leave_count+$details['count'];
				$result->close();
				$query="UPDATE bal_leave SET vacation_leave=? WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('si',$total,$details['user_id']);
				if($result->execute())
				{
					//echo " annual leave added ";
				}
			}
				elseif($details['type']=='Unpaid Leave')
				{
				//	$result->close();
				$query="SELECT unpaid_leave FROM bal_leave WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('i',$details['user_id']);
				$result->execute();
				$result->bind_result($leave_count);
				$result->fetch();
				$total=$leave_count+$details['count'];

				$result->close();
				$query="UPDATE bal_leave SET unpaid_leave=? WHERE user_id=?";
				$result=$con->prepare($query);
				$result->bind_param('si',$total,$details['user_id']);
				if($result->execute())
				{
					//echo " Unpaid leave added ";
				}
				}

}

public static function get_Funtn_status($details)
{
	//					//prin_r($details);
					global $con;
					$query="SELECT funct_status FROM funcmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					$result->execute();
					$result->bind_result($funct_status);
					$result->fetch();
					return $funct_status;
}

public static function get_postn_status($details)
{
					////prin_r($details);
					//$result->close();
					global $con;
					$query="SELECT post_status FROM postnmgr_apply WHERE apy_lv_id=?";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['apply_id']);
					$result->execute();
					$result->bind_result($post_status);
					$result->fetch();
				return $post_status;
}


public static function loctn_list()
{
	global $con;
	$query="SELECT * FROM location";
	$result=$con->prepare($query);
	$result->execute();
	$get=$result->get_result();
	while($row=$get->fetch_assoc())
	{
		$array[]=$row;
	}
	$jsondata=json_encode($array,true);
	return $jsondata;
}

public static function yr_list()
{
	global $con;
	$query="SELECT * FROM year";
	$result=$con->prepare($query);
	$result->execute();
	$get=$result->get_result();
	while($row=$get->fetch_assoc())
	{
		$array[]=$row;
	}
	$jsondata=json_encode($array,true);
	return $jsondata;
}



public static function datepicker_working_list()
{
			global $con;
			$query="SELECT * from  working_list where removed_on is null";
			$result=$con->prepare($query);
			$result->execute();
			$get=$result->get_result();
			while($row=$get->fetch_assoc())
			{
			$array[]=$row;
			}

			if(!empty($array))
			{
			//		//prin_r($array);

			//		//prin_r($array);
			$c=array();
						foreach ($array as $key => $value)
						{
							foreach ($value as $key2 => $value2)
								{
									if($key2=='dates')
									{
									$date=date_create($value2);
									$c['date']=date_format($date,"d-F-Y");
									}

									if($key2=='dates')
									{
									$date=date_create($value2);
									$c['up_date']=date('D', strtotime($value['day'])).", ".date_format($date,"j M Y");
									}

									if($key2=='dates')
									{
									$date=date_create($value2);
									$c['Working_day']=date_format($date,"j-m-Y");
									}

									if($key2=='dates')
									{
									$date=date_create($value2);
									$c['up_date2']=date_format($date,"Y-m-d");
									}

									if($key2=='dates')
									{
									$date=date_create($value2);
									$c['up_date3']=date_format($date,"j-n-Y");
									}




									$c[$key2]=$value2;
									//     	 //prin_r($c);
									//
									}
									$d[]=$c;
						}
					//	//prin_r($d);
			 $jsondata=json_encode($d,true);
			 return   $jsondata;
			}
			else
			{
			// echo "no";
			$jsondata=json_encode($d[]=null,true);
			return  $jsondata;
			}

}

public static function only_sat_sun()
{
				// $date = '2022-01-01';
				// $end = '2022-12-' . date('t', strtotime($date)); //get end date of month


	$date = date('Y').'-01-01';
	$end = date('Y').'-12-' . date('t', strtotime($date)); //get end date of month
				// <!-- <table border="1"> -->

				while(strtotime($date) <= strtotime($end))
				{

								$day_num = date('d', strtotime($date));
								$day_name = date('l', strtotime($date));
								$m = date('m', strtotime($date));

								$year2 = date('j-n-Y', strtotime($date));



								$year = date('Y-m-d', strtotime($date));
								$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
								// echo "<tr><td>$day_num-$m-$year-$day_name</td></tr>";
								$t2[]="$year2-$day_name";
								$t[]="$year-$day_name";

				}
				////prin_r($t);
				foreach ($t2 as $key => $value)
				{
							if (strpos($value, 'Saturday') !== false)
							{
							$s[]=$value;
							}
							if(strpos($value, 'Sunday') !== false)
							{
							$s[]=$value;
							}
				}

				foreach ($s as $key => $value)
				{

						$words=['-Saturday','-Sunday'];
						$d['sun'][]=str_replace($words,"",$value);
				}

				// $jsondata=json_encode($d,true);
				// return $jsondata;


				$obj=new api();
				$workingdata=json_decode($obj->datepicker_working_list(),true);
					//		//prin_r($workingdata);
				$c=[];
				if($workingdata!=null)
				{
									foreach ($workingdata as $key => $value)
									{
											foreach ($value as $key2 => $value2)
											 {
													if($key2=='Working_day')
													{
														$c[]=$value2;
													}
											}
									}
											//									//prin_r($c);


									foreach ($d as $key => $value)
									{

												if($key=='sun')
												{
															foreach ($value as $key3 => $value3)
															{
															//											echo $value3;
																		foreach ($c as $key2 => $value2)
																		{
																								if($value2==$value3)
																								{
																									unset($d['sun'][$key3]);
																								}
																					}
																}

												}


									}

								////prin_r($d);

									foreach ($d as $key => $value)
									{
												if ($key=="sun")
												{
													foreach ($value as $key2 => $value2)
													{
														$d2['sun'][]=$value2;
													}
												}

									}
									////prin_r($d2);
									$m=[];
									foreach ($d2 as $key => $value)
									{
											if($key=="sun")
											{
												foreach ($value as $key2 => $value2)
												{
														$value22=date_create($value2);
														$m['sun'][]=date_format($value22,'j-m-Y');
												}
											}
									}

									////prin_r($m);

									$jsondata=json_encode($m,true);
									return $jsondata;
									//echo $jsondata;

				}
				else
				{

				$jsondata=json_encode($d,true);
				return      $jsondata;
					//echo $jsondata;
				}
}


public static function date_picker_holiday_list()
{
				global $con;
				$query="SELECT * from  holiday_list where removed_on is null";
				$result=$con->prepare($query);
				$result->execute();
				$get=$result->get_result();
				while($row=$get->fetch_assoc())
				{
				$array[]=$row;
				}
				if(!empty($array))
				{
					//	//prin_r($array);
				$c=array();
				foreach ($array as $key => $value)
				{
								foreach ($value as $key2 => $value2)
								{


								if($key2=='dates')
								{
								$date=date_create($value2);
								$c['date']=date_format($date,"d-F-Y");
								}

								if($key2=='dates')
								{
								$date=date_create($value2);
								$c['up_date']=date('D', strtotime($value['day'])).", ".date_format($date,"j M Y");
								}
								// 1 Oct 2020
								// 01-Oct-2020
								if($key2=='dates')
								{
								 $date=date_create($value2);
								  $c['holiday_date']=date_format($date,"Y-m-d");
                                                             	//	 $c['holiday_date']=date_format($date,"Y-m-j");
							//	$c['holiday_date']=date(DATE_ISO8601, strtotime($value2));
								//$c['holiday_date']=strtotime($value2);
								//$milliseconds = round(microtime($value2) * 1000);
								//$c['holiday_date']=$milliseconds;
								}

								if($key2=='dates')
								{
								 $date=date_create($value2);
								 $c['holiday_date2']=date_format($date,"j-m-Y");
							//	$c['holiday_date']=date(DATE_ISO8601, strtotime($value2));
								//$c['holiday_date']=strtotime($value2);
								//$milliseconds = round(microtime($value2) * 1000);
								//$c['holiday_date']=$milliseconds;
								}



								if($key2=='dates')
								{
								 $date=date_create($value2);
								 $c['holiday_date3']=date_format($date,"j-n-Y");
								}


								$c[$key2]=$value2;
								//     	 //prin_r($c);
								//

								}
								$d[]=$c;
				}
				 $jsondata=json_encode($d,true);
				return    $jsondata;
				// $jsondata;
				}
				else
				{
				// echo "no";
				$jsondata=json_encode($d[]=null,true);
				return   $jsondata;
			//	echo $jsondata;
				}
}


public static function sat_sun()
{
				// $date = '2022-01-01';
				// $end = '2022-12-' . date('t', strtotime($date)); //get end date of month

		$date = date('Y').'-01-01';
 $end = date('Y').'-12-' . date('t', strtotime($date)); //get end date of month

				// <!-- <table border="1"> -->

				while(strtotime($date) <= strtotime($end))
				{

				$day_num = date('d', strtotime($date));
				$day_name = date('l', strtotime($date));
				$m = date('m', strtotime($date));
				// $year = date('Y-m-j', strtotime($date));
				$year = date('Y-m-d', strtotime($date));
				$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
				// echo "<tr><td>$day_num-$m-$year-$day_name</td></tr>";
				$t[]="$year-$day_name";

				}
				////prin_r($t);
				foreach ($t as $key => $value)
				{
				if (strpos($value, 'Saturday') !== false)
				  {
				  $s[]=$value;
				  }
				if(strpos($value, 'Sunday') !== false)
				  {
				  $s[]=$value;
				  }
				}

				foreach ($s as $key => $value)
				{

				$words=['-Saturday','-Sunday'];
				$d['sun'][]=str_replace($words,"",$value);
				}
				////prin_r($d);


				$obj=new api();
				$workingdata=json_decode($obj->datepicker_working_list(),true);
				////prin_r($workingdata);
				$c=[];
				if($workingdata!=null)
				{
				foreach ($workingdata as $key => $value) {
				foreach ($value as $key2 => $value2) {
					if($key2=='up_date2')
					{
						$c[]=$value2;
					}
				}
				}
				////prin_r($c);


				// foreach ($d['sun'] as $key => $value)
				// 			{
				// 						foreach ($c as $key2 => $value2)
				// 						{
				// 							if($value2==$value)
				// 							{
				// 								unset($d['sun'][$key]);
				// 							}
				// 						}
				// 			}
				foreach ($d as $key => $value)
				{

					if($key=='sun')
					{
								foreach ($value as $key3 => $value3)
								{
				//											echo $value3;
														foreach ($c as $key2 => $value2)
													{
														if($value2==$value3)
														{
															unset($d['sun'][$key3]);
														}
													}
								}

					}


				}



				foreach ($d as $key => $value) {
				if ($key=="sun") {
				foreach ($value as $key2 => $value2) {
				$d2['sun'][]=$value2;
					}
				}

								}
								////prin_r($d);
				$jsondata=json_encode($d2,true);
				return  $jsondata;

				}
				else
				{
				$jsondata=json_encode($d,true);
				return      $jsondata;
				//	echo $jsondata;
				}
}

public static function all_week()
{
	// $date = '2022-01-01';
	// $end = '2022-12-' . date('t', strtotime($date)); //get end date of month


	$date = date('Y').'-01-01';
	$end = date('Y').'-12-' . date('t', strtotime($date)); //get end date of month




	while(strtotime($date) <= strtotime($end))
	{

	$day_num = date('d', strtotime($date));
	$day_name = date('l', strtotime($date));
	$m = date('m', strtotime($date));
	$year = date('Y-m-j', strtotime($date));
	$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
	// echo "<tr><td>$day_num-$m-$year-$day_name</td></tr>";
	$t[]="$year-$day_name";

	}
	// echo "</table>";
	////prin_r($t);
	foreach ($t as $key => $value)
	{
	if (strpos($value, 'Monday') !== false)
	{
	$s[]=$value;
	}
	if(strpos($value, 'Tuesday') !== false)
	{
	$s[]=$value;
	}
	if(strpos($value, 'Wednesday') !== false)
	{
	$s[]=$value;
	}
	if(strpos($value, 'Thursday') !== false)
	{
	$s[]=$value;
	}
	if(strpos($value, 'Friday') !== false)
	{
	$s[]=$value;
	}
	}

	////prin_r($s);


	foreach ($s as $key => $value)
	{

	$words=['-Monday','-Tuesday','-Wednesday','-Thursday','-Friday'];
	$d['all'][]=str_replace($words,"",$value);
	}

	////prin_r($d);
	$jsondata=json_encode($d,true);
	return      $jsondata;
}

// public static function get_data()
// {
// 	global $con;
// 	$query="SELECT dates,GROUP_CONCAT(tooltip  SEPARATOR', ' ) as tooltips,GROUP_CONCAT(status  SEPARATOR', ' ) as statuss FROM cal group by dates";
// 	$result=$con->prepare($query);
// 	$result->execute();
// 	$get=$result->get_result();
// 	while($row=$get->fetch_assoc())
// 	{
// 		$array[]=$row;
// 	}

// 		////prin_r($array);
// 	if(!empty($array))
// 	{
// 	$jsondata=json_encode($array,true);
// 	return $jsondata;
// 	}
// 	else
// 		{
// 		$jsondata=json_encode($array=null,true);
// 	return $jsondata;
// 		}
// }


public static function get_data()
{
	global $con;
	session_start();
	// $_SESSION['user_id'] = 3;
	// $_POST['name'] = 'siddhant sawant';
	$array = [];
	$array2 = [];
	$array3 = [];
	$team_r = [];
	$session_name = $con->query("SELECT name FROM 72daccounts WHERE memberID='".$_SESSION['user_id']."'");
	$login_name = $session_name->fetch_assoc()['name'];
	$list = "'".$login_name."'";
	if(!empty($_POST['name']))
	{
        $name = $_POST['name'];
        $where="AND name like '%".$name."%'";
        $team_r = 'true';
    }
    else
    {
    	$team = $con->query("SELECT admin_user_list.user_id,72daccounts.name,admin_user_list.admin_id FROM admin_user_list LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.user_id WHERE admin_user_list.admin_id = '".$_SESSION['user_id']."'");
	    while ($get_team = $team->fetch_assoc())
	    {
	    	$list .= ",'".$get_team['name']."'";
	    	$team_r[] = $get_team;
	    }
	    $admin_name = $con->query("SELECT admin_id,72daccounts.name FROM admin_user_list  LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.admin_id WHERE user_id='".$_SESSION['user_id']."'");
    	$admin = $admin_name->fetch_assoc();
		$admin_id = $admin['admin_id'];
		// var_dump($admin_id);exit;
		if(!empty($admin_id)){
			$list .= ",'".$admin['name']."'";
			$team_2 = $con->query("SELECT admin_user_list.user_id,72daccounts.name,admin_user_list.admin_id FROM admin_user_list LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.user_id WHERE admin_user_list.admin_id = $admin_id and admin_user_list.user_id != '".$_SESSION['user_id']."'");
    		while ($get_team2 = $team_2->fetch_assoc()) {
    			$list .= ",'".$get_team2['name']."'";
    		}
		}
		///// select name
		$where = "AND name IN ($list)";
    }

    if(!empty($_POST['stime']))
    {
        $stime = date("Y-n", strtotime($_POST['stime']));
        // var_dump($stime);
        // $etime = date("d-m-Y", strtotime($_POST['etime']));
        if(!empty($stime) && empty($_POST['etime'])){
            $where2 = " having ndate >= '$stime'";
        }else{
        	$etime = date("Y-n", strtotime("+1 month",strtotime($_POST['etime'])));
            $where2 = " having ndate between '$stime' AND '$etime'";
        }
    }
    else
    {
    	$where2 = '';
    }
    if(empty($team_r)){
    	////////////////////// user
    	$query="SELECT dates,GROUP_CONCAT(tooltip  SEPARATOR', ' ) as tooltips,GROUP_CONCAT(status  SEPARATOR', ' ) as statuss,concat( SUBSTRING_INDEX(dates, '-' ,- 1), '-', SUBSTRING_INDEX( SUBSTRING_INDEX(dates, '-', 2), '-' ,- 1 ), '-', SUBSTRING_INDEX(dates, '-', 1) ) as ndate,GROUP_CONCAT(type  SEPARATOR', ' ) as type FROM cal WHERE removed_on is null AND status != 'Denied' {$where} group by dates {$where2} order by dates asc";
			// var_dump($query);exit;
		$result=$con->prepare($query);
		$result->execute();
		$get=$result->get_result();
		while($row=$get->fetch_assoc())
		{
			$array[]=$row;
		}
		$query_2="SELECT dates,GROUP_CONCAT(tooltip  SEPARATOR', ' ) as tooltips,GROUP_CONCAT(status  SEPARATOR', ' ) as statuss,concat( SUBSTRING_INDEX(dates, '-' ,- 1), '-', SUBSTRING_INDEX( SUBSTRING_INDEX(dates, '-', 2), '-' ,- 1 ), '-', SUBSTRING_INDEX(dates, '-', 1) ) as ndate,GROUP_CONCAT(type  SEPARATOR', ' ) as type FROM cal WHERE removed_on is null AND status = 'Denied' AND name = '$login_name' {$where} group by dates {$where2} order by dates asc";
		$result_2=$con->query($query_2);
		if($result_2){
			while($row_2=$result_2->fetch_assoc()){
				$array2[]=$row_2;
				// array_push($array, $row_2);
			}
		}
		foreach ($array as $key => $value) {
			foreach ($array2 as $k => $v) {
				if($value['dates'] == $v['dates']){
					$array[$key]['statuss'] = $array[$key]['statuss'].', '.$array2[$k]['statuss'];
					$array[$key]['tooltips'] = $array[$key]['tooltips'].', '.$array2[$k]['tooltips'];
					$array[$key]['type'] = $array[$key]['type'].', '.$array2[$k]['type'];
				}else{
					array_push($array, $array2[$k]);
				}
			}
		}
		if(empty($array)){
			$array = $array2;
		}
		//////////////////////
    }else{
    	////////////////////// admin
		$query="SELECT dates,GROUP_CONCAT(tooltip  SEPARATOR', ' ) as tooltips,GROUP_CONCAT(status  SEPARATOR', ' ) as statuss,concat( SUBSTRING_INDEX(dates, '-' ,- 1), '-', SUBSTRING_INDEX( SUBSTRING_INDEX(dates, '-', 2), '-' ,- 1 ), '-', SUBSTRING_INDEX(dates, '-', 1) ) as ndate,GROUP_CONCAT(type  SEPARATOR', ' ) as type FROM cal WHERE removed_on is null {$where} group by dates {$where2} order by dates asc";
		$result=$con->prepare($query);
		$result->execute();
		$get=$result->get_result();
		while($row=$get->fetch_assoc())
		{
			$array[]=$row;
		}
		//////////////////////
    }
    $query_3="SELECT dates,GROUP_CONCAT(tooltip  SEPARATOR', ' ) as tooltips,GROUP_CONCAT(status  SEPARATOR', ' ) as statuss,concat( SUBSTRING_INDEX(dates, '-' ,- 1), '-', SUBSTRING_INDEX( SUBSTRING_INDEX(dates, '-', 2), '-' ,- 1 ), '-', SUBSTRING_INDEX(dates, '-', 1) ) as ndate,type FROM cal WHERE removed_on is null AND  (type =4 or type=5) group by dates order by dates asc";
	$result_3=$con->query($query_3);
	if($result_3){
		while($row_3=$result_3->fetch_assoc()){
			$array3[]=$row_3;
		}
	}
	foreach ($array as $k2 => $value) {
		foreach ($array3 as $k3 => $v) {
			if($value['dates'] == $v['dates']){
				$array[$k2]['statuss'] = $array[$k2]['statuss'].', '.$array3[$k3]['statuss'];
				$array[$k2]['tooltips'] = $array[$k2]['tooltips'].', '.$array3[$k3]['tooltips'];
				$array[$k2]['type'] = $array[$k2]['type'].', '.$array3[$k3]['type'];
			}else{
				array_push($array, $array3[$k3]);
			}
		}
	}
	if(empty($array)){
		$array = $array2;
	}
	// echo "//<pre>";
	// //prin_r($array);
    if(!empty($array)){
    	$array = api::more_array_unique($array);
		$jsondata=json_encode($array,true);
		return $jsondata;
	}else{
	//		echo "dfd";
		$jsondata=json_encode($array=[],true);
		return $jsondata;
	}

}
public static function more_array_unique($arr) {
	foreach($arr[0] as $k => $v){
		$arr_inner_key[]= $k;
	}
	foreach ($arr as $k => $v){
		$v =join("^",$v);
		$temp[$k] =$v;
	}
	$temp =array_unique($temp);
	foreach ($temp as $k => $v){
		$a = explode("^",$v);
		$arr_after[$k]= array_combine($arr_inner_key,$a);
	}
	return $arr_after;
}
public static function Orview_date_range()
{
			$monday = strtotime("last monday");
		$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

		$friday = strtotime(date("Y-m-d",$monday)." +4 days");

		$this_week_sd = date("Y-m-d",$monday);
		$this_week_ed = date("Y-m-d",$friday);

		$r="Current week range from $this_week_sd to $this_week_ed ";
		return $r;
}

public static function Orview_table()
{
				global $con;
				$monday = strtotime("last monday");
			$monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;

			$friday = strtotime(date("Y-m-d",$monday)." +4 days");

			$start = date("Y-m-d",$monday);
			$end = date("Y-m-d",$friday);

			//echo "Current week range from $this_week_sd to $this_week_ed ";
			// $start='4-1-2021';
			// $end='8-1-2021';
			$begin = new DateTime($start);
			            $end = new DateTime($end);
			            $end = $end->modify( '+1 day' );

			            $interval = new DateInterval('P1D');
			            $daterange = new DatePeriod($begin, $interval ,$end);
			            //$t=[];
			            foreach($daterange as $date)
			            {
			            $t[]=$date->format("j-n-Y");
			            }
			////prin_r($t);

			$array=Array();

			foreach ($t as $key => $value) {
			$query="SELECT * FROM cal WHERE dates='$value' and removed_on is null";
			$result=$con->prepare($query);

			$result->execute();
			$get=$result->get_result();
			$a=[];
			while($row=$get->fetch_assoc())
				{
				$a[]=$row;
				}
				$array[]=$a;
			}
			return $array;

			// $a=[];
			// while($row = $result->fetch_assoc()) {
			//     $a[]=$row;

			//   }
			//   $array[]=$a;

			// }


}


public static function team_list(){
	global $con;
	session_start();
	//$_SESSION['user_id'] = '1';
	$list = [];
	$query = $con->query("SELECT admin_user_list.user_id,72daccounts.name FROM admin_user_list LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.user_id WHERE admin_user_list.admin_id = '".$_SESSION['user_id']."'");
	$COUNT = $query->num_rows;
    while ($get = $query->fetch_assoc()) {
        $list[] = $get;
    }

    if(empty($list)){
    	$admin_name = $con->query("SELECT admin_id,72daccounts.name FROM admin_user_list  LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.admin_id WHERE user_id='".$_SESSION['user_id']."'");
    	$admin = $admin_name->fetch_assoc();
    	// var_dump($admin);exit;
    	if(!empty($admin)){
    		$admin_id = $admin['admin_id'];
			$query2 = $con->query("SELECT  admin_user_list.user_id,72daccounts.name FROM admin_user_list LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.user_id WHERE admin_user_list.admin_id = $admin_id and admin_user_list.user_id != '".$_SESSION['user_id']."'");
			$COUNT = $query2->num_rows;
			while ($get2 = $query2->fetch_assoc()) {
		        $list[] = $get2;
		    }
		    $arr1 = [
		        'user_id' => $admin_id,
		        'name' => $admin['name']
		    ];
		    $COUNT = $COUNT+1;
		    array_push($list,$arr1);

    	}

    }


    // echo "<pre>";
    // print_r($list);
    $admin_name2 = $con->query("SELECT name FROM 72daccounts WHERE memberID='".$_SESSION['user_id']."'");
    	$admin2 = $admin_name2->fetch_assoc();
    	if(!in_array($_SESSION['user_id'], array_column($list, 'user_id')))
    	{
    		$arr2 = [
		        'user_id' => $_SESSION['user_id'],
		        'name' => $admin2['name']
		    ];
		     $COUNT = $COUNT+1;
		     array_push($list,$arr2);
    	}
    	
    	// $arr2 = [
		   //      'user_id' => $_SESSION['user_id'],
		   //      'name' => $admin2['name']
		   //  ];
		   //   $COUNT = $COUNT+1;
		   //   array_push($list,$arr2);

    $arr = [
        'code' => 0,
        'data' => $list,
        'count' => $COUNT
    ];
    // echo "<pre>";
    // print_r($arr);
return $arr;
}

public static function check_login()
{
		// echo $_SESSION['user_id']=1;
	$query=db::$con->query("SELECT count(staffID) as position from staffinfo where staffID='".$_SESSION['user_id']."' and clearanceLevel >3 and removed_on is null");
	$row=$query->fetch_assoc()['position'];
	if($row==1)
	{
	 return true;
	}
	else
	{
		return false;
	}
}

public static function date_range_user_list($stime,$etime)
{
	// echo $stime;
	// echo $etime;
	// $stime='04/19/2022';
	// $etime='04/22/2022';
			$begin = new DateTime($stime);
			$end = new DateTime($etime);
			$end = $end->modify( '+1 day' );

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			//$t=[];
			foreach($daterange as $date)
			{
			$t[]=$date->format("m/d/Y");
			}
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			return $t;
		// 	$jsondata=json_encode($t,true);
		// echo  $jsondata;
			//$final_array[$key]['range']=$t;

}
public static function edit_box_count($start,$end)
{
				global $con;
				$obj=new api();
				$date1=date_create($start);
				$dates1=date_format($date1,"j-n-Y");

				$date2=date_create($end);
				$dates2=date_format($date2,"j-n-Y");

				$range=$obj->date_range_user_list($dates1,$dates2);
				// echo "//<pre>";
				// //prin_r($range);


				$holiday_range=json_decode($obj->date_picker_holiday_list(),true);
				////prin_r($holiday_range);
				$working_range=json_decode($obj->datepicker_working_list(),true);
				////prin_r($working_range);
				$sat_sun_range=json_decode($obj->sat_sun(),true);
				////prin_r($sat_sun_range);


				foreach ($range as $key => $value) {
				$dat=date_create($value);
				$dat1=date_format($dat,"Y-m-d");
				if(!empty($holiday_range))
				{
				foreach ($holiday_range as $key2 => $value2) {

				if($dat1==$value2['holiday_date'])
				{
					unset($range[$key]);
				}
				}
				}


				// if(!empty($working_range))
				// {
				// 	foreach ($working_range as $key3 => $value3) {
				// 		if($dat1==$value3['up_date2'])
				// 		{
				// 			unset($range[$key]);

				// 		}

				// 	}

				// }


				foreach ($sat_sun_range['sun'] as $key4 => $value4) {
				if($dat1==$value4)
				{
				unset($range[$key]);
				}


				}

				}
				return count($range);

}
// public static function edit_box($details)
// {
// 	print_r($details);
// 		global $con;
// 		$query="SELECT apply_leave.*,bal_leave.* FROM apply_leave
// 		 LEFT JOIN bal_leave ON bal_leave.user_id=apply_leave.user_id
// 		 WHERE apply_leave.id=? AND apply_leave.user_id=? and apply_leave.removed_on is null";
// 		$result=$con->prepare($query);
// 		$result->bind_param('ii',$details['apply_id'],$details['user_id']);
// 		$result->execute();
// 		$get=$result->get_result();

// 		while($row=$get->fetch_assoc())
// 		{
// 							$date1=date_create($row['frm_date']);
// 							$dates1=date_format($date1,"j-n-Y");

// 							$date2=date_create($row['to_date']);
// 							$dates2=date_format($date2,"j-n-Y");

// 							$query2="SELECT type FROM cal WHERE name=? AND dates=? and removed_on is null";
// 							$result2=$con->prepare($query2);
// 							$result2->bind_param('ss',$row['name'],$dates1);
// 							$result2->execute();
// 							$get2=$result2->get_result();
// 							$row2=$get2->fetch_assoc();
// 							$row['from_type']=$row2['type'];



// 							$query3="SELECT type FROM cal WHERE name=? AND dates=? and removed_on is null";
// 							$result3=$con->prepare($query3);
// 							$result3->bind_param('ss',$row['name'],$dates2);
// 							$result3->execute();
// 							$get3=$result3->get_result();
// 							$row3=$get3->fetch_assoc();
// 							$row['to_type']=$row3['type'];



// 							$obj=new api();
// 							$row['days_count']=$obj->edit_box_count($dates1,$dates2);
// 							$array[]=$row;
// 			}


// 			// echo "<pre>";
// 			// print_r($array);

// 					$obj=new api();
// 					$obj->pop_up_user($array);

// }

public static function edit_box($details)
{
	//print_r($details);
		global $con;
		$query="SELECT apply_leave.*,bal_leave.user_id,bal_leave.vacation_leave,bal_leave.causaul_leave,bal_leave.full_causaul_leave,bal_leave.half_causaul_leave,bal_leave.sick_leave,bal_leave.annual_leave,bal_leave.unpaid_leave,bal_leave.maternity_leave,bal_leave.public_holiday,bal_leave.removed_on FROM apply_leave
		 LEFT JOIN bal_leave ON bal_leave.user_id=apply_leave.user_id
		 WHERE apply_leave.id=? AND apply_leave.user_id=? and apply_leave.removed_on is null";
		$result=$con->prepare($query);
		$result->bind_param('ii',$details['apply_id'],$details['user_id']);
		$result->execute();
		$get=$result->get_result();

		while($row=$get->fetch_assoc())
		{
							$date1=date_create($row['frm_date']);
							$dates1=date_format($date1,"j-n-Y");

							$date2=date_create($row['to_date']);
							$dates2=date_format($date2,"j-n-Y");

							$query2="SELECT type FROM cal WHERE name=? AND dates=? and removed_on is null";
							$result2=$con->prepare($query2);
							$result2->bind_param('ss',$row['name'],$dates1);
							$result2->execute();
							$get2=$result2->get_result();
							$row2=$get2->fetch_assoc();
							$row['from_type']=$row2['type'];



							$query3="SELECT type FROM cal WHERE name=? AND dates=? and removed_on is null";
							$result3=$con->prepare($query3);
							$result3->bind_param('ss',$row['name'],$dates2);
							$result3->execute();
							$get3=$result3->get_result();
							$row3=$get3->fetch_assoc();
							$row['to_type']=$row3['type'];



							$obj=new api();
							$row['days_count']=$obj->edit_box_count($dates1,$dates2);
							$array[]=$row;
			}


			// echo "<pre>";
			// print_r($array);

					$obj=new api();
					$obj->pop_up_user($array);

}



public static function pop_up_user($array)
{
// 	echo "<pre>";
// print_r($array);
	$data='';
	foreach ($array as $key => $value)
	{
		$data.='<div class="notes-content-edit1 active">
            <div class="notes-main-edit1">
                <h3>Edit User Leave</h3>
                <button class="close-edit-user"><i class="fas fa-times"></i></button>
            </div>
            <div class="notes-text-edit1">
                <form>
                    <input name="edit-user-id" type="hidden" value='.$value['user_id'].'  data-full_causaul_leave='.$value['full_causaul_leave'].' data-half_causaul_leave='.$value['half_causaul_leave'].' data-vacation='.$value['vacation_leave'].' data-sick='.$value['sick_leave'].' data-public='.$value['unpaid_leave'].'>
                    <input name="edit-user-apply-id" type="hidden" value='.$value['id'].'>
                    <label>Leave Type*</label>
                    <select id="leave_select_edit_user" name="leave_select_edit_user">
                        <option value="0">'.$value['leave_type'].'</option>
                        <option value="2">Casual Leave</option>
                        <option value="3">Sick Leave</option>
                        <option value="4">Unpaid Leave</option>
                         <option value="5">Vacation Leave</option>
                         <option value="6">Maternity Leave</option>
                    </select><br>
                    <label>From Date*</label>
                    <input type="text" id="date1-edit-user" name="date1-edit-user" value='.$value['frm_date'].'><br>';
	                 
	                 if($value['leave_type']=="Casual Leave")
	                 {
	                  $data.='<label>Select type</label><br>
	                    <select name="fromHalf" id="fromHalf_user_edit">';
	                    if($value['from_type']==2)
	                    {
	                    	$data.='<option value="'.$value['from_type'].'">1st Half</option>';
	                    }
	                    elseif($value['from_type']==3)
	                    {
	                     	$data.='<option value="'.$value['from_type'].'">2nd Half</option>';
	                    }
	                    else
	                    {
	                     	$data.='<option value="1">Full Day</option>';
	                    }

			$data.='<option value="1">Full Day</option>
					<option value="2">1st Half</option>
					<option value="3">2nd Half</option>
					</select><br><br>';
				}

                    $data.='<label>To Date*</label>
                    <input type="text" id="date2-edit-user" name="date2-edit-user" value='.$value['to_date'].'><br>';

                     if($value['leave_type']=="Casual Leave")
	                 {
                    if($value['days_count']>1)
                    {
			                $data.='<label class="toHalf_user_edit" style="display:block;">Select type</label><br>
								<select name="toHalf" id="toHalf_user_edit" class="toHalf_user_edit" style="display:block;"><br>';
								 if($value['to_type']==2)
			                    {
			                    	$data.='<option value="'.$value['to_type'].'">1st Half</option>';
			                    }
			                    elseif($value['to_type']==3)
			                    {
			                     	$data.='<option value="'.$value['to_type'].'">2nd Half</option>';
			                    }
			                    else
			                    {
			                     	$data.='<option value="1">Full Day</option>';
			                    }
			              $data.='<option value="1">Full Day</option>
					             <option value="2">1st Half</option>
			        		     <option value="3">2nd Half</option>
			          			  </select><br><br>';
                    }
                    else
                    {
                    	    $data.='<label class="toHalf_user_edit" style="display:none;">Select type</label><br>
								<select name="toHalf" id="toHalf_user_edit" class="toHalf_user_edit" style="display:none;"><br>';
								 if($value['to_type']==2)
			                    {
			                    	$data.='<option value="'.$value['to_type'].'">1st Half</option>';
			                    }
			                    elseif($value['to_type']==3)
			                    {
			                     	$data.='<option value="'.$value['to_type'].'">2nd Half</option>';
			                    }
			                    else
			                    {
			                     	$data.='<option value="1">Full Day</option>';
			                    }
			              $data.='<option value="1">Full Day</option>
					             <option value="2">1st Half</option>
			        		     <option value="3">2nd Half</option>
			          			  </select><br><br>';
                    }
}
          		$data.='<label>Leave Count</label>
                    <input type="text" id="leave_count_edit_user" name="leave_count_edit_user" data-final='.$value['days_count'].' value='.$value['count'].' readonly><br>
                    <label>Reason</label>
      				<textarea name="reason-edit-user" id="reason-edit-user" style="resize: none;">'.$value['reason'].'</textarea><br>
                </form>
            </div>
            <div class="edit-btn">
                <button class="edit edit-user">Submit</button>
            </div>
        </div>';
	}
	echo  $data;
}


public static function edit($details)
{
	// echo "//<pre>";
	// print_r($details);
	global $con;
					$query="SELECT * FROM apply_leave WHERE id=? and removed_on is null";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['applyID']);
					$result->execute();
					$get=$result->get_result();
					$array=[];
					while($row=$get->fetch_assoc())
					{

						$date1=date_create($row['frm_date']);
			 $dates1=date_format($date1,"j-n-Y");

			$date2=date_create($row['to_date']);
			 $dates2=date_format($date2,"j-n-Y");

								$query2="SELECT type FROM cal WHERE name=? AND dates=?  and removed_on is null";
								$result2=$con->prepare($query2);
								$result2->bind_param('ss',$row['name'],$dates1);
								$result2->execute();
								$get2=$result2->get_result();
								$row2=$get2->fetch_assoc();
								$row['from_type']=$row2['type'];


								$query3="SELECT type FROM cal WHERE name=? AND dates=?  and removed_on is null";
								$result3=$con->prepare($query3);
								$result3->bind_param('ss',$row['name'],$dates2);
								$result3->execute();
								$get3=$result3->get_result();
								$row3=$get3->fetch_assoc();
								$row['to_type']=$row3['type'];

						$array[]=$row;
					}
					//prin_r($array);
						$result->execute();
						$result->close();

				foreach ($array as $key => $value)
				 {
					if($value['leave_type']==$details['leaveType'] && $value['frm_date']==$details['fromDateEditUser'] && $value['to_date']==$details['toDateEditUser'] && $value['reason']==$details['reasonEditUser'] && $value['from_type']==$details['fromType'] && $value['to_type']==$details['toType'])
					{
						//echo "this";
						return false;

					}
					else
					{
		   					$obj=new api();
					 		//$obj->edit_bal_add($array);
 					 		$obj->edit_update($details);
					}
 				 }
}

public static function edit_update($details)
{

					global $con;
						$obj=new api();
					 	$days=$details['leaveCount'];
						$remain_bal=$obj->bal_leave($details,$days);

						if($remain_bal==true)
						{
									$obj=new api();
									$obj->update_cal($details);			 																																
									//$result->close();
									////prin_r($details);
									$query="UPDATE apply_leave SET leave_type=?,frm_date=?,to_date=?,count=?,full_causaul_leave=?,half_causaul_leave=?,reason=?,created_on=CURRENT_TIMESTAMP WHERE id=?";
									$result=$con->prepare($query);
									$result->bind_param('ssssssss',$details['leaveType'],$details['fromDateEditUser'],$details['toDateEditUser'],$details['leaveCount'],$details['full_causaul_leave'],$details['half_causaul_leave'],$details['reasonEditUser'],$details['applyID']);
									 if($result->execute())
									 {
									 	echo "updated";
									 }
						}
						else
						{	
						echo "you dont have remaining leaves";
						}
}

public static function update_cal($details)
{
					global $con;
					$query="SELECT * FROM apply_leave WHERE id=? and removed_on is null";
					$result=$con->prepare($query);
					$result->bind_param('i',$details['applyID']);
					$result->execute();
					$get=$result->get_result();
					$array=[];
					while($row=$get->fetch_assoc())
					{
					$array[]=$row;
					}
					//				//prin_r($array);

					foreach ($array as $key => $value)
					{
					// //prin_r($value);
					// echo $value['frm_date'];
					// to_date

									/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									$begin = new DateTime($value['frm_date']);
									$end = new DateTime($value['to_date']);
									$end = $end->modify( '+1 day' );

									$interval = new DateInterval('P1D');
									$daterange = new DatePeriod($begin, $interval ,$end);
									$t=[];
									foreach($daterange as $date)
									{
									$t[]=$date->format("j-n-Y");
									}
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									$array[$key]['range']=$t;
					}

					////prin_r($array);
					foreach ($array as $key => $value) {
					//		echo $value['name'];
						foreach ($value as $key2 => $value2)
						{
								if($key2=="range")
								{
										foreach ($value2 as $key3 => $value3)
										 {
															$query="DELETE FROM cal WHERE name=? AND dates=?";
															$result=$con->prepare($query);
															$result->bind_param('ss',$value['name'],$value3);
															if($result->execute())
															{
															echo "cal deleeted";
															}
										}
								}
						}

					}
					// //prin_r($array);
					////prin_r($details);
						//////////////////////////////////////////insert////////////////////////////////////////////////////////////
					foreach ($details as $key => $value)
					{

					// //prin_r($value);
					// echo $value['frm_date'];
					// to_date

									/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									$begin = new DateTime($details['fromDateEditUser']);
									$end = new DateTime($details['toDateEditUser']);
									$end = $end->modify( '+1 day' );

									$interval = new DateInterval('P1D');
									$daterange = new DatePeriod($begin, $interval ,$end);
									$t=[];
									foreach($daterange as $date)
									{
									$t[]=$date->format("j-n-Y");
									}
									///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
									$details['range']=$t;
					}
					//	//prin_r($details);
					foreach ($details as $key => $value) {
					//	echo $array[0]['name'];
							$tooltip="Holiday pending for ".$array[0]['name'];
							$status="Pending";
					if($key=="range")
					{

						 $fromDate = date("j-n-Y", strtotime($details['fromDateEditUser']));
					 $toDate = date("j-n-Y", strtotime($details['toDateEditUser']));

					foreach ($value as $key2 => $value2) {
					//echo count($value);
					//								if($fromDate==$toDate)
								if($fromDate == $value2)

							{
											$query="INSERT INTO cal(name,tooltip,dates,status,type)VALUES(?,?,?,?,?)";
						 					$result=$con->prepare($query);
						 					$result->bind_param('sssss',$array[0]['name'],$tooltip,$value2,$status,$details['fromType']);
						 					if(!$result->execute())
						 					{
					//			 						echo "error";
						 						return false;
						 					}
							}
							//elseif(count($value)==2)
							elseif($toDate == $value2)
							{
										$query="INSERT INTO cal(name,tooltip,dates,status,type)VALUES(?,?,?,?,?)";
						 					$result=$con->prepare($query);
						 					$result->bind_param('sssss',$array[0]['name'],$tooltip,$value2,$status,$details['toType']);
						 					if(!$result->execute())
						 					{
					//			 						echo "error";
						 						return false;
						 					}
							}
							else{
								$type='1';
							$query="INSERT INTO cal(name,tooltip,dates,status,type)VALUES(?,?,?,?,?)";
								$result=$con->prepare($query);
								$result->bind_param('sssss',$array[0]['name'],$tooltip,$value2,$status,$type);
								if(!$result->execute())
								{
					//					echo "error";
									return false;
								}
						}
					}


					}

					}


}

public static function list_year()
{
	$years = range(date('Y'), 2009);
	return $years;
}


//......................................................................
// LEAVE CALCULATION - START
//......................................................................
public static function bal_count($id)
{
	global $con;
	$query="SELECT * FROM  bal_leave
	 WHERE
	 user_id=? and
	  removed_on is null";
		$result=$con->prepare($query);
		$result->bind_param('i',$id);
		$result->execute();
		$get=$result->get_result();

		while($row=$get->fetch_assoc())
		{
			$obj=new api();
							if($obj->holiday_list()!="null")
							{
							$pub_count=count(json_decode($obj->holiday_list(),true));
							$row['public_holiday']=$pub_count;			
							}
							else
							{
							$row['public_holiday']="0";				
							}

		$array[]=$row;
		}


		$jsondata=json_encode($array,true);
		return $jsondata;




}


}

$obj=new api();
 // $_GET['api']='team_list';

   // $_POST["leaveType"] = "Vacation Leave";
   // $_POST ["fromDate"] = "06/27/2022";
   //  $_POST["toDate"] = "06/27/2022";
   //  $_POST["leaveCount"] = 1;
   //  $_POST["fromType"] = 1;
   //  $_POST["toType"] = 1;
   //  $_POST["reason"] = "S";
   //  $_POST["photo"] = "undefined";
   //  $_POST["full_causaul_leave"] = 1;
   //  $_POST["half_causaul_leave"] = 0;
   //  $_POST["user_id"] = 3;




 //  $_POST['name']='david m';
 // $stime='05/03/2022';
 // $etime='05/08/2022';
 //$_POST['user_id'] = '3';
//    $_POST['apply_id'] = '1';
//     $_POST['leaveType'] = 'Sick Leave';
//     $_POST['fromDateEditUser'] = '04/25/2022';
//     $_POST['toDateEditUser'] = '04/27/2022';
//     $_POST['count'] = '2';
//   $_POST['reasonEditUser'] = 'sick';
     // ss
   // $_POST ["leaveType"] = "Casual Leave";
   //  $_POST["fromDate"] = "06/13/2022";
   //  $_POST["toDate"] = "06/17/2022";
   //  $_POST["leaveCount"] = "4";
   //  $_POST["fromType"] = "1";
   //  $_POST["toType"] = "1";
   //  $_POST["user_id"] = "3";



    // [apply_id] => 6
    // [login_id] => 1
    // [user_id] => 3
    // [type] => Casual Leave
    // [count] => 1
    // [funct_status] => approved
    // [post_status] => approved
    //  [fromType] => 0
    //  [toType] => 2

			if(!empty($_GET['api']))
	{
				if($_GET['api']=='apply_leave')
				{
					if(!isset($_FILES['photo']))
					{
						$obj->apply_leave($_POST,$_FILES['photo']='');
					}
					else
					{
					$obj->apply_leave($_POST,$_FILES['photo']);
					}
				}
				elseif($_GET['api']=='send_mail')
				{
				$obj->send_mail($_POST,$id);
				}
				elseif($_GET['api']=='count_days')
				{
				$obj->count_days($_POST);
				}
				elseif($_GET['api']=='insert_holiday')
				{
				$obj->insert_holiday($_POST);
				}
				// elseif($_GET['api']=='bal_leave')
				// {
				// $obj->bal_leave($_POST,2);
				// }
				elseif($_GET['api']=='holiday_list')
				{
			echo 	$obj->holiday_list();
				}
				elseif($_GET['api']=='insert_Workinglist')
				{
				$obj->insert_Workinglist($_POST);
				}
				elseif($_GET['api']=='working_list')
				{
				$obj->working_list();
				}
				elseif($_GET['api']=='user_lv_history')
				{
			echo 	$obj->user_lv_history($_POST['user_id']);
				}
				elseif($_GET['api']=='admin_lv_history')
				{
				$obj->admin_lv_history();
				}
				elseif($_GET['api']=='del_user')
				{
				$obj->del_user($_POST);
				}
				elseif($_GET['api']=='del_admin')
				{
				$obj->del_admin($_POST);
				}
				elseif($_GET['api']=='FuncMgr_status')
				{
				$obj->FuncMgr_status($_POST);
				}
				elseif($_GET['api']=='FuncMgr_status_denied')
				{
				$obj->FuncMgr_status_denied($_POST);
				}

				elseif($_GET['api']=='postMgr_status')
				{
				$obj->postMgr_status($_POST);
				}
				elseif($_GET['api']=='bal_count')
				{
			echo 	$obj->bal_count($_POST['user_id']);
				}
				elseif($_GET['api']=='loctn_list')
				{
				$obj->loctn_list();
				}
				elseif($_GET['api']=='yr_list')
				{
				$obj->yr_list();
				}
				elseif($_GET['api']=='approved_status')
				{
				$obj->approved_status($_POST);
				}
				elseif($_GET['api']=='denied_status')
				{
				$obj->denied_status($_POST);
				}
				elseif($_GET['api']=='get_postn_denied_status')
				{
				$obj->get_postn_denied_status($_POST);
				}

				elseif($_GET['api']=='get_Funtn_denied_status')
				{
				$obj->get_Funtn_denied_status($_POST);
				}
				elseif($_GET['api']=='bal_add')
				{
				$obj->bal_add($_POST);
				}
				elseif($_GET['api']=='edit')
				{
				$obj->edit($_POST);
				}
				elseif($_GET['api']=='edit_box')
				{
				$obj->edit_box($_POST);
				}
				elseif($_GET['api']=='datepickr_approved')
				{
				$obj->datepickr_approved();
				}
				elseif($_GET['api']=='datepicker_working_list')
				{
				$obj->datepicker_working_list();
				}
				elseif($_GET['api']=='only_sat_sun')
				{
				$obj->only_sat_sun();
				}
				elseif($_GET['api']=='date_picker_holiday_list')
				{
				$obj->date_picker_holiday_list();
				}
				elseif($_GET['api']=='sat_sun')
				{
				$obj->sat_sun();
				}
				elseif($_GET['api']=='send_mail2')
				{
				$obj->send_mail2($_POST);
				}
				elseif($_GET['api']=='all_week')
				{
				$obj->all_week();
				}
				elseif($_GET['api']=='get_data')
				{
				echo $obj->get_data();
				}
				elseif($_GET['api']=='Orview_date_range')
				{
				$obj->Orview_date_range();
				}
				elseif($_GET['api']=='Orview_table')
				{
				$obj->Orview_table();
				}
				elseif($_GET['api']=='del_holiday')
				{
			echo 	$obj->del_holiday($_POST);
				}
				elseif($_GET['api']=='del_working_list')
				{
			echo 	$obj->del_working_list($_POST);
				}
				elseif($_GET['api']=='team_list'){
					echo json_encode($obj->team_list());
				}
				// elseif($_GET['api']=='team_list'){

				// 	echo json_encode($obj->team_list());
				// }
			elseif($_GET['api']=='all_user_id'){
			echo 		$obj->all_user_id();
				}

			elseif($_GET['api']=='admin_select_his'){
			echo 		$obj->admin_select_his($_POST);
				}
				elseif($_GET['api']=='date_range_user_list'){
			echo 		$obj->date_range_user_list();
				}
				elseif($_GET['api']=='get_his_user_dates'){
			echo 		$obj->get_his_user_dates($_POST['user_id'],$_POST['stime'],$_POST['etime']);
				}
		elseif($_GET['api']=='edit_box_count'){
			echo 		$obj->edit_box_count($stime,$etime);
				}
elseif($_GET['api']=='list_year'){
					$obj->list_year();
				}
elseif($_GET['api']=='join_date_leave'){
					$obj->join_date_leave();
				}



	}



	


 ?>
