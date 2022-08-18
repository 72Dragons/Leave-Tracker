<?php
session_start();
include "db2.php";
class chk_stats
{

		public static function list()
		{
			//echo $_SESSION['user_id'];
			$data=db2::$con->query("SELECT DISTINCT CONCAT(firstName,' ',lastName) as name,memberID FROM  staffinfo ORDER BY firstName ASC;");
			$admin=1;
			while ($row=$data->fetch_assoc()) {
				
					$query=db2::$con->query("SELECT funcMgr_id FROM user_funcmgr WHERE funcMgr_id=".$_SESSION['user_id']." and user_id=".$row['memberID']);
					$res=$query->fetch_assoc();
					$row['funct_mgr']=$res;


					$query2=db2::$con->query("SELECT posiMgr_id FROM user_posimgr WHERE posiMgr_id=".$_SESSION['user_id']." and user_id=".$row['memberID']);
					$res2=$query2->fetch_assoc();
					$row['postn_mgr']=$res2;
					$row['both']=null;

					if($row['funct_mgr']!=null && $row['postn_mgr']!=null )
					{
						$row['funct_mgr']=null;
						$row['postn_mgr']=null;
						$row['both']=1;

					}
				$arr[]=$row;



			}
			// echo "<pre>";
			// print_r($arr);
		return json_encode($arr,true);

		}


		public static function set($details)
		{
			// echo "<pre>";
			// print_r($details);
			//echo $_SESSION['user_id'];
			$q1=db2::$con->query("DELETE FROM user_funcmgr WHERE funcMgr_id='".$_SESSION['user_id']."'");
			$q2=db2::$con->query("DELETE FROM user_posimgr WHERE posiMgr_id='".$_SESSION['user_id']."'");
			$q3=db2::$con->query("DELETE FROM admin_user_list WHERE admin_id='".$_SESSION['user_id']."'");
			// print_r(json_decode($details['data'],true));

			if(!empty($details))
			{
			foreach ($details as $key => $value) {
				foreach ($value as $key2 => $value2) {
					if((count($value2)==1 && $value2[0]==3) || count($value2)==2)
					{

						$qu1=db2::$con->query("SELECT * FROM user_funcmgr WHERE user_id='".$key2."'");
						$res=$qu1->num_rows;
						if($res<3)
						{
								$q1=db2::$con->query("DELETE FROM user_funcmgr WHERE funcMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
								$q2=db2::$con->query("DELETE FROM user_posimgr WHERE posiMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
							//	$q3=db2::$con->query("DELETE FROM admin_user_list WHERE admin_id='".$_SESSION['user_id']."' and user_id='".$key2."'");	
							     $query=db2::$con->query("INSERT INTO user_funcmgr(funcMgr_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");
		     					$query2=db2::$con->query("INSERT INTO user_posimgr(posiMgr_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");
		     					$query3=db2::$con->query("INSERT INTO admin_user_list(admin_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");		
     					}
     					else
     					{
     						return false;
     					}
					}
					elseif(count($value2)==1 && $value2[0]!=3 && $value2[0]==1)
					{	
						$qu1=db2::$con->query("SELECT * FROM user_funcmgr WHERE user_id='".$key2."'");
						$res=$qu1->num_rows;
						if($res<3)	
						{
								$q1=db2::$con->query("DELETE FROM user_funcmgr WHERE funcMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
								$q2=db2::$con->query("DELETE FROM user_posimgr WHERE posiMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
							//	$q3=db2::$con->query("DELETE FROM admin_user_list WHERE admin_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
								$query=db2::$con->query("INSERT INTO user_funcmgr(funcMgr_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");
								$query3=db2::$con->query("INSERT INTO admin_user_list(admin_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");
						}
						else
						{
							return false;
						}		
					
					}
					elseif(count($value2)==1 && $value2[0]!=3 && $value2[0]==2)
					{
						$qu1=db2::$con->query("SELECT * FROM user_posimgr WHERE user_id='".$key2."'");
						$res=$qu1->num_rows;
						if($res<3)
						{
								$q1=db2::$con->query("DELETE FROM user_funcmgr WHERE funcMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
								$q2=db2::$con->query("DELETE FROM user_posimgr WHERE posiMgr_id='".$_SESSION['user_id']."' and user_id='".$key2."'");	
								//$q3=db2::$con->query("DELETE FROM admin_user_list WHERE admin_id='".$_SESSION['user_id']."' and user_id='".$key2."'");
								$query2=db2::$con->query("INSERT INTO user_posimgr(posiMgr_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");
								$query3=db2::$con->query("INSERT INTO admin_user_list(admin_id,user_id)VALUES(".$_SESSION['user_id'].",".$key2.")");	
						}
						else
						{
							return false;
						}
					}
				}
			}
			return true;
		}
		}

}



$obj=new chk_stats();
//$_GET['api']="list";
// $_POST['setdata']=Array
// (
//     ["1"] => Array
//         (
//             ["3"] => Array
//                 (
//                     ["0"] => "3"
//                 )

//         )

//     ["7"] => Array
//         (
//             ["8"] => Array
//                 (
//                     ["0"] => "1",
//                     ["1"] => "2"
//                 )

//         )
 
// );
 //$_POST['fromDate']='2022-04-01';
// $_POST['toDate']='2022-04-30';
// $_POST['user_id']='1';
// $_POST['name_id']='';

			if(!empty($_GET['api']))
			{
				if($_GET['api']=='list')
				{
						echo chk_stats::list();
				}
				elseif($_GET['api']=='set')
				{	
					if(isset($_POST['setdata']) && !empty($_POST['setdata']))
					{
						echo "yes";
					 echo chk_stats::set($_POST['setdata']);
					}
					elseif(empty($_POST['setdata']))
					{
						echo "no";
										 echo chk_stats::set($_POST['setdata']="");	
					}

				}				
			}

			

