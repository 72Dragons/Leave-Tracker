<?php
include "api.php";
 ?>
<!-- <head>
      <link rel="stylesheet" href="css/main.css">
</head> -->
<div class="admin-section">
    <!-- holiday popup -->


    <div class="notes-overlay">
        <div class="notes-content">
            <div class="notes-main">
                <h3>Add Holiday</h3>
                <button class="close"><i class="fas fa-times"></i></button>
            </div>
            <div class="notes-text">
                <input class="hid" type="hidden">
                <label>Day</label>
                <input type="text" name="day">
                <label>Date</label>
                <input type="text" id="date3" name="date3"/>
                <label>Holiday</label>
                <input type="text" name="holiday">
            </div>
            <div class="edit-btn">
                <button class="edit submit-holiday">Submit</button>
            </div>
        </div>
    </div>





    <!-- working day popup -->
    <div class="notes1-overlay">
        <div class="notes1-content">
            <div class="notes1-main">
                <h3>Add Working Day</h3>
                <button class="close1"><i class="fas fa-times"></i></button>
            </div>
            <div class="notes1-text">
                <input class="hid" type="hidden">
                <label>Day</label>
                <input type="text" name="day1">
                <label>Date</label>
                <input type="text" id="date4" name="date4" />
                <label>Working Day</label>
                <input type="text" name="working">
            </div>
            <div class="edit-btn">
                <button class="edit submit-working">Submit</button>
            </div>
        </div>
    </div>

    <h4>Holiday List</h4>
    <div class="holiday-table">
        <table>
            <thead>
                <tr class='table-head'>
                <th>S.No.</th>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Holiday</th>
                    <th></th>
                 </tr>
            </thead>
            <tbody class="holiday-table-body">


                               <?php
                     //$obj=new api();
                $data=json_decode($obj::holiday_list(),true);

                if($data)
                {
                 //   echo "yes";
                                                      $count=1;
                                    foreach ($data as $key => $value) {

                                    ?>
                                        <tr class='table-data'>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $value['day']; ?></td>
                                        <td class="holidayDate"><?php echo $value['2nd_up_date']; ?></td>
                                        <td class="holidayName"><?php echo $value['holiday']; ?></td>
                                        <td class="holidayCross" data-id="<?php echo $value['id'];  ?>" style="cursor:pointer"><i class="fas fa-times-circle"></i></td>
                                        </tr>

                                     <?php
                                    $count++;
                                    }
                }
                else
                {
                    ?>
                    <tr class='table-data'>
                               <td><?php   echo "No holiday list"; ?></td>
                                    </tr>
                                    <?php
                }


               ?>




            </tbody>
        </table>
    </div>
    <div class="add-new-hol">
        <p class="add-holiday"><i class="fas fa-plus-circle"></i>Add New Holiday</p>
    </div>

    <h4>Working Day List</h4>

    <div class="working-day-table">
        <table>
            <thead>
                <tr class='table-head'>
                    <th>S.No.</th>
                    <th>Day</th>
                    <th>Date</th>
                    <th>Working Day</th>
                    <th></th>
                </tr>
            </thead>

            <tbody class="working-table-body">

                               <?php
//                $obj=new api();
                $data2=json_decode($obj::working_list(),true);
              //  print_r($data2);
                if($data2)
                {
                 //   echo "yes";
                                                      $count=1;
                                    foreach ($data2 as $key => $value) {

                                    ?>
                                        <tr class='table-data'>
                                        <td><?php echo $count; ?></td>
                                        <td><?php echo $value['day']; ?></td>
                                        <td class="WorkingDate"><?php echo $value['2nd_up_date']; ?></td>
                                        <td class="WorkingName"><?php echo $value['holiday']; ?></td>
                                        <td class="WorkingCross" data-id="<?php echo $value['id'];  ?>" style="cursor:pointer"><i class="fas fa-times-circle"></i></td>
                                        </tr>

                                     <?php
                                    $count++;
                                    }
                }
                else
                {
                    ?>
                    <tr class='table-data'>
                               <td><?php   echo "No Working List"; ?></td>
                                    </tr>
                                    <?php
                }


               ?>


            </tbody>
        </table>
    </div>
    <div class="add-new-work">
        <p class="add-working"><i class="fas fa-plus-circle"></i>Add New Working Day</p>
    </div>
</div>

<script>
    $(document).ready(function () {
        if($('#ui-datepicker-div')){
            $('#ui-datepicker-div').remove();
            $("#date3").removeClass("hasDatepicker");
            $("#date4").removeClass("hasDatepicker");
        }
        $("#date3").datepicker();
        $("#date4").datepicker();


        // Delete holiday
        $(".holidayCross").on('click',function(){
            alert("click");
            var holidayId = $(this).attr('data-id');
            var holidayDate = $(this).parent().find('.holidayDate').text();
            var holidayName = $(this).parent().find('.holidayName').text();
            $.ajax({
                type: "POST",
                url: "api.php?api=del_holiday",
                data:{
                    holiday_id: holidayId,
                    holiday_date: holidayDate,
                    holiday_name: holidayName,
                },
                success: function (data) {
                    console.log(data);
                    if(data)
                    {
                        alert('Deleted successfully');
                        $('.admin-title').click();
                    }
                    else
                    {
                        alert("An error has occcured while deleting holiday.");
                    }
                    },
                error: function (data) {
                    alert("An error has occcured while deleting holiday. Please try again");
                    }

                });

                                // $(".holiday-table-body").load("admin-section.php" +
                                //                 " .holiday-table-body");
                                //             $('.grid-row-1').load('admin-leave-history.php');
                                //             $('.grid-row-2').load('user-calendar.php');
        });




         // Delete Working
        $(".WorkingCross").on('click',function(){

            var WorkingId = $(this).attr('data-id');
            var WorkingDate = $(this).parent().find('.WorkingDate').text();
            var WorkingName = $(this).parent().find('.WorkingName').text();
            $.ajax({
                type: "POST",
                url: "api.php?api=del_working_list",
                data:{
                    Working_id: WorkingId,
                    Working_date: WorkingDate,
                    Working_name: WorkingName,
                },
                success: function (data) {
                    console.log(data);
                    if(data)
                    {
                        alert('Deleted successfully');
                        $('.admin-title').click();
                    }
                    else
                    {
                        alert("An error has occcured while deleting Working Day.");
                    }
                    },
                error: function (data) {
                    alert("An error has occcured while deleting Working Day. Please try again");
                    }
                });

        });


//Highlight upcoming time off for admin
            $('.holidayDate').each(function(){
              let dateValue = $(this).text();
              const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

                const d = new Date();
                let monthValue = monthNames[d.getMonth()];

                if(dateValue.indexOf(monthValue) != -1){
                    $(this).parent().css('background','#800000');
                }
            });







    });
</script>