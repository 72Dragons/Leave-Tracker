<?php
//include 'login_db.php'; 
           session_start();          

if(isset($_SESSION['user_id']))
{
echo "";
}
else
{
header("Location:login.php");
exit();
}
?>

<div class="grid-history-table">
<div class="history-table">
<table>
<thead>
<tr class='table-head'>
<th>S.No.</th>
<th>Name</th>
<th>From</th>
<th>To</th>
<th>Count</th>
<th>Requested Date</th>
<th>Leave Type</th>
<th>Functional Manager Approval</th>
<th>Location Manager Approval</th>
<!--   <th>Status</th> -->
<!-- <th>Leave Count</th>
<th>Reason</th>
<th>Remarks</th>
<th>Functional Manager Approval</th>
<th>Location Manager Approval</th>
<th>Action Date</th> -->
<th></th>
<th></th>
</tr>
</thead>
<tbody class="admin-history-body" id="admin-history-body-table">
<?php
include "api.php";
$obj=new api();
$ee=$obj->admin_lv_history();
$c=json_decode($ee,true);
// echo "<pre>";
// print_r($c);
if(!empty($c))
{
            $count=1;
            foreach ($c as $key => $value)
            {
                    ?>
                                <tr class='table-data' data-id='<?php echo $value['id']; ?>'
                                data-user-id='<?php echo $value['user_id']; ?>' data-count='<?php echo  $value['count']; ?>' data-fromtype='<?php echo  $value['full_causaul_leave']; ?>' data-totype='<?php echo  $value['half_causaul_leave']; ?>'>
                                        <td class=customerIDCellt><?php echo $count; ?></td>
                                        <td class="emp-data"><?php echo  $value['name']; ?>&nbsp;<i class="fas fa-chevron-down"></i></td>
                                        <td class=customerIDCellt><?php echo  $value['from']; ?></td>
                                        <td class=customerIDCellt><?php echo  $value['to']; ?></td>
                                        <td><?php echo  $value['leave_count']; ?></td>
                                        <td class=customerIDCellt><?php echo  $value['Req_date']; ?></td>
                                        <td class='type'><?php echo  $value['leave_type']; ?></td>
                                        <td class='funct_status'><?php echo $value['funct_status']; ?></td>
                                        <td class='post_status'><?php echo $value['post_status']; ?></td>
                                        <td class=customerIDCellt>
                                                <?php if($value['funct_status']=='pending' && $value['post_status']=='pending') 
                                                {
                                                ?>
                                                            <i class="fa fa-pencil-alt admin-pencil"></i>
                                                <?php
                                                }
                                                else
                                                {
                                                        echo "";
                                                }
                                                ?>
                                        </td>
                                        <td class=customerIDCellt>
                                                <?php if($value['funct_status']=='pending' && $value['post_status']=='pending') 
                                                {
                                                ?>
                                                            <i class="fa fa-times admin-cross"></i>
                                                <?php
                                                }
                                                else
                                                {
                                                            echo "";
                                                }
                                                ?>

                                        </td>
                                </tr>

                                <tr class="more-info">
                                        <td colspan="14">
                                                    <div class="more-info-grid">
                                                            <div class="info-1">
                                                                    <p><?php echo  $value['name']; ?></p><br>
                                                                    <p>DOCTOR'S NOTE</p><br>
                                                                    <p class="note-img"><img src="<?php 
                                                                    if(isset($value['image'])){
                                                                    echo $value['image'];
                                                                    }
                                                                    else
                                                                    {
                                                                    echo "images/noimage.jpeg";
                                                                    }
                                                                    ?>" alt="small_img"></p>
                                                            </div>


                                                            <div class="info-2">
                                                                    <p><?php echo  $value['leave_type']; ?></p><br>

                                                                    <?php 
                                                                    $a2=date("d-M-Y");
                                                                    if(strtotime($a2)>strtotime($value['from'])) 
                                                                    {
                                                                    ?>
                                                                            <div class="leave-button" style="opacity:0.2;">
                                                                            <button>Approve</button>
                                                                            <button>Deny</button>
                                                                            <button>Cancel</button>
                                                                            </div>
                                                                    <?php 
                                                                    }
                                                                    else
                                                                    {
                                                                    ?>
                                                                            <div class="leave-button">
                                                                            <button name="approve" type="submit" class="approve">Approve</button>
                                                                            <button name="deny" type="submit" class="deny">Deny</button>
                                                                            <button name="cancel" type="submit" class="cancel">Cancel</button>
                                                                            </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                            </div>
                                                    </div>
                                        </td>
                                </tr>
                    <?php
                    $count++;
            }
}
else
{
?>
                        <tr>
                        <td class=customerIDCellt><span>No Leave History</span></td>
                        </tr>
<?php 
}

?>
</tbody>
</table>
</div>
</div>



<div class="grid-weekly-table" style="max-width: 100%;display: none;">
<div class="weekly-title">
<p>OVERVIEW : <span><?php 
echo $Orview_date_range=$obj->Orview_date_range();
?></span></p>
</div>

<div class="history-table">
<table class="table">
    <thead>
<tr class='table-head week-head'>
 <th>Mo</th>
                    <th>Tu</th>
                    <th>We</th>
                    <th>Th</th>
                    <th>Fr</th>
</tr> 
</thead>
 <tbody class="admin-history-body weekly-history-body">

<tr class='table-data week-data'>
                    <td>
<?php 
$array=$obj->Orview_table();
foreach ($array as $key => $value) {
if($key=='0')
    {
        if(!empty($value)){
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Pending')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:orange" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}
}
else
                                                {
                                                    ?>
                                                                            <div class="week-name">
                                                                            <p>No data</p><br><br>
                                                                            </div>
                                                    <?php   
                                                }
    }
}



foreach ($array as $key => $value) {
if($key=='0')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Approved')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:green" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}





foreach ($array as $key => $value) {
if($key=='0')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Denied')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:var(--dragon-red)" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

foreach ($array as $key => $value) {
if($key=='0')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='holiday')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}
?>



</td>


<!---->
                    <td>
<?php 

foreach ($array as $key => $value) {
if($key=='1')
    {
           if(!empty($value)){
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Pending')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:orange" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}
}
else
                                                {
                                                    ?>
                                                                            <div class="week-name">
                                                                            <p>No data</p><br><br>
                                                                            </div>
                                                    <?php   
                                                }

    }
}



foreach ($array as $key => $value) {
if($key=='1')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Approved')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:green" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}





foreach ($array as $key => $value) {
if($key=='1')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Denied')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:var(--dragon-red)" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

foreach ($array as $key => $value) {
if($key=='1')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='holiday')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}
?>
</td>


<!----->

<td>
<?php 

foreach ($array as $key => $value) {
if($key=='2')
    {
                   if(!empty($value)){
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Pending')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:orange" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}
}
else
                                                {
                                                    ?>
                                                                            <div class="week-name">
                                                                            <p>No data</p><br><br>
                                                                            </div>
                                                    <?php   
                                                }


    }
}



foreach ($array as $key => $value) {
if($key=='2')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Approved')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:green" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}





foreach ($array as $key => $value) {
if($key=='2')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Denied')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:var(--dragon-red)" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}


foreach ($array as $key => $value) {
if($key=='2')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='holiday')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

?>
</td>


<!----->
<td>
<?php 

foreach ($array as $key => $value) {
if($key=='3')
    {
//  print_r($value);
         if(!empty($value)){
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Pending')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:orange" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}
}
else
                                                {
                                                    ?>
                                                                            <div class="week-name">
                                                                            <p>No data</p><br><br>
                                                                            </div>
                                                    <?php   
                                                }

    }
}



foreach ($array as $key => $value) {
if($key=='3')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Approved')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:green" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}





foreach ($array as $key => $value) {
if($key=='3')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Denied')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:var(--dragon-red)" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

foreach ($array as $key => $value) {
if($key=='3')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='holiday')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

?>
</td>
<!----->
<td>
<?php 

foreach ($array as $key => $value) {
if($key=='4')
    {
                 if(!empty($value)){
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Pending')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:orange" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}
}
else
                                                {
                                                    ?>
                                                                            <div class="week-name">
                                                                            <p>No data</p><br><br>
                                                                            </div>
                                                    <?php   
                                                }

    }
}



foreach ($array as $key => $value) {
if($key=='4')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Approved')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:green" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}





foreach ($array as $key => $value) {
if($key=='4')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='Denied')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <div class="week-box" style="background:var(--dragon-red)" ;></div>
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

foreach ($array as $key => $value) {
if($key=='4')
    {
//  print_r($value);
            $w=[];
    foreach ($value as $key2 => $value2)
        {

//$b=[];
            foreach ($value2 as $key3 => $value3) 
            {
                if($key3=='status')
                {
                    if($value3=='holiday')
                    {
                        $w[]=$value2['name'];
                    }
                }
            }
        }
        foreach ($w as $key => $value) {
            if(!empty($value)){
?>          
                <div class="week-name">
                    <p><?php echo $value ?></p><br><br>
                </div>

 <?php
    }
}

    }
}

?>
</td>
 </tr>
   <!-- just for adding css -->
                <tr class='table-data week-data' data-id='' data-user-id=''>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                         <tr class='table-data week-data' data-id='' data-user-id=''>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class='table-data week-data' data-id='' data-user-id=''>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class='table-data week-data' data-id='' data-user-id=''>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr class='table-data week-data' data-id='' data-user-id=''>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- just for adding css -->



</tbody>
</table>
</div>
</div>
<!-- <script type="text/javascript">
    $(document).ready(function(){
              $('.grid-row-2').load('admin-calendar.php');
    });
</script> -->