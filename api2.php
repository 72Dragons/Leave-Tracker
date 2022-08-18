<?php 	
include "db.php";
include "db2.php";

class api2
{
	

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
					//	print_r($array);
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
								 $c['holiday_date']=date_format($date,"Y-m-j");
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

								
								$c[$key2]=$value2;
								//     	 print_r($c);
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
			//		print_r($array);

			//		print_r($array);
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




									$c[$key2]=$value2;
									//     	 print_r($c);
									//
									}
									$d[]=$c;
						}
					//	print_r($d);
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
				//print_r($t);
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
				//print_r($d);
				// $jsondata=json_encode($d,true);
				// return $jsondata;


				$obj=new api2();
				$workingdata=json_decode($obj->datepicker_working_list(),true);
				//print_r($workingdata);
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
				//print_r($c);


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
				//print_r($d2);
				$m=[];
				foreach ($d2 as $key => $value) {
				if($key=="sun")
				{
				foreach ($value as $key2 => $value2) {
				$value22=date_create($value2);
				$m[]=date_format($value22,'j-m-Y');
				}
				}
				}

				//print_r($m);

				$jsondata=json_encode($m,true);
				return $jsondata;
				//echo $jsondata;

				}
				else
				{
				$jsondata=json_encode($d,true);
				return      $jsondata;
				//	echo $jsondata;
				}
}	





public static function sat_sun()
{
// $date = '2020-01-01';
// $end = '2020-12-' . date('t', strtotime($date)); //get end date of month

$date = date('Y').'-01-01';
$end = date('Y').'-12-' . date('t', strtotime($date)); //get end date of month
//echo date('Y');
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
//print_r($t);
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
//print_r($d);


		$obj=new api2();
		 $workingdata=json_decode($obj->datepicker_working_list(),true);
		//print_r($workingdata);
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
//print_r($c);


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
										//print_r($d);
	$jsondata=json_encode($d2,true);
				return $jsondata;
	
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
			$date = date('Y').'-01-01';
			$end = '2050-12-' . date('t', strtotime($date)); //get end date of month

			// echo '<table border="1">';

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
//print_r($t);
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

//print_r($s);


foreach ($s as $key => $value)
{

$words=['-Monday','-Tuesday','-Wednesday','-Thursday','-Friday'];
$d['all'][]=str_replace($words,"",$value);
}

//print_r($d);	
$jsondata=json_encode($d,true);
return      $jsondata;
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


public static function all_attdce()
{
//	echo "<pre>";
	global $con;
session_start();
// print_r($_SESSION);
$array=[];
	$obj=new api2();
$data=[date("d-n-Y")];
//['19-4-2022'];
//print_r($data);
	$query=db2::$con->query("SELECT 72daccounts.memberID,72daccounts.name FROM admin_user_list
						LEFT JOIN 72daccounts ON 72daccounts.memberID = admin_user_list.user_id
						 WHERE admin_user_list.admin_id ='".$_SESSION['user_id']."'");
	

	while($row=$query->fetch_assoc())
	{
		$array[]=$row;
	}

// print_r($array);
	foreach ($data as $key => $value) {
		$data[$key]=[$value];
		$data[$key][]=$array;

		foreach ($data[$key][1] as $key2 => $value2) {
	//	echo $data[$key][1][$key2]['memberID'];
		 $query2=db2::$con->query("SELECT name,dates,status FROM cal WHERE name='".$data[$key][1][$key2]['name']."' AND dates='".$data[$key][0]."'");
		 while($row2=$query2->fetch_assoc())
		 {


			 if(!empty($row2['name'] && !empty($row2['dates']) && $row2['status']=='Approved'))
			 {
					unset($data[$key][1][$key2]); 
			 }						 	
		 }

		}

	}
			$jsondata=json_encode($data,true);
		echo  $jsondata;
}



}

$obj=new api2();
// $_GET['api']='sat_sun';
// $_POST['fromDate']='2022-04-01';
// $_POST['toDate']='2022-04-30';
// $_POST['user_id']='1';
// $_POST['name_id']='';

			if(!empty($_GET['api']))
			{

				if($_GET['api']=='date_picker_holiday_list')
				{
				echo $obj->date_picker_holiday_list();
				}
				elseif($_GET['api']=='datepicker_working_list')
				{
				echo $obj->datepicker_working_list();
				}
				elseif($_GET['api']=='sat_sun')
				{
				echo $obj->sat_sun();
				}
				elseif($_GET['api']=='all_week')
				{
				echo $obj->all_week();
				}
				elseif($_GET['api']=='only_sat_sun')
				{
				echo $obj->only_sat_sun();
				}
				elseif($_GET['api']=='all_attdce')
				{
				//$obj->all_attdce($_POST);
					$obj->all_attdce();
				}

				
			}

			



 ?>