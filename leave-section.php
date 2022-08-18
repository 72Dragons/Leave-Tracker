<?php 
if(isset($_SESSION['user_id']))
{
    $user_id= $_SESSION['user_id'];
}
// else
// {
//    header("Location:login.php");
//     exit();
// }


 ?>
<div class="balance-section">
    <h4>Balance</h4>
    <div class="bal-sub-section">
        <div class="bal-sub-col-1">
            <p>Leave Type</p><br>
            <p>Vacation Leave</p><br>
            <p>Casual Leave</p><br>
            <p>Sick Leave</p><br>
            <p>Maternity Leave</p><br>
            <p>Public Holiday</p><br>
            <p>Unpaid Leave</p><br>
          
        </div>
        <div class="bal-sub-col-2">
            <p>Awaited</p><br>

<?php 
      //  include "api.php";
        $obj=new api();
//        $data=$obj::bal_count('1');
        if(!empty($user_id))
        {
            
        $data=$obj->bal_count($user_id);
        $array=json_decode($data,true);

//        print_r($array);

foreach ($array as $key => $value) {
         ?> 
            <p class="leave_1"><?php echo $value['vacation_leave']; ?></p><br>
            <p class="leave_2"><?php echo $value['causaul_leave']." = full day(".$value['full_causaul_leave'].") + half day(".$value['half_causaul_leave'].")" ?></p><br>
            <p class="leave_3"><?php echo $value['sick_leave']; ?></p><br>
            <p class="leave_4"><?php echo $value['maternity_leave']; ?></p><br>
            <p class="leave_6"><?php echo $value['public_holiday']; ?></p><br>  
            <p class="leave_5"><?php echo $value['unpaid_leave']; ?></p><br>
<?php
        
}
}
            ?>

       </div>
    </div>
</div>

<div class="apply-leave-section">
    <h4>Apply For Leave</h4>
    <form class="form" id="formid">
        <label>Leave Type*</label>
        <select id="leave_select" name="leave_select">
            <option value="0">Select leave type</option>
            <option value="1">Vacation Leave</option>
            <option value="2">Casual Leave</option>
            <option value="3">Sick Leave</option>
            <option value="4">Maternity Leave</option>
            <option value="5">Unpaid Leave</option>
           </select><br>
        <label>From Date*</label>
        <input type="text" id="date1" name="date1" class="same" autocomplete="off" /><br>
        <!-- changes by Ashish -->
        <label class="four">Select type</label>
        <select name="fromHalf" id="fromHalf" class="four">
            <option value="1">Full Day</option>
            <option value="2">1st Half</option>
            <option value="3">2nd Half</option>
        </select><br>
        <!-- till this line -->
        <label>To Date*</label>
        <input type="text" id="date2" name="date2" class="same" autocomplete="off" /><br>
        <!-- changes by Ashish -->
        <label class="toHalf four" >Select type</label>
        <select name="toHalf" id="toHalf" class="toHalf four">
            <option value="1">Full Day</option>
            <option value="2">1st Half</option>
            <option value="3">2nd Half</option>
        </select><br>
        <!-- till this line -->
        <label>Leave Count</label>
        <input type="text" id="leave_count" name="leave_count" readonly/><br>
        <label>Reason</label>
        <input type="text" id="reason" name="reason" /><br>
        <label class="doc_note">Upload Doctor's Note</label>
        <input type="file" id="myFile" name="filename" class="doc_note">
    </form>
    <div class="leave-button">
        <button name="reset" type="submit" id="reset">Reset</button>
        <button name="apply" type="submit" id="apply">Apply</button>
    </div>
</div>



<div class="upcoming-section">
    <h4>Upcoming Time Off</h4>
    <div class="upcoming-data-section">
                 <?php
                $data=json_decode($obj::holiday_list(),true);
                if($data)
                {
                
              $count=1;
                                foreach ($data as $key => $value) {
                                
                                ?> 
                                                <div class="up-item-card" style="padding: 11px;">
                                                    <div class="up-data">
                                                        <p><?php echo $value['holiday']; ?></p><br>
                                                        <p class="up-date"><?php echo $value['up_date']; ?></p>
                                                    </div>
                                                    <div class="up-status">
                                                        <p><?php echo $value['status']; ?></p>
                                                    </div>
                                                </div>
                                 <?php  
                                $count++;
                                }
                 }
                else
                {
                   ?>
                        <div class="up-item-card">
                           <p>No Upcomingtime Off</p>
                       </div>
                <?php 
                }


               ?> 
       
        
    </div>
</div>

<script>
    $(document).ready(function () {
        $(function () {
            $("#date1").datepicker();
        });
        $(function () {
            $("#date2").datepicker();
        });
    });






    ///////////////////////////////////////////////////
    
</script>