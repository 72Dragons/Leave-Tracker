<?php
include 'login_db.php';
include "api.php";

// echo "<pre>";
// print_r($_SESSION);

$date_picker_holiday_list=$obj->date_picker_holiday_list();
$datepicker_working_list=$obj->datepicker_working_list();

$only_sat_sun=$obj->only_sat_sun();
$sat_sun=$obj->sat_sun();

$employeeJoinDate = 'Not Set';
if(isset($_SESSION['user_id']))
{
    echo "";
    global $con;
	$sql = mysqli_fetch_row(mysqli_query($con,"SELECT joinDate FROM staffinfo WHERE memberID='".$_SESSION['user_id']."' LIMIT 1"));
	$employeeJoinDate = $sql[0];
}
else
{
   header("Location:login.php");
    exit();
}


 ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Leave Management Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"
        integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
  <!--   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script> -->
    <link rel="stylesheet" href="css/main.css">
</head>
<!--
<style>
  .newSel{
    background:yellow;
  }
</style> -->

<body>
    <!-- Navbar -->
    <?php include('nav.php'); ?>

    <!--  -->
    <input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['user_id']; ?>">

    <div class="show">
        <div class="overlay"></div>
        <div class="img-show">
            <span>X</span>
            <img src="">
        </div>
    </div>



    <!-- edit popup user section -->
    <div class="notes-overlay-edit1">


    </div>




    <!-- Main Section -->
      <div class="grid-container">
        <div class="grid-col-1">
            <h3 style="margin-bottom:30px;">Leave Management</h3>
            <div class="tab-switch">
                <span class="leave-title active ">Leave Management</span>
                <span  class ="join_span"> Joined:<span  class="joindate"><?php echo $employeeJoinDate; ?></span></span>
                <?php
                 $obj=new login();
                 $funct_stats=$obj->admin_func($_SESSION['user_id']);
                // $postn_stats=$obj->admin_postn($_SESSION['user_id']);
                     // echo "<script>alert(".$funct_stats.");</script>";
                     // echo "<script>alert(".$postn_stats.");</script>";
                     //
                if($funct_stats==true)
                {
                     ?>
                <span class="admin-title">Admin</span>
                <?php
                }
                elseif($funct_stats==false)
                {
                        echo "";
                }

                 ?>

            </div>
            <div class="leave_admin-section">
                <?php
                include('leave-section.php');
                 ?>
            </div>
        </div>
        <div class="grid-col-2">
            <h4>Leave History</h4>

<div class="selecter">
          <!-- changes made by shabnam -->
                  <div clas="newSelect" style="display:block; justify-content:center; text-align:center;font-size: 15px;">

                      <label for="Any" class="sel-drop" style="color:#ad9440; margin:0 5px 0 0;">Employee :</label>
                      <select name="Any" class="sel-drop" id="sel-name" style="color:#000000; background-color:#ad9440; border: 1px solid #ae943f; ">
                      </select>

                      <label id="startDate" for="startDate" style="color:#ad9440;">Start Date :</label>
                      <input type="date" id="start-Date">
                      <label id="endDate" for="endDate" style="color:#ad9440;">End Date :</label>
                      <input type="date" class="inp3" style="" id="end-Date">
                      <button id="selButton" type="submit" value="Submit">Submit</button>
              <button id="usrButton" type="submit" value="Submit">Submit</button>
                  </div>
          <!-- changes made by shabnam till here-->
      </div>


            <?php
                 $obj=new login();
                 $funct_stats=$obj->admin_func($_SESSION['user_id']);
                // $postn_stats=$obj->admin_postn($_SESSION['user_id']);
                     // echo "<script>alert(".$funct_stats.");</script>";
                     // echo "<script>alert(".$postn_stats.");</script>";
                     //
                if($funct_stats==true)
                {
                     ?>
            <div class="csv_buttons">
                <a href=""><button class="csv_data">All Data</button></a><br>
                <select id="csv_month_select" name="csv_month_select">
                    <option value="">Select Month</option>
                    <option value="0">All Months</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select id="csv_location_select" name="csv_location_select">
                    <option value="0">Select Location</option>
                    <option value="1">India</option>
                    <option value="2">China</option>
                    <option value="2">Hong Kong</option>
                    <option value="2">USA</option>
                </select>

                <select id="csv_year_select" name="csv_year_select">
                    <option value="0">Select Year</option>
                    <?php
                        $obj=new api();
                         $year_list=$obj->list_year();
                        foreach ($year_list as $key => $value) {
                       echo '<option value="'.$value.'">'.$value.'</option>';
                        }
                     ?>
                </select>

                <a href=""><button class="export_data">Export Data</button></a>
            </div>
            <?php
                }
                elseif($funct_stats==false && $postn_stats==false)
                {
                        echo "";
                }

                 ?>


            <!-- <select class="location">
              <option val="0">Select Country</option>
              <option>China</option>
              <option>India</option>
            </select>

            <select class="period">
              <option val="0">Select Period</option>
              <option value="All">All data</option>
              <option value="01">Jan</option>
              <option value="02">Feb</option>
              <option value="03">Mar</option>
              <option value="04">April</option>
              <option value="05">May</option>
              <option value="06">June</option>
              <option value="07">July</option>
              <option value="08">Aug</option>
              <option value="09">Sep</option>
              <option value="10">Oct</option>
              <option value="11">Nov</option>
              <option value="12">Dec</option>
            </select>

          <button class="export">Export as CSV</button>
          <br> -->
            <div class="toggle-btn">
                <!-- <i class="fas fa-toggle-off" title="Toggle Button"></i> -->
                <i class="fas fa-toggle-off" title="Toggle Button"></i>
            </div>
            <div class="grid-row-1">
                <?php
                 include('user-leave-history.php');
                  ?>
            </div>
            <div class="grid-row-2">
                <?php
              // include('user-calendar.php');
                ?>
            </div>
        </div>
        <!-- success message -->
        <div class="success-msg">
            <span class="successfully-saved"><i class="fa fa-thumbs-up"></i> Submitted!</span>
        </div>
        <div class="success-msg">
            <span class="successfully-edited"><i class="fa fa-thumbs-up"></i> Updated!</span>
        </div>
        <div class="success-msg">
            <span class="successfully-deleted"><i class="fa fa-thumbs-up"></i> Deleted!</span>
        </div>
        <!-- loader -->
        <div class="loader"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="js/main.js"></script>

    <script>
    // const mediaQuery = window.matchMedia("(max-width: 767px)");
    // let gridRow = document.querySelector(".grid-row-1");
    // if (mediaQuery.matches) {
    //     gridRow.style.display = "grid";
    //     let toggleBtnI = document.querySelector(".toggle-btn i");
    //     toggleBtnI.classList.add("fa-toggle-on");
    //     toggleBtnI.addEventListener("click", function() {
    //         let weekTable = document.querySelector(".grid-weekly-table");
    //         if (weekTable.style.display === "none") {
    //             weekTable.style.display = "block";
    //             toggleBtnI.classList.add("fa-toggle-on");
    //         } else {
    //             weekTable.style.display = "none";
    //             toggleBtnI.classList.remove("fa-toggle-on");
    //         }
    //     });
    // } else {
    //     let toggleBtnI = document.querySelector(".toggle-btn i");
    //     let gridRow = document.querySelector(".grid-row-1");
    //     gridRow.style.display = "flex";
    //     toggleBtnI.classList.add("fa-toggle-on");
    //     toggleBtnI.addEventListener("click", function() {
    //         let weekTable = document.querySelector(".grid-weekly-table");
    //         if (weekTable.style.display === "none") {
    //             weekTable.style.display = "block";
    //             toggleBtnI.classList.add("fa-toggle-on");
    //         } else {
    //             weekTable.style.display = "none";
    //             toggleBtnI.classList.remove("fa-toggle-on");
    //         }
    //     });
    // }


    const mediaQuery = window.matchMedia("(max-width: 767px)");
    let gridRow = document.querySelector(".grid-row-1");
    if (mediaQuery.matches)
    {
        gridRow.style.display = "grid";
        let toggleBtnI = document.querySelector(".toggle-btn i");
        toggleBtnI.classList.add("fa-toggle-on");
        toggleBtnI.addEventListener("click", function() {
            let weekTable = document.querySelector(".grid-weekly-table");
            if (weekTable.style.display === "none")
            {
                weekTable.style.display = "block";
                toggleBtnI.classList.add("fa-toggle-on");
            }
            else
            {
                weekTable.style.display = "none";
                toggleBtnI.classList.remove("fa-toggle-on");
            }
        });
    } 
    else 
    {
        let toggleBtnI = document.querySelector(".toggle-btn i");
        let gridRow = document.querySelector(".grid-row-1");
        gridRow.style.display = "flex";
        // toggleBtnI.classList.add("fa-toggle-on");
        toggleBtnI.addEventListener("click", function() {
            let weekTable = document.querySelector(".grid-weekly-table");
            if(weekTable.style.display === "block") 
            {
                weekTable.style.display = "none";
                toggleBtnI.classList.remove("fa-toggle-on");
                $(".grid-history-table").css('display','block'); 
            }
            else
            {
                weekTable.style.display = "block";
                toggleBtnI.classList.add("fa-toggle-on");
                $(".grid-history-table").css('display','none'); 
            }
        });
    }

    $(document).ready(function() {

        /// Toggle Weekly Section///
        // $('.toggle-btn button').on('click',function(){
        //   $('.grid-weekly-table').toggle();
        // });



        ///// CSV Data /////
        $('body').on('click', '.csv_data', function() {
            //  e.preventDefault();
            // var txt = $(this).text();
            var url = "all.php";
            $(this).parent().attr("href", url);
            //            //////console.log(txt);

        });



        ///// Export Data /////
        $('body').on('click', '.export_data', function() {
            // e.preventDefault();
            var csvMonth = $(this).closest('.csv_buttons').find('#csv_month_select');
            var txt = $(csvMonth).find('option:selected').val();
            var txt_val = $(csvMonth).find('option:selected').text();

            //////console.log(txt);


            var csvLocation = $(this).closest('.csv_buttons').find('#csv_location_select');
            var txt1 = $(csvLocation).find('option:selected').text();
            //////console.log(txt1);


             var csvYear = $(this).closest('.csv_buttons').find('#csv_year_select');
            var year = $(csvYear).find('option:selected').text();
            //////console.log(year);


            if ($("#csv_location_select option:selected").index() == 0) {
                alert('Please select location type');
                return false;
            }

            if ($("#csv_month_select option:selected").index() == 0) {
                alert('Please select Month');
                return false;
            }

if ($("#csv_year_select option:selected").index() == 0) {
                alert('Please select year');
                return false;
            }

            if ($("#csv_month_select option:selected").val() == 0) {
                // alert("hi");
                var url = "only_location.php?location=" + txt1 + "&year=" + year;
                //////console.log(url);
                $(this).parent().attr("href", url);
            } else {
                var url = "month_loctn.php?month=" + txt + "&location=" + txt1 + "&month_name=" + txt_val + "&year=" + year;
                    txt_val;
                //////console.log(url);
                $(this).parent().attr("href", url);

            }


        });


        //             $('body').on('click', '.export', function (e) {
        //                 e.preventDefault();

        //                   // $(".select_country").attr("disabled","disabled");

        //                 var country = $('.location').find(':selected').html();
        //                var period = $('.period').find(':selected').val();
        //                 alert(period);


        //                 if ($(".location option:selected").index() == 0)
        //                 {
        //                     alert('Please select location type');
        //                     return false;
        //                 }

        //                   if ($(".period option:selected").index() == 0)
        //                 {
        //                     alert('Please select period');
        //                     return false;
        //                 }

        //            var formData = new FormData();
        //                 formData.append('country', country);
        //                 formData.append('period', period);

        // if(period=="All")
        // {
        //   $.ajax({
        //                     type: 'post',
        //                     url: 'csv2.php?api=all_data2',
        //                  //   url: 'rough.php',
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     success: function (data) {
        //                    //   alert(data);
        //                    //////console.log(data);
        //                   //location.reload();


        //                     },
        //                     error: function (data) {
        //                         alert(
        //                             "An error has occcured while applying leave. Please try again"
        //                         );
        //                     }
        //                 });
        // }
        // else
        // {
        //   $.ajax({
        //                     type: 'post',
        //                    url: 'csv2.php?api=monthly',
        //                    //  url: 'rough.php',
        //                     data: formData,
        //                     processData: false,
        //                     contentType: false,
        //                     success: function (data) {
        //                    //   alert(data);
        //                    //////console.log(data);
        //                   //location.reload();


        //                     },
        //                     error: function (data) {
        //                         alert(
        //                             "An error has occcured while applying leave. Please try again"
        //                         );
        //                     }
        //                 });
        // }

        //               });



        $('body').on('click', function() {
            //alert('hi');
        });



        //Highlight upcoming time off for user
        $('.up-date').each(function() {
            let dateValue = $(this).text();
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                "Nov", "Dec"
            ];
            const d = new Date();
            let monthValue = monthNames[d.getMonth()];
            if (dateValue.indexOf(monthValue) != -1) {
                $(this).parent().parent().css('background', '#800000');
            }
        });




        $('body').on('click', '.log-out', function() {
            var userID = $(this).attr('data-id');
            //alert(userID);
            //Loading effect
            $('body').css('opacity', '0.5');
            $('.loader').show();

            $.ajax({
                type: 'post',
                url: 'login_db.php?api=LogOut',
                data: {
                    id: userID
                },
                success: function(data) {
                //////console.log(data);
                    alert('logout successfully');
                 //   window.location.href = data2;
                    window.location.href = data;

                },
                error: function(data) {
                    alert(
                        "An error has occcured while logout. Please try again"
                    );
                }
            });
        });

        $(function() {
            $("#date1").datepicker( );

        });

        $(function() {
            $("#date2").datepicker();
        });





        //added below line to show the user calender on reload
        $('.grid-row-2').load('user-calendar.php');
        $('.csv_buttons').hide();
        $('.sel-drop').hide();
        $('.toggle-btn').hide();
       
        $('#selButton').hide();
        $('#usrButton').show();

        // Change panel between user and admin
        $('body').on('click', '.leave-title', function(e) {
            e.preventDefault();
            location.reload();
            $('.admin-title').removeClass('active');
            $(this).addClass('active');


            $('.leave_admin-section').load('leave-section.php');
            $('.grid-row-1').load('user-leave-history.php');
            $('.grid-row-2').load('user-calendar.php');
            $('.csv_buttons').hide();
            $('.sel-drop').hide();
            $('.toggle-btn').hide();
       

        $('#selButton').hide();
            $('#usrButton').show();
        });


        //$('.admin-title').click(function (e) {
        $('body').on('click', '.admin-title', function(e) {
            e.preventDefault();
            //    location.reload();
            $('.leave-title').removeClass('active');
            $(this).addClass('active');

            $('.leave_admin-section').load('admin-section.php');
            $('.grid-row-1').load('admin-leave-history.php');
            $('.grid-row-2,.newSelect').load('admin-calendar.php');
            $('.csv_buttons').show();
            $('.toggle-btn').show();

            $('.sel-drop').show();
        $('#selButton').show();
            $('#usrButton').hide();
	    $('#start-Date').val('');
           $('#end-Date').val('');
        });



        // Delete user leave history row
                $('body').on('click', '.user-cross', function() {

            if (confirm("are you sure you want to delete it?")) {

                var del = $(this);
                var del_id = $(del).closest('.table-data').attr('data-id');
                var user_id = $(del).closest('.table-data').attr('data-user-id');
                var leaveType = $(del).closest('.table-data').find('.type').text();
                var leaveCount = $(del).closest('.table-data').find('.count').text();
                // alert(del_id);
                // alert(user_id);
                // alert(leaveType);
                // alert(leaveCount);

                $.ajax({
                    type: 'post',
                    url: 'api.php?api=del_user',
                    data: {
                        apply_id: del_id,
                        user_id: user_id,
                        leave_type: leaveType,
                        count: leaveCount
                    },
                    success: function(data) {
                   //////console.log(data);
                        if(data == 'You cannot delete past approved holidays'){
                            alert(data);
                        }else{
                            $(".success-msg").css("z-index", "unset");
                            $(".successfully-deleted").css("display", "block").delay(1000)
                                .fadeOut(400);
                            location.reload();
                            $(del).closest('.table-data').last().remove();
                            //////console.log(data);
                            $('.leave_admin-section').load('leave-section.php');

                        }

                    },
                    error: function(data) {
                        location.reload();
                        // alert(
                        //     "An error has occcured while deleting. Please try again"
                        // );
                    }
                });


            }
            return false;


        });



        // Delete admin leave history row
        $('body').on('click', '.admin-cross', function() {
            //   alert('he');

            if (confirm("are you sure you want to delete it?")) {

                var del = $(this);
                var apply_id = $(del).closest('.table-data').attr('data-id');
                var user_id = $(del).closest('.table-data').attr('data-user-id');
               var login_id = $('#user_id').val();
                var type = $(del).closest('.table-data').find('.type').text();
                var count = $(del).closest('.table-data').find('.count').text();
                var funct_status = $('.funct_status').text();
                var post_status = $('.post_status').text();
                // alert(apply_id);
                // alert(user_id);
                // alert(login_id);
                // alert(type);
                // alert(count);
                // alert(funct_status);
                // alert(post_status);




                $.ajax({
                    type: 'post',
                    url: 'api.php?api=del_admin',
                    data: {
                        apply_id: apply_id,
                        user_id: user_id,
                        login_id: login_id,
                        type: type,
                        count: count,
                        funct_status: funct_status,
                        post_status: post_status
                    },
                    success: function(data) {
                        $(del).closest('.table-data').last().remove();
                        //////console.log(data);
                        //alert(data);
                    },
                    error: function(data) {
                        alert(
                            "An error has occcured while deleting. Please try again"
                        );
                    }
                });

                $(".success-msg").css("z-index", "unset");
                $(".successfully-deleted").css("display", "block").delay(1000)
                    .fadeOut(400);
            }
            return false;
        });

        // More info leave history
        $('body').on('click', '.emp-data', function() {
            var css = $(this).closest('.table-data').next('.more-info');
            $(this).closest('.table-data').next('.more-info').slideToggle('slow');
            $(css).css({
                'display': 'grid'
            });
        });

        // Cancel button for admin leave history section user info approval.
        $('body').on('click', '.cancel', function() {
            $(this).closest('.more-info').hide('slow');
        });




        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        function test() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);


            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

           



            for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
            }

                    // const month_frmt = ["01","02","03","04","05","06","07","08","09","10","11","12"];
            $("#date1").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                var month = date.getMonth() + 1;
                  // var month = month_frmt[date.getMonth()];
                    var year = date.getFullYear();
                    //console.log(year);
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                //console.log(newdate);



                    ////////console.log(datepicker_working_list_data.length);

             

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }




                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

            //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
             var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');
                //console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }


 
                    for (var j = 0; j < holiday_data.length; j++) {
                            
                        //var holiday_range = holiday_data[j].holiday_date2.split(' ');
                        var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];
                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    //var month = month_frmt[date.getMonth()];
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    ///////////////////////////////////
                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                    //    var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                            var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }

                    //////////////////////////////////


                    for (var j = 0; j < holiday_data.length; j++) {

                      //  var holiday_range = holiday_data[j].holiday_date2.split(' ');
                        var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1").datepicker("getDate");

                var endDate = $("#date2").datepicker("getDate");
                ////console.log(startDate,endDate);
                if (startDate == null && endDate != null) {
                    alert("please select the startDate first");
                    endDate = "";
                    $("#date2").val("");
                    return false;
                }

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //  //////console.log(sunSAT);
                /// //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                //////console.log(sunSAT);
                //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    // ////console.log("sunsat is :" + countt);
                    // ////console.log("holiday is :" + count);
                    // ////console.log("listdate is :" + listDate.length);

                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {

                    var total = listDate.length;

                }

              

            if(total>1 && leaveType_val==2)
            {
                        $('.toHalf').show();

            }
            else
            {
                 $('.toHalf').hide();
            }
              //  $('#leave_count').val(total);
            $('#leave_count').attr('data-final', total);
                change_from_to();
            }
        }

        function test2() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);


            // var datepicker_working_list='<?php   $datepicker_working_list; ?>';
            // let datepicker_working_list_data=JSON.parse(datepicker_working_list);

            var sun_sat_range = [];
            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }


            $("#date1").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();
                              //console.log(year);
                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);




                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                    //                        var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                     var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }



                    ////////console.log(holiday_data.length);

                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                    //                        var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
         var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }



                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1").datepicker("getDate");

                var endDate = $("#date2").datepicker("getDate");
                if (startDate == null && endDate != null) {
                    alert("please select the startDate first");
                    endDate = "";
                    $("#date2").val("");
                    return false;
                }

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var sunSAT = sun_sat_range;

                var countt = 0;
                ////////console.log(holiday[0]);
                //   //////console.log(listDate[0]);

                if (sunSAT != 0) {


                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        // //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }

                    //////console.log("sunsat is :" + countt);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

               var leaveType_val=$("#leave_select").find(':selected').val();
               ////console.log(leaveType_val);
            if(total>1 && leaveType_val==2)
            //if(total>1)
            {
                        $('.toHalf').show();

            }
            else
            {
                 $('.toHalf').hide();
            }
             //   $('#leave_count').val(total);
            $('#leave_count').attr('data-final', total);
                change_from_to();
            }

        }

        function test3() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);

            // var datepicker_working_list='<?php   $datepicker_working_list; ?>';
            // let datepicker_working_list_data=JSON.parse(datepicker_working_list);

            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
            }



            $("#date1").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();
                //console.log(year);
                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    ////////console.log(datepicker_working_list_data.length);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    // //////console.log(holiday_data.length);

                    for (var j = 0; j < holiday_data.length; j++) {

                       // var holiday_range = holiday_data[j].holiday_date2.split(' ');
                var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    //////////////////////////////////


                    for (var j = 0; j < holiday_data.length; j++) {

                        //var holiday_range = holiday_data[j].holiday_date2.split(' ');
             var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1").datepicker("getDate");

                var endDate = $("#date2").datepicker("getDate");
                // alert(endDate);
                if (startDate == null && endDate != null) {
                    alert("please select the startDate first");
                    endDate = "";
                    $("#date2").val("");
                    //alert(endDate);
                    //location.reload();
                    //window.location.reload();
                    //  $(".apply-leave-section").children(".form").children("#date2").load("leave-section.php" + " #date2");

                    //      $(".apply-leave-section").load("leave-section.php" + " #date2");
                    // $('#date2').load('leave-section.php');
                    return false;
                }

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //  //////console.log(sunSAT);
                // //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

               var leaveType_val=$("#leave_select").find(':selected').val();
               ////console.log(leaveType_val);
               //  if(leaveType_val==4)
               // {
               //               var dateString=maternity_cal(startDate);
               //                  $("#date2").val(dateString);
               // }
              
            if(total>1 && leaveType_val==2)
          //  if(total>1)
            {
                        $('.toHalf').show();

            }
            else
            {
                 $('.toHalf').hide();
            }
               // $('#leave_count').val(total);
               $('#leave_count').attr('data-final', total);
                change_from_to();
            }
        }

        function test4() {
                        //  alert("hi");
                        var sat_sun = '<?php echo  $sat_sun; ?>';
                        let sat_sun_data = JSON.parse(sat_sun);



                        var sun_sat_range = [];

                        var holiday_range = [];
                        ////////console.log(sat_sun_data);
                        ////////console.log(sat_sun_data['sun'].length);

                        for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                        sun_sat_range.push(sat_sun_data["sun"][k]);
                        }

                        // //////console.log(sun_sat_range);

                        //var year =new Date().getFullYear();

                        $("#date1").datepicker({
                        //  minDate: new Date(year, 0, 1),
                        // maxDate: new Date(year, 11, 31),
                        yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                        beforeShowDay: function(date) {
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();

                        var day = date.getDate();
                        //console.log(year);
                        // Change format of date
                        var newdate = day + "-" + month + '-' + year;

                        ////////console.log(only_sat_sun2['length']);
                        for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                        }


                        return [true];
                        },

                        onSelect: function() {
                        myfunc();
                        }

                        });


                        $("#date2").datepicker({
                        yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                        beforeShowDay: function(date) {
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();
                        var day = date.getDate();

                        // Change format of date
                        var newdate = day + "-" + month + '-' + year;
                        //   //////console.log(newdate);



                        for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                        }

                        return [true];
                        },


                        onSelect: function() {
                        myfunc();
                        }
                        });

                        var days;

                        function myfunc() {


                        var startDate = $("#date1").datepicker("getDate");
                        var endDate = $("#date2").datepicker("getDate");
                        if (startDate == null && endDate != null) {
                        alert("please select the startDate first");
                        endDate = "";
                        $("#date2").val("");
                        return false;
                        }

                        function convert(startDate) {
                        var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                        return [date.getFullYear(), mnth, day].join("-");
                        }

                        function convert(endDate) {
                        var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                        return [date.getFullYear(), mnth, day].join("-");
                        }

                        var STARTDATE = convert(startDate);
                        var ENDDATE = convert(endDate);
                        // //////console.log(endDate);

                        var listDate = [];
                        var dateMove = new Date(STARTDATE);
                        var strDate = STARTDATE;


                        if (strDate != ENDDATE) {
                        while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                        }
                        } else if (strDate == ENDDATE) {
                        //     while (strDate==ENDDATE)
                        // {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate());
                        //}
                        }

                        var holiday = holiday_range;
                        var sunSAT = sun_sat_range;
                        //////console.log(holiday.length);
                        //////console.log(sunSAT);
                        //////console.log(listDate);

                        var count = 0;
                        var countt = 0;
                        //          //////console.log(holiday);
                        // //////console.log(sunSAT);
                        //        //////console.log(listDate);

                        if (sunSAT != 0) {
                        for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                        }


                        //////console.log("sunsat is :" + countt);
                        //////console.log("holiday is :" + count);
                        //////console.log("listdate is :" + listDate.length);
                        var total = listDate.length - count - countt;
                        //////console.log("total is :" + total);


                        } else {
                        var total = listDate.length;

                        }

                        var leaveType_val=$("#leave_select").find(':selected').val();
                        // if(leaveType_val==4)
                        // {
                        //      var dateString=maternity_cal(startDate);
                        //         $("#date2").val(dateString);
                        // }



                        var leaveType_val=$("#leave_select").find(':selected').val();
                        ////console.log(leaveType_val);


                        if(total>1 && leaveType_val==2)
                        {
                        $('.toHalf').show();

                        }
                        else
                        {
                        $('.toHalf').hide();
                        }



                        // if(leaveType_val==4)
                        // {
                        // total=182;
                        // $('#leave_count').val(total);

                        // }
                        // else
                        // {
                        $('#leave_count').val(total);
                        //}



                        $('#leave_count').attr('data-final',total);
                        change_from_to();
                        }
        }


//////////////////////for apply leave calender//////////////////////////
// function maternity_cal(startDate)
// {
//      var result = new Date(startDate);
//                                 result.setDate(result.getDate() + 182);
//                                 console.log(result);
//                                 // var dateString = new Date(result.getTime() - (result.getTimezoneOffset() * 60000 )).toISOString().split("T")[0];
//                                 var d = new Date(result),
//                                 month = '' + (d.getMonth() + 1),
//                                 day = '' + d.getDate(),
//                                 year = d.getFullYear();

//                                 if (month.length < 2) 
//                                 month = '0' + month;
//                                 if (day.length < 2) 
//                                 day = '0' + day;
//                                 var dateString="";
//                                 $("#date2").val(" ");
//                                 dateString=[month,day,year].join('/');
//                                 // $("#date2").val(dateString);
//                                 return dateString;
// }



function change_from_to()
{

        var fromh=$("#fromHalf").find(":selected").val();
        var toH=$("#toHalf").find(":selected").val();
        var fromDat = $("input[name='date1']").val();
        var toDat = $("input[name='date2']").val();
        //var leaveC = $("input[name='leave_count']").val();
        var leaveC = $("input[name='leave_count']").attr('data-final');
        //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);
                    if((fromh==2 || fromh==3) && (toH==2 || toH==3))
                    {
                        mail_total='';
                        var mail_total=leaveC-1;

                        if(mail_total<0)
                        {
                        //alert("mail");
                        $('#leave_count').val("0");
                        }
                        else
                        {
                        $('#leave_count').val(mail_total);
                        }

                    }
                    else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
                    {
                        mail_total='';
                        var mail_total=leaveC-0.5;
                       // alert("mail="+mail_total);
                       if(mail_total<0)
                        {
                        mail_total=0;
                        $('#leave_count').val("0");
                        }
                        else
                        {
                        $('#leave_count').val(mail_total);
                        }
                    }
                    else if(fromh==1 || fromh==1)
                    {
                        $('#leave_count').val("");
                       // alert("fd");
                        $('#leave_count').val(leaveC);
                    }
}




$("#fromHalf").on('change',function(){
        var fromh=this.value;
        var toH=$(this).siblings("#toHalf").find(":selected").val();
        var fromDat = $("input[name='date1']").val();
        var toDat = $("input[name='date2']").val();
        //var leaveC = $("input[name='leave_count']").val();
        var leaveC = $("input[name='leave_count']").attr('data-final');
            //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);
                    if((fromh==2 || fromh==3) && (toH==2 || toH==3))
                    {
                        mail_total='';
                        var mail_total=leaveC-1;
                        if(mail_total<0)
                                {
                                // alert("mail");
                                $('#leave_count').val("0");
                                }
                                else
                                {
                                $('#leave_count').val(mail_total);
                                }
                    }
                    else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
                    {
                        mail_total='';
                        var mail_total=leaveC-0.5;
                        if(mail_total<0)
                                {
                                // alert("mail");
                                $('#leave_count').val("0");
                                }
                                else
                                {
                                $('#leave_count').val(mail_total);
                                }
                    }
         else if(fromh==1 || fromh==1)
                            {
                                $('#leave_count').val("");
                                // alert("fd");
                                $('#leave_count').val(leaveC);
                            }

});

$("#toHalf").on('change',function(){
        // alert("to");
        var toH=this.value;
        var fromh=$(this).siblings("#fromHalf").find(":selected").val();
        var fromDat = $("input[name='date1']").val();
        var toDat = $("input[name='date2']").val();
        //var leaveC = $("input[name='leave_count']").val();
        var leaveC = $("input[name='leave_count']").attr('data-final');
        //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);
                    if((fromh==2 || fromh==3) && (toH==2 || toH==3))
                    {
                        mail_total='';
                        var mail_total=leaveC-1;
                        // alert("mail="+mail_total);
                                 $('#leave_count').val(mail_total);
                    }
                    else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
                    {
                        mail_total='';
                        var mail_total=leaveC-0.5;
                        // alert("mail="+mail_total);
                         $('#leave_count').val(mail_total);
                    }
                     else if(fromh==1 || fromh==1)
                            {
                                $('#leave_count').val("");
                                // alert("fd");
                                $('#leave_count').val(leaveC);
                            }

});
/////////////////////////////////////////////////////////////////////////////////////////////



        function user_test() {

            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);



            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
            }



            $("#date1-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    ////////console.log(datepicker_working_list_data.length);


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }


                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                        //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
          var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                                //   //////console.log(datepicker_working_list_range);

                                var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                                    .holiday;
                                //   //////console.log(tooltip_workinglist);
                                if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                                    return [true, "highlight_workinglist", tooltip_workinglist];
                                }

                            }


                            // //////console.log(holiday_data.length);

                            for (var j = 0; j < holiday_data.length; j++) {

                               // var holiday_range = holiday_data[j].holiday_date2.split(' ');
          var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    // }

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    ///////////////////////////////////
                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                       // var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }

                    //////////////////////////////////


                    for (var j = 0; j < holiday_data.length; j++) {

                       // var holiday_range = holiday_data[j].holiday_date2.split(' ');
                          var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-user").datepicker("getDate");
                var endDate = $("#date2-edit-user").datepicker("getDate");


                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                //$('#leave_count_edit_user').val(total);
            ////////////////////////
            // alert("enter");
            //if(total>1)
                           var leaveType_val=$("#leave_select").find(':selected').val();
                           ////console.log(leaveType_val);
                        if(total>1 && leaveType_val==2)
            {
            // alert("greater");
            //            $('.toHalf_user_edit').show();
                        $('.toHalf_user_edit').css('display','block');

            }
            else
            {
            //     $('.toHalf_user_edit').hide();
                        $('.toHalf_user_edit').css('display','none');
            }
                           $('#leave_count_edit_user').val(total);
                       $('#leave_count_edit_user').attr('data-final',total);
                            change_from_to_user_edit();
            ////////////////////////////////////////////////////
                        }
        }

        function user_test2() {
                var sat_sun = '<?php echo  $sat_sun; ?>';
                let sat_sun_data = JSON.parse(sat_sun);



                var sun_sat_range = [];
                for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
                }


                $("#date1-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),

                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }




                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                        //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }



                    ////////console.log(holiday_data.length);

                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

                });


                $("#date2-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                      for (var k = 0; k < datepicker_working_list_data.length; k++) {

                //                        var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }


                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
                });

                var days;

                function myfunc() {


                var startDate = $("#date1-edit-user").datepicker("getDate");
                var endDate = $("#date2-edit-user").datepicker("getDate");
                if (startDate == null && endDate != null) {
                    alert("please select the startDate first");
                    endDate = "";
                    $("#date2").val("");
                    return false;
                }

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var sunSAT = sun_sat_range;

                var countt = 0;
                ////////console.log(holiday[0]);
                //////console.log(listDate[0]);

                if (sunSAT != 0) {


                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }

                    //////console.log("sunsat is :" + countt);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                //$('#leave_count_edit_user').val(total);
                ////////////////////////
                // alert("enter");
                //if(total>1)
                var leaveType_val=$("#leave_select").find(':selected').val();
                ////console.log(leaveType_val);
                if(total>1 && leaveType_val==2)
                {
                // alert("greater");
                //            $('.toHalf_user_edit').show();
                $('.toHalf_user_edit').css('display','block');

                }
                else
                {
                //     $('.toHalf_user_edit').hide();
                $('.toHalf_user_edit').css('display','none');
                }
                $('#leave_count_edit_user').val(total);
                $('#leave_count_edit_user').attr('data-final',total);
                change_from_to_user_edit();
                ////////////////////////////////////////////////////
                }
        }

        function user_test3() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);



            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
            }



            $("#date1-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),

                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }



                    // //////console.log(holiday_data.length);

                    for (var j = 0; j < holiday_data.length; j++) {

                       // var holiday_range = holiday_data[j].holiday_date2.split(' ');
                    var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }



                    for (var j = 0; j < holiday_data.length; j++) {

                        //var holiday_range = holiday_data[j].holiday_date2.split(' ');
                    var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-user").datepicker("getDate");
                var endDate = $("#date2-edit-user").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                //$('#leave_count_edit_user').val(total);
                    //////////////////////////////////////////////////////////////////////
                    // alert("enter");
                                   var leaveType_val=$("#leave_select").find(':selected').val();
                                   ////console.log(leaveType_val);
                                if(total>1 && leaveType_val==2)
                    //if(total>1)
                    {
                    // alert("greater");
                    //            $('.toHalf_user_edit').show();
                                $('.toHalf_user_edit').css('display','block');

                    }
                    else
                    {
                    //     $('.toHalf_user_edit').hide();
                                $('.toHalf_user_edit').css('display','none');
                    }
                                   $('#leave_count_edit_user').val(total);
                               $('#leave_count_edit_user').attr('data-final',total);
                                    change_from_to_user_edit();
                    ///////////////////////////////////////////////////////////////////////
                                }
        }

        function user_test4() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);



            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            // for (var j = 0; j < holiday_data.length; j++)
            // {
            // holiday_range.push(holiday_data[j].holiday_date);
            // }


            $("#date1-edit-user").datepicker({
                yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }
                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });



            $("#date2-edit-user").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }
                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-user").datepicker("getDate");
                var endDate = $("#date2-edit-user").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(holiday.length);
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (sunSAT != 0) {
                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

               // $('#leave_count_edit_user').val(total);
            //////////////////////////////
            // alert("enter");
            //if(total>1)
                           var leaveType_val=$("#leave_select").find(':selected').val();
                           ////console.log(leaveType_val);
                        if(total>1 && leaveType_val==2)
            {
            // alert("greater");
            //            $('.toHalf_user_edit').show();
                        $('.toHalf_user_edit').css('display','block');

            }
            else
            {
            //     $('.toHalf_user_edit').hide();
                        $('.toHalf_user_edit').css('display','none');
            }
                           $('#leave_count_edit_user').val(total);
                       $('#leave_count_edit_user').attr('data-final',total);
                            change_from_to_user_edit();
            /////////////////////////////////////
                        }
        }



//////////////////////for edit user leave calender//////////////////////////
function change_from_to_user_edit()
{
            // alert("Df");
            var fromh=$("#fromHalf_user_edit").find(":selected").val();
            var toH=$("#toHalf_user_edit").find(":selected").val();            
            var fromDat = $("input[name='date1-edit-user']").val();
            var toDat = $("input[name='date2-edit-user']").val();
            //var leaveC = $("input[name='leave_count']").val();
            var leaveC = $("input[name='leave_count_edit_user']").attr('data-final');
            //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);

            if(((fromDat==toDat) && (fromh==2 || fromh==3)) || ((fromDat!=toDat) && ((fromh==2 || fromh==3) && (toH==1) || ((toH==2 || toH==3) && (fromh==1)))))
                    {
                       
                        mail_total='';
                      
                        var mail_total=leaveC-0.5;
                        if(mail_total<0)
                        {
                                  // alert("this_run");
                                    $('#leave_count_edit_user').val("0");                            
                        }
                        else
                        {
                                    //alert("this_count");
                                    //alert(mail_total);
                                  //  $('#leave_count_edit_user').val('');
                                    $('#leave_count_edit_user').val(mail_total);
                        }

                    }
            else if((fromDat!=toDat) && (fromh==2 || fromh==3) && (toH==2 || toH==3))
                {
                        mail_total='';
                        var mail_total=leaveC-1;

                        if(mail_total<0)
                        {
                                    //alert("mail");
                                    $('#leave_count_edit_user').val("0");                            
                        }
                        else
                        {
                                    $('#leave_count_edit_user').val(mail_total);
                        }

                    }    
            else if(((fromDat==toDat) && (fromh==1)) || ((fromDat!=toDat) && (fromh==1) && (fromh==1)))
            {
                        $('#leave_count_edit_user').val("");
                       // alert("fd");
                        $('#leave_count_edit_user').val(leaveC);
            }

            //       if((fromh==2 || fromh==3) && (toH==2 || toH==3) && (fromDat!=toDat))
            //                     {
            //                         mail_total='';
            //                         var mail_total=leaveC-1;

            //                         if(mail_total<0)
            //                         {
            //                         //alert("mail");
            //                         $('#leave_count_edit_user').val("0");
            //                         }
            //                         else
            //                         {
            //                         $('#leave_count_edit_user').val(mail_total);
            //                         }

            //                     }
            //                         else if((fromh==2 || fromh==3) && (toH==2 || toH==3) && (fromDat==toDat))
            //                     {
                        
            //                         mail_total='';
            //                         var mail_total=leaveC-0.5;
            // alert(mail_total);
            //                         if(mail_total<0)
            //                         {
                      
            //                         $('#leave_count_edit_user').val("0");                            
            //                         }
            //                         else
            //                         {
            //                               alert("this");
            //                         $('#leave_count_edit_user').val(mail_total);
            //                         }

            //                     }
            //                     else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
            //                     {
            //                         mail_total='';
            //                         var mail_total=leaveC-0.5;
            //                        // alert("mail="+mail_total);
            //                        if(mail_total<0)
            //                         {
            //                         mail_total=0;
            //                         $('#leave_count_edit_user').val("0");
            //                         }
            //                         else
            //                         {
            //                         $('#leave_count_edit_user').val(mail_total);
            //                         }
            //                     }
            //                     else if(fromh==1 || fromh==1)
            //                     {
            //                         $('#leave_count_edit_user').val("");
            //                        // alert("fd");
            //                         $('#leave_count_edit_user').val(leaveC);
            //                     }
}



$("body").on('change','#fromHalf_user_edit',function(){
            //$("#fromHalf_user_edit").on('change',function(){
            // alert("runn");
            var fromh=this.value;
            var toH=$(this).siblings("#toHalf_user_edit").find(":selected").val();
            var fromDat = $("input[name='date1-edit-user']").val();
            var toDat = $("input[name='date2-edit-user']").val();
            //var leaveC = $("input[name='leave_count']").val();
            var leaveC = $("input[name='leave_count_edit_user']").attr('data-final');
            //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);
            if(((fromDat==toDat) && (fromh==2 || fromh==3)) || ((fromDat!=toDat) && ((fromh==2 || fromh==3) && (toH==1) || ((toH==2 || toH==3) && (fromh==1)))))
                    {
                       
                        mail_total='';
                      
                        var mail_total=leaveC-0.5;
                        if(mail_total<0)
                        {
                                   //alert("this_run");
                                    $('#leave_count_edit_user').val("0");                            
                        }
                        else
                        {
                                  //  alert("this_count");
                                  //  alert(mail_total);
                                    $('#leave_count_edit_user').val('');
                                    $('#leave_count_edit_user').val(mail_total);
                        }

                    }
            else if((fromDat!=toDat) && (fromh==2 || fromh==3) && (toH==2 || toH==3))
                {
                        mail_total='';
                        var mail_total=leaveC-1;

                        if(mail_total<0)
                        {
                                    //alert("mail");
                                    $('#leave_count_edit_user').val("0");                            
                        }
                        else
                        {
                                    $('#leave_count_edit_user').val(mail_total);
                        }

                    }    
            else if(((fromDat==toDat) && (fromh==1)) || ((fromDat!=toDat) && (fromh==1) && (fromh==1)))
            {
                        $('#leave_count_edit_user').val("");
                       // alert("fd");
                        $('#leave_count_edit_user').val(leaveC);
            }

            // if((fromh==2 || fromh==3) && (toH==2 || toH==3))
            //            {
            //                mail_total='';
            //                var mail_total=leaveC-1;
            //                if(mail_total<0)
            //                        {
            //                        // alert("mail");
            //                        $('#leave_count_edit_user').val("0");
            //                        }
            //                        else
            //                        {
            //                        $('#leave_count_edit_user').val(mail_total);
            //                        }
            //            }
            //            else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
            //            {
            //                mail_total='';
            //                var mail_total=leaveC-0.5;
            //                if(mail_total<0)
            //                        {
            //                        // alert("mail");
            //                        $('#leave_count_edit_user').val("0");
            //                        }
            //                        else
            //                        {
            //                        $('#leave_count_edit_user').val(mail_total);
            //                        }
            //            }
            // else if(fromh==1 || fromh==1)
            //                    {
            //                        $('#leave_count_edit_user').val("");
            //                        // alert("fd");
            //                        $('#leave_count_edit_user').val(leaveC);
            //                    }



});

$("body").on('change','#toHalf_user_edit',function(){
                //$("#toHalf_user_edit").on('change',function(){
                // alert("to");
                var toH=this.value;
                var fromh=$(this).siblings("#fromHalf_user_edit").find(":selected").val();
                var fromDat = $("input[name='date1-edit-user']").val();
                var toDat = $("input[name='date2-edit-user']").val();
                //var leaveC = $("input[name='leave_count']").val();
                var leaveC = $("input[name='leave_count_edit_user']").attr('data-final');
                //////console.log(fromh +'=' +toH +' = '+fromDat+' = '+toDat+' = '+leaveC);
                if(((fromDat==toDat) && (fromh==2 || fromh==3)) || ((fromDat!=toDat) && ((fromh==2 || fromh==3) && (toH==1) || ((toH==2 || toH==3) && (fromh==1)))))
                {

                mail_total='';

                var mail_total=leaveC-0.5;
                if(mail_total<0)
                {
                           //alert("this_run");
                            $('#leave_count_edit_user').val("0");                            
                }
                else
                {
                           // alert("this_count");
                          //  alert(mail_total);
                            $('#leave_count_edit_user').val('');
                            $('#leave_count_edit_user').val(mail_total);
                }

                }
                else if((fromDat!=toDat) && (fromh==2 || fromh==3) && (toH==2 || toH==3))
                {
                mail_total='';
                var mail_total=leaveC-1;

                if(mail_total<0)
                {
                            //alert("mail");
                            $('#leave_count_edit_user').val("0");                            
                }
                else
                {
                            $('#leave_count_edit_user').val(mail_total);
                }

                }    
                else if(((fromDat==toDat) && (fromh==1)) || ((fromDat!=toDat) && (fromh==1) && (fromh==1)))
                {
                $('#leave_count_edit_user').val("");
                // alert("fd");
                $('#leave_count_edit_user').val(leaveC);
                }

                // if((fromh==2 || fromh==3) && (toH==2 || toH==3))
                // {
                //     mail_total='';
                //     var mail_total=leaveC-1;
                //     // alert("mail="+mail_total);
                //              $('#leave_count_edit_user').val(mail_total);
                // }
                // else if(((fromh==2 || fromh==3) && (toH==1)) || ((toH==2 || toH==3) && (fromh==1)))
                // {
                //     mail_total='';
                //     var mail_total=leaveC-0.5;
                //     // alert("mail="+mail_total);
                //      $('#leave_count_edit_user').val(mail_total);
                // }
                //  else if(fromh==1 || fromh==1)
                //         {
                //             $('#leave_count_edit_user').val("");
                //             // alert("fd");
                //             $('#leave_count_edit_user').val(leaveC);
                //         }

});
/////////////////////////////////////////////////////////////////////////////////////////////


        function admin_test() {
                var sat_sun = '<?php echo  $sat_sun; ?>';
                let sat_sun_data = JSON.parse(sat_sun);



                var sun_sat_range = [];

                var holiday_range = [];
                ////////console.log(sat_sun_data);
                ////////console.log(sat_sun_data['sun'].length);

                for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
                }

                // //////console.log(sun_sat_range);



                for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
                }



                $("#date1-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    ////////console.log(datepicker_working_list_data.length);

                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                        //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }


                    // //////console.log(holiday_data.length);

                    for (var j = 0; j < holiday_data.length; j++) {

                        //var holiday_range = holiday_data[j].holiday_date2.split(' ');
                var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

                });


                $("#date2-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);


                    for (var j = 0; j < only_sat_sun2.length; j++) {
                        var s_range = [only_sat_sun2[j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    ///////////////////////////////////
                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                        //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }

                    //////////////////////////////////


                    for (var j = 0; j < holiday_data.length; j++) {

                       // var holiday_range = holiday_data[j].holiday_date2.split(' ');
                var holiday_range = holiday_data[j].holiday_date3.split(' ');
                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
                });

                var days;

                function myfunc() {


                var startDate = $("#date1-edit-admin").datepicker("getDate");
                var endDate = $("#date2-edit-admin").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                $('#leave_count_edit_admin').val(total);
                }
        }

        function admin_test2() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);




            var sun_sat_range = [];
            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }


            $("#date1-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }



                    for (var k = 0; k < datepicker_working_list_data.length; k++) {

                        //var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
                         var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k].holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }



                    ////////console.log(holiday_data.length);

                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                   


                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }
                      for (var k = 0; k < datepicker_working_list_data.length; k++) {

                     //                        var datepicker_working_list_range = datepicker_working_list_data[k].Working_day.split(' ');
             var datepicker_working_list_range = datepicker_working_list_data[k].up_date3.split(' ');

                        //   //////console.log(datepicker_working_list_range);

                        var tooltip_workinglist = "Working for " + datepicker_working_list_data[k]
                            .holiday;
                        //   //////console.log(tooltip_workinglist);
                        if ($.inArray(newdate, datepicker_working_list_range) != -1) {
                            return [true, "highlight_workinglist", tooltip_workinglist];
                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-admin").datepicker("getDate");
                var endDate = $("#date2-edit-admin").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var sunSAT = sun_sat_range;

                var countt = 0;
                ////////console.log(holiday[0]);
                //////console.log(listDate[0]);

                if (sunSAT != 0) {


                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }

                    //////console.log("sunsat is :" + countt);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                $('#leave_count_edit_admin').val(total);
            }
        }

        function admin_test3() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);



            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            for (var j = 0; j < holiday_data.length; j++) {
                holiday_range.push(holiday_data[j].holiday_date);
            }



            $("#date1-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    // //////console.log(holiday_data.length);

                    for (var j = 0; j < holiday_data.length; j++) {

                       // var holiday_range = holiday_data[j].holiday_date2.split(' ');
                        var holiday_range = holiday_data[j].holiday_date3.split(' ');

                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    for (var j = 0; j < holiday_data.length; j++) {

                      //  var holiday_range = holiday_data[j].holiday_date2.split(' ');
                          var holiday_range = holiday_data[j].holiday_date3.split(' ');

                        // //////console.log(data[0].final_status);
                        var tooltip_holiday = "Holiday for " + [holiday_data[j].holiday];

                        if ($.inArray(newdate, holiday_range) != -1) {
                            return [true, "highlight_holiday", tooltip_holiday];

                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-admin").datepicker("getDate");
                var endDate = $("#date2-edit-admin").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (holiday != 0 && sunSAT != 0) {
                    for (var i = 0; i < holiday.length; i++) {
                        var t = listDate.includes(holiday[i]);

                        if (t == true) {
                            //                          count=1;
                            count++;
                        }
                        // else
                        // {
                        //   count=0;
                        // }
                    }

                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                $('#leave_count_edit_admin').val(total);
            }
        }

        function admin_test4() {
            var sat_sun = '<?php echo  $sat_sun; ?>';
            let sat_sun_data = JSON.parse(sat_sun);



            var sun_sat_range = [];

            var holiday_range = [];
            ////////console.log(sat_sun_data);
            ////////console.log(sat_sun_data['sun'].length);

            for (var k = 0; k < sat_sun_data['sun'].length; k++) {
                sun_sat_range.push(sat_sun_data["sun"][k]);
            }

            // //////console.log(sun_sat_range);



            // for (var j = 0; j < holiday_data.length; j++)
            // {
            // holiday_range.push(holiday_data[j].holiday_date);
            // }



            $("#date1-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }


                    return [true];
                },

                onSelect: function() {
                    myfunc();
                }

            });


            $("#date2-edit-admin").datepicker({
                 yearRange: new Date().getFullYear() + ':' + new Date().getFullYear(),
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    //   //////console.log(newdate);



                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    return [true];
                },


                onSelect: function() {
                    myfunc();
                }
            });

            var days;

            function myfunc() {


                var startDate = $("#date1-edit-admin").datepicker("getDate");
                var endDate = $("#date2-edit-admin").datepicker("getDate");

                function convert(startDate) {
                    var date = new Date(startDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                function convert(endDate) {
                    var date = new Date(endDate),
                        mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                        day = ("0" + date.getDate()).slice(-2);
                    return [date.getFullYear(), mnth, day].join("-");
                }

                var STARTDATE = convert(startDate);
                var ENDDATE = convert(endDate);
                // //////console.log(endDate);

                var listDate = [];
                var dateMove = new Date(STARTDATE);
                var strDate = STARTDATE;


                if (strDate != ENDDATE) {
                    while (strDate < ENDDATE) {
                        var strDate = dateMove.toISOString().slice(0, 10);
                        listDate.push(strDate);
                        dateMove.setDate(dateMove.getDate() + 1);
                    }
                } else if (strDate == ENDDATE) {
                    //     while (strDate==ENDDATE)
                    // {
                    var strDate = dateMove.toISOString().slice(0, 10);
                    listDate.push(strDate);
                    dateMove.setDate(dateMove.getDate());
                    //}
                }

                var holiday = holiday_range;
                var sunSAT = sun_sat_range;
                //////console.log(holiday.length);
                //////console.log(sunSAT);
                //////console.log(listDate);

                var count = 0;
                var countt = 0;
                //          //////console.log(holiday);
                // //////console.log(sunSAT);
                //        //////console.log(listDate);

                if (sunSAT != 0) {


                    for (var j = 0; j < listDate.length; j++) {
                        var p = sunSAT.includes(listDate[j]);
                        //////console.log(p);
                        if (p == true) {
                            //   countt=1;
                            countt++;
                        }
                        // else
                        // {
                        //       countt=0;
                        // }
                    }


                    //////console.log("sunsat is :" + countt);
                    //////console.log("holiday is :" + count);
                    //////console.log("listdate is :" + listDate.length);
                    var total = listDate.length - count - countt;
                    //////console.log("total is :" + total);


                } else {
                    var total = listDate.length;

                }

                $('#leave_count_edit_admin').val(total);
            }
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // //apply leave section
        var date_picker_holiday_list = '<?php echo   $date_picker_holiday_list; ?>';

        let holiday_data = JSON.parse(date_picker_holiday_list);
 ////console.log(holiday_data);
        var only_sat_sun = '<?php  echo $only_sat_sun; ?>';
        let only_sat_sun2 = JSON.parse(only_sat_sun);



        var datepicker_working_list = '<?php  echo $datepicker_working_list; ?>';
        let datepicker_working_list_data = JSON.parse(datepicker_working_list);

    // //console.log(datepicker_working_list_data);



        if (holiday_data != null && datepicker_working_list_data != null) {
         //alert("y1");
            test();
        } else if (holiday_data == null && datepicker_working_list_data != null) {
           //alert("n1");
            test2();
        } else if (holiday_data != null && datepicker_working_list_data == null) {
             //alert("m1");
            test3();
        } else {
           //alert("41");
            test4();
        }




        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Counting leave count for user edit popup

        if (holiday_data != null && datepicker_working_list_data != null) {
              //  alert("y2");
            user_test();
        } else if (holiday_data == null && datepicker_working_list_data != null) {
              //   alert("n2");
            user_test2();
        } else if (holiday_data != null && datepicker_working_list_data == null) {
                 // alert("m2");
            user_test3();
        } else {
             //alert("42");
            user_test4();
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //Counting leave count for admin edit popup
        if (holiday_data != null && datepicker_working_list_data != null) {
            //alert("y3");
            admin_test();
        } else if (holiday_data == null && datepicker_working_list_data != null) {
                // alert("n3");
            admin_test2();
        } else if (holiday_data != null && datepicker_working_list_data == null) {
                // alert("m3");
            admin_test3();
        } else {
                 //    alert("43");
            admin_test4();
        }
//////////////////////////////////////////////////////////////////////////////////////////////
$("body").on('change','#leave_select',function(){
            var leaveType_val = $(this).find(':selected').val();
            if(leaveType_val==2)
            {
                 $(".doc_note").hide();
                $("#leave_count").removeAttr("data-final");
                $("#date1,#date2,#leave_count,#reason").val("");
                $("#myFile").val(null);

//$("#fromHalf:selected").prop("selected", false);

                $('#fromHalf>option:eq(0)').attr('selected', true);
                $('#toHalf>option:eq(0)').attr('selected', true);

                $('#fromHalf>option:eq(1)').prop("selected", false);
                $('#toHalf>option:eq(1)').prop("selected", false);

                $('#fromHalf>option:eq(2)').prop("selected", false);
                $('#toHalf>option:eq(2)').prop("selected", false);


                $(".four").show();
            }
            else if(leaveType_val==3 || leaveType_val==4) 
            {
                        $(".doc_note").show();
                        $("#leave_count").removeAttr("data-final");
                        $("#date2,#date1,#leave_count,#reason").val("");
                        $("#myFile").val(null);



                        $('#fromHalf>option:eq(0)').attr('selected', true);
                        $('#toHalf>option:eq(0)').attr('selected', true);

                        $('#fromHalf>option:eq(1)').prop("selected", false);
                        $('#toHalf>option:eq(1)').prop("selected", false);

                        $('#fromHalf>option:eq(2)').prop("selected", false);
                        $('#toHalf>option:eq(2)').prop("selected", false);


                        $(".four").hide();   
            }
            else
            {   

                 $(".doc_note").hide();
                 $("#leave_count").removeAttr("data-final");
                 $("#date2,#date1,#leave_count,#reason").val("");
                 $("#myFile").val(null);



                 $('#fromHalf>option:eq(0)').attr('selected', true);
                $('#toHalf>option:eq(0)').attr('selected', true);

                $('#fromHalf>option:eq(1)').prop("selected", false);
                $('#toHalf>option:eq(1)').prop("selected", false);

                $('#fromHalf>option:eq(2)').prop("selected", false);
                $('#toHalf>option:eq(2)').prop("selected", false);

           
             $(".four").hide();  
            }

});
//////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // AJAX For User Apply Leave Function

        $('.loader').hide();
        $('.toHalf').hide();
        $('.four').hide();
         $(".doc_note").hide();
        $('body').on('click', '#apply', function(e) {
            e.preventDefault();

            var leaveType = $('#leave_select').find(':selected').html();
            var fromDate = $("input[name='date1']").val();
            var toDate = $("input[name='date2']").val();
            var leaveCount = $("input[name='leave_count']").val();
            var reason = $("input[name='reason']").val();
            var photo = $("input[name='filename']")[0].files[0];
            var user_id = $('#user_id').val();
            var fromtype=$("#fromHalf").val();
            var totype=$("#toHalf").val();
           //console.log(fromDate);
             var full_causaul_total=(($(".leave_2").html()).split("(")[1]).split(')')[0];
             var half_causaul_total=(($(".leave_2").html()).substr(27)).split(")")[0];
            
            var joindate=$(".joindate").text();
             //////console.log(joindate);
            const joindate_array = joindate.split(" ")[3];
            var full_causaul_leave="";
            var half_causaul_leave="";
           
            if(fromtype==1 && totype==1)
            {
                 var full_causaul_leave=leaveCount;
                 var half_causaul_leave=0;
            }
            else if((fromtype==2 || fromtype==3) && (totype==3 || totype==2))
            {
              var full_causaul_leave=leaveCount-1;
              var half_causaul_leave=2;   
              
            }
            else if(((fromtype==2 || fromtype==3) && totype==1) || ((totype==3 || totype==2) && fromtype==1))
            {
              var full_causaul_leave=leaveCount-0.5;
             var half_causaul_leave=1;   
            }
             //////////////////////////////
            if ($("#leave_select option:selected").index() == 0) {
                alert('Please select leave type');
                return false;
            }

            if (fromDate == "") {
                alert('Please enter start date');
                return false;
            }
            if (toDate == "") {
                alert('Please enter end date');
                return false;
            }

            if (leaveCount <= 0) {
                alert('Please enter the proper date range');
                return false;
            }

            if ($("#myFile").val() != "") {
                var str = photo.name;
                var a = str.split(".");
                var last = a[a.length - 1];
                var ext = ["jpg", "jpeg", "png", "gif"];
                var status = ext.includes(last);
                if (status == true) {
                    // return false;
                } else if (status == false) {
                    alert("Image should be jpg, jpeg, png, gif file");
                    return false;
                }
            }


 if ($("#leave_select option:selected").index() == 1) {
var v_cnt=$(".leave_1").html();
//////console.log(v_cnt+"==="+leaveCount);
if(parseInt(v_cnt)==0 || parseInt(leaveCount>v_cnt))
{
    alert("You do not have vacation leave");
    return false;
}
 }
  else if($("#leave_select option:selected").index() == 3)
 {
 var v_cnt=$(".leave_3").html();
           
            if(parseInt(v_cnt)==0 || leaveCount>parseInt(v_cnt))
            {

                alert("You do not have Sick leave");
                return false;
            } 

 }
  else if($("#leave_select option:selected").index() == 4)
 {
 var v_cnt=$(".leave_4").html();
if(parseInt(v_cnt)==0)
{
    alert("You do not have Maternity leave");
    return false;
}   
 }
  else if($("#leave_select option:selected").index() == 5)
 {
 var v_cnt=$(".leave_5").html();
 //console.log(v_cnt);
 //console.log(leaveCount);
if(parseInt(v_cnt)==0 || leaveCount>parseInt(v_cnt))
{
    alert("You do not have Unpaid leave");
    return false;
}   
 }







            if ($("#leave_select option:selected").index() == 1) {
                var today = new Date();
                var month = ["01", "02", "03", "04", "05", "06","07", "08", "09", "10", "11", "12"][today.getMonth()];
                var date = month +'/'+today.getDate()+'/'+today.getFullYear();
              //      //////console.log(date)
                var start = new Date(fromDate);
                var end = new Date(date);

                var diffDate = (start - end) / (1000 * 60 * 60 * 24);
                var days = Math.round(diffDate);    
                //////console.log("dfd",leaveCount,days);

                    var jan_from=fromDate.split('/')[0];

                     if(leaveCount>0 && leaveCount<=2 && days<7 && jan_from!="01"){
                    alert("Your Leave cannot be applied. For taking vacation leave one or two leave, You have to notice it 7days before OR Please apply through unpaid leave");
                    return false;

                  }
                  else if (leaveCount>2 && leaveCount<=5 && days<10 && jan_from!="01"){
                    alert("Your Leave cannot be applied. For taking  vacation leave three or four leave or five, You have to notice it 10 days before OR Please apply through unpaid leave");
                    return false;

                  }
                      else if (leaveCount>5 && days<21 && jan_from!="01"){
                    alert("Your Leave cannot be applied. For taking vacation leave more than five, You have to notice it 21 days before OR Please apply through unpaid leave");
                    return false;

                  }
            }
            else if($("#leave_select option:selected").index() == 2)
            {

                    var full_cau_chk=full_causaul_total-full_causaul_leave;
                    var half_cau_chk=half_causaul_total-half_causaul_leave;
                    //////console.log(full_cau_chk,half_cau_chk);
                    if(full_cau_chk<0 || half_cau_chk<0){     

                    alert("Your Causual Leave cannot be applied. You do not have balance leave OR Please apply through unpaid leaves");
                    return false;
                        }
            }
            else if($("#leave_select option:selected").index() == 3)
            {
                //////console.log(leaveCount,"dfdf");
                if(leaveCount>=2 && $("#myFile").val()==""){
                    alert("Your Leave cannot be applied. For taking Sick leave more than two days or more than that, You have to upload Doctor's Note OR Please apply through unpaid leaves");
                    return false;
                  }

                  
                  if(leaveCount==1  && $("#myFile").val()=="")
                  { 
                  const d = new Date(fromDate);
                  let day=d.getDay();
                  if(day==5 || day==1)
                  {  
                    alert("Your Leave cannot be applied. For taking Sick leave on Friday or Monday, You have to upload Doctor's Note");
                    return false;
                    }
                  }

            }
             else if($("#leave_select option:selected").index() == 4)
            {   
                
                if(leaveCount>182){
                    alert("You cannot take Maternity leave more than 182 days  and if you want to take then please apply the remaining leave through  unpaid leaves");
                    return false;

                  }
                  else if(leaveCount<= 182 && $("#myFile").val()=="")
                  {
                    alert("Please upload Doctor's Note");
                            return false;
                  }

            }




            //FormData
            var formData = new FormData();
            formData.append('leaveType', leaveType);
            formData.append('fromDate', fromDate);
            formData.append('toDate', toDate);
            formData.append('leaveCount', leaveCount);
            formData.append('fromType', fromtype);
            formData.append('toType', totype);
            formData.append('reason', reason);
            formData.append('photo', photo);
            formData.append('full_causaul_leave', full_causaul_leave);
            formData.append('half_causaul_leave', half_causaul_leave);

           formData.append('user_id', user_id);

            //Loading effect
            $('body').css('opacity', '0.5');
            $('.loader').show();

            $.ajax({
                type: 'post',
                url: 'api.php?api=apply_leave',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                //console.log(data);
               
                    if(data=="You have Already applied a leave for this dates")
                    {
                        alert("You have Already applied a leave for this dates");
                    }
                    else if(data=="note")
                    {
                        alert("You have to apply Doctor's Note to apply the sick leave");
                     }
                       location.reload();
                    $(".success-msg").css("z-index", "unset");
                    $(".successfully-saved").css("display", "block").delay(1000);

                },
                error: function(data) {
                    //console.log(data);
                location.reload();
                    alert(
                        "An error has occcured while applying leave. Please try again"
                    );
                }
            });

        });




        //Reset button
 $('body').on('click', '#reset', function() {
            $('#leave_select').val(0);
            $("input[name='date1']").val('');
            $("input[name='date2']").val('');
            $("input[name='leave_count']").val('');
            $("input[name='reason']").val('');
            $("input[name='filename']").replaceWith($("input[name='filename']").val('').clone(
                true));
        });


        // // AJAX for listing the user leave history
        var user_id = $('#user_id').val();
        var formData = new FormData();
      //  alert(user_id);
        formData.append('user_id', user_id);

        $.ajax({
            type: 'post',
            url: 'api.php?api=user_lv_history',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
             //////console.log(res);
                let data = JSON.parse(res);
             
                if (data != null) {
                    var count = '1';
                    for (var i = 0; i < data.length; i++) {
                        var a = data[i].final_status;
                        var b = data[i].final_status;
                        var c = data[i].final_approved_date;
                                      $('.user-history-body').append(`
                                                <tr class='table-data' data-id=` + data[i].id + ` data-user-id=` + data[i].user_id + ` full_causaul_leave=` + data[i].full_causaul_leave + ` half_causaul_leave=` + data[i].half_causaul_leave + ` >
                                                <td>` + count + `</td>
                                                <td>` + data[i].Req_date + `</td>
                                                <td class='type'>` + data[i].leave_type + `</td>
                                                <td>` + data[i].from + `</td>
                                                <td>` + data[i].to + `</td>
                                                <td class='count'>` + data[i].count + `</td>
                                                <td>` + data[i].reason + `</td>
                                                <td class='status'>` + data[i].final_status + `</td>
                                                <td>` + (c == "null" ? `` : c) + `</td>
                                                <td>` + (b == 'Pending' ?
                                '<i class="fa fa-pencil-alt user-pencil"></i>' : '') + `</td>
                                                <td>` + (a == 'Denied' ? '' : '<i class="fa fa-times user-cross"></i>') + `</td>
                                         </tr>
                                     `);
                        count++;
                    }
                } else {
                    $('.user-history-body').append(`
                                   <tr>
                        <td><span>No Leave History</span></td>
                  </tr>
                         `);
                }
            },
            error: function(data) {
                alert(
                    "An error has occcured while listing user leave history. Please try again"
                );
            }
        });


        ///////////////////////////////////////////////////////////////////////////////////////////////
        //AJAX FOR FUNCTIONAL MANAGER APPROVE AND DENY
        $('body').on('click', '.approve', function() {
            var td = $(this).closest('.more-info').prev('.table-data');
            // var deduct = $(this).closest('.more-info').find('.deduct_select').find(':selected').html();
            var apply_id = $(td).attr('data-id');
            var user_id = $(td).attr('data-user-id');
            var fromtype_count = $(td).attr('data-fromtype');
            var totype_count = $(td).attr('data-totype');
            var login_id = $('#user_id').val();
            //    alert(apply_id);

            // var type = $('.type').text();
            var type = $(this).closest('.more-info').prev('.table-data').find('.type').text();
            //             var count = $('.count').text();
            // var count = $(this).closest('.more-info').prev('.table-data').find('.count').text();
            // alert(count);
            // //////console.log(count);
            var count = $(td).attr('data-count');
            //             var funct_status = $('.funct_status').text();
            var funct_status = "approved";
            //                var post_status = $('.post_status').text();
            var post_status = "approved";

            $('body').css('opacity', '0.5');
            $('.loader').show();
            $.ajax({
                type: 'post',
                url: 'api.php?api=approved_status',
                data: {
                    apply_id: apply_id,
                    login_id: login_id,
                    user_id: user_id,
                    type: type,
                    count: count,
                    funct_status: funct_status,
                    post_status: post_status,
                    fromType:fromtype_count,
                    toType:totype_count
                    // deduct:deduct
                },
                success: function(data) {
                   alert(data);
                   // //////console.log(data);
                    $('.grid-row-1').load('admin-leave-history.php');
                    // $('.grid-row-2').load('user-calendar.php');
                    // $('.grid-row-2').load('user-calendar.php');
                    $('.grid-row-2').load('admin-calendar.php');
                    $('.grid-row-2').load('admin-calendar.php');
                    $('body').css('opacity', '');
                    $('.loader').hide();
                },
                error: function(data) {
                    alert(
                        "An error has occcured while approving. Please try again"
                    );
                }
            });
        });


        // Ajax for admin deny function.
        $('body').on('click', '.deny', function() {
            // alert("no");
            var td = $(this).closest('.more-info').prev('.table-data');
            // var deduct = $(this).closest('.more-info').find('.deduct_select').find(':selected').html();
            var apply_id = $(td).attr('data-id');
            var user_id = $(td).attr('data-user-id');
            var fromtype_count = $(td).attr('data-fromtype');
            var totype_count = $(td).attr('data-totype');
            var login_id = $('#user_id').val();
            //        var type = $('.type').text();
            var type = $(this).closest('.more-info').prev('.table-data').find('.type').text();

            // var count = $(this).closest('.more-info').prev('.table-data').find('.count').text();
            var count = $(td).attr('data-count');

            // var funct_status = $('.funct_status').text();
            // var post_status = $('.post_status').text();
            var funct_status = "denied";
            var post_status = "denied";

            //alert(type);
            // alert(user_id);
            // alert(login_id);
            //alert(type);
            //   alert(count);
            // alert(funct_status);
            // alert(post_status);

             $('body').css('opacity', '0.5');
            $('.loader').show();
            $.ajax({
                type: 'post',
                url: 'api.php?api=denied_status',
                data: {
                    apply_id: apply_id,
                    login_id: login_id,
                    user_id: user_id,
                    type: type,
                    count: count,
                    funct_status: funct_status,
                    post_status: post_status,
                    fromType:fromtype_count,
                    toType:totype_count
                    // deduct:deduct
                },
                success: function(data) {
                    alert(data);
                 //  //////console.log(data);
                    $('.grid-row-1').load('admin-leave-history.php');
                    $('.grid-row-2').load('admin-calendar.php');
                    $('.grid-row-2').load('admin-calendar.php');
                      $('body').css('opacity', '');
                    $('.loader').hide();
                },
                error: function(data) {
                    alert(
                        "An error has occcured while approving. Please try again"
                    );
                }
            });
        });



        // Popup for adding holiday list for admin section
        $('body').on('click', '.add-holiday', function() {
            $(".notes-overlay, .notes-content").addClass("active");
            $(".panel").css({
                "pointer-events": "none",
                "user-select": "none",
                "filter": "brightness(25%)"
            });
        });
        $("body").on("click", ".close", function() {
            $(".notes-overlay, .notes-content").removeClass("active");
            $(".panel").css({
                "pointer-events": "unset",
                "user-select": "unset",
                "filter": "unset"
            });
        });

        // Popup for adding working day list for admin section
        $('body').on('click', '.add-working', function() {
            $(".notes1-overlay, .notes1-content").addClass("active");
            $(".panel").css({
                "pointer-events": "none",
                "user-select": "none",
                "filter": "brightness(25%)"
            });
        });
        $("body").on("click", ".close1", function() {
            $(".notes1-overlay, .notes1-content").removeClass("active");
            $(".panel").css({
                "pointer-events": "unset",
                "user-select": "unset",
                "filter": "unset"
            });
        });






        //Popup for editing user leave section


 $('body').on('click', '.user-pencil', function() {

            var del = $(this);
            var apply_id = $(del).closest('.table-data').attr('data-id');
            var user_id = $(del).closest('.table-data').attr('data-user-id');
            // alert(apply_id);
            // alert(user_id);

            $.ajax({
                type: 'post',
                url: 'api.php?api=edit_box',
                data: {
                    user_id: user_id,
                    apply_id: apply_id
                },
                success: function(data2) {




                    $(".notes-overlay-edit1").html(data2).addClass("active");

                    $(function() {
                        $("#date1-edit-user").datepicker();
                    });

                    $(function() {
                        $("#date2-edit-user").datepicker();
                    });



                    if (holiday_data != null && datepicker_working_list_data != null) {
                        //        alert("y");
                        user_test();
                    } else if (holiday_data == null && datepicker_working_list_data !=
                        null) {
                        //        alert("n");
                        user_test2();
                    } else if (holiday_data != null && datepicker_working_list_data ==
                        null) {
                        //        alert("n");
                        user_test3();
                    } else {
                                //   alert("run");
                        user_test4();
                    }



                },
                error: function(data) {
                    alert(
                        "An error has occcured while editing user leave. Please try again"
                    );
                }
            });

        });




        $("body").on("click", ".close-edit-user", function() {
            $(".notes-overlay-edit1, .notes-content-edit1").removeClass("active");
            // $(".grid-container").css({
            //     "pointer-events": "unset",
            //     "user-select": "unset",
            //     "filter": "unset"
            // });
        });





        // Popup for editing admin leave section
        $('body').on('click', '.admin-pencil', function() {
            $(".notes-overlay-edit2, .notes-content-edit2").addClass("active");
            // $(".grid-container").css({
            //     "pointer-events": "none",
            //     "user-select": "none",
            //     "filter": "brightness(25%)"
            // });
            var del = $(this);
            var apply_id = $(del).closest('.table-data').attr('data-id');
            var user_id = $(del).closest('.table-data').attr('data-user-id');
            $.ajax({
                type: 'post',
                url: 'api.php?api=edit_box',
                data: {
                    user_id: user_id,
                    apply_id: apply_id
                },
                success: function(data) {

                    if($('#ui-datepicker-div')){
                        $('#ui-datepicker-div').remove();
                        $("#datepicker").removeClass("hasDatepicker");
                    }

                    $(".notes-overlay-edit1").html(data).addClass("active");

                    $(function() {
                        $("#date1-edit-user").datepicker();
                    });
                    $(function() {
                        $("#date2-edit-user").datepicker();
                    });


                    if (holiday_data != null && datepicker_working_list_data != null) {
                        //        alert("y");
                        user_test();
                    } else if (holiday_data == null && datepicker_working_list_data !=
                        null) {
                        //        alert("n");
                        user_test2();
                    } else if (holiday_data != null && datepicker_working_list_data ==
                        null) {
                        //        alert("n");
                        user_test3();
                    } else {
                        //         alert("4");
                        user_test4();
                    }


                    //////////////////////////////////////////////////////////////////////////////////


                    ///////////////////////////////////////////////////////////////////////////////////////////////
                },
                error: function(data) {
                    alert(
                        "An error has occcured while editing user leave. Please try again"
                    );
                }
            });

        });




        $("body").on("click", ".close-edit-admin", function() {
            $(".notes-overlay-edit2, .notes-content-edit2").removeClass("active");
            // $(".grid-container").css({
            //     "pointer-events": "unset",
            //     "user-select": "unset",
            //     "filter": "unset"
            // });
        });

        //Ajax for adding holiday list
        $('body').on('click', '.submit-holiday', function() {
            //  e.preventDefault();


            var holiday_day = $("input[name='day']").val();
            var holiday_date = $("input[name='date3']").val();
            var holiday_title = $("input[name='holiday']").val();

            // //////console.log(holiday_day);
            // //////console.log(holiday_date);
            // //////console.log(holiday_title);

            //FormData
            var formData = new FormData();
            formData.append('holiday_day', holiday_day);
            formData.append('holiday_date', holiday_date);
            formData.append('holiday_title', holiday_title);

            $.ajax({
                type: 'post',
                url: 'api.php?api=insert_holiday',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if($('#ui-datepicker-div')){
                        $('#ui-datepicker-div').remove();
                        $("#date3").removeClass("hasDatepicker");
                        $("#date4").removeClass("hasDatepicker");
                    }
                    $("#date3").datepicker();
                    $("#date4").datepicker();
                    if(data == 'Cannot create duplicate dates'){
                        alert("Cannot create duplicate dates");
                        return;
                    }else{
                        $(".holiday-table-body").load("admin-section.php" +
                            " .holiday-table-body");
                        $('.grid-row-1').load('admin-leave-history.php');
                        $('.grid-row-2').load('user-calendar.php');
                    }

                },
                error: function(data) {
                    alert(
                        "An error has occcured while adding holiday. Please try again"
                    );
                }
            });

            $("input[name='day']").val('');
            $("input[name='date3']").val('');
            $("input[name='holiday']").val('');
            $(".notes-overlay, .notes-content").removeClass("active");
            $(".success-msg").css("z-index", "unset");
            $(".successfully-saved").css("display", "block").delay(1000)
                .fadeOut(400);


        });





        //Ajax for adding working day list


$('body').on('click', '.submit-working', function(e) {
            e.preventDefault();

            var working_day = $("input[name='day1']").val();
            var working_date = $("input[name='date4']").val();
            var working_title = $("input[name='working']").val();

            //  //////console.log(working_day);
            ////////console.log(working_date);
            // //////console.log(working_title);

            //FormData
            var formData = new FormData();
            formData.append('working_day', working_day);
            formData.append('working_date', working_date);
            formData.append('working_title', working_title);

            $.ajax({
                type: 'post',
                url: 'api.php?api=insert_Workinglist',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
$('.admin-title').click();
                if($('#ui-datepicker-div')){
                    $('#ui-datepicker-div').remove();
                    $("#date3").removeClass("hasDatepicker");
                    $("#date4").removeClass("hasDatepicker");
                }
                $("#date3").datepicker();
                $("#date4").datepicker();
                if(data == 'This date is already in working_list'){
                    alert(data);
                    return;
                }else{
                    ////////console.log(data);
                    alert(data);
                    $(".working-table-body").load("admin-section.php" + " .working-table-body");
                    $('.grid-row-2').load('admin-calendar.php');
                }
        //});
                },
                error: function(data) {
                    alert(
                        "An error has occcured while adding holiday. Please try again"
                    );
                }
            });

            $("input[name='day1']").val('');
            $("input[name='date4']").val('');
            $("input[name='working']").val('');
            $(".notes1-overlay, .notes1-content").removeClass("active");
            $(".success-msg").css("z-index", "unset");
            $(".successfully-saved").css("display", "block").delay(1000).fadeOut(400);
        });

        // Doctor note big image
        $("body").on("click", ".note-img img", function() {
            var $src = $(this).attr("src");
            $(".show").fadeIn();
            $(".img-show img").attr("src", $src);
        });

        $("span, .overlay").click(function() {
            $(".show").fadeOut();
        });



        // Submit ajax for edit user leave
//////////////////////////////////////////////////////////////////////////////////////////////
$("body").on('change','#leave_select',function(){
            var leaveType_val = $(this).find(':selected').val();
            if(leaveType_val==2)
            {
                $("#leave_count").removeAttr("data-final");
                $("#date1,#date2,#leave_count,#reason").val("");
                $("#myFile").val(null);

//$("#fromHalf:selected").prop("selected", false);

                $('#fromHalf>option:eq(0)').attr('selected', true);
                $('#toHalf>option:eq(0)').attr('selected', true);

                $('#fromHalf>option:eq(1)').prop("selected", false);
                $('#toHalf>option:eq(1)').prop("selected", false);

                $('#fromHalf>option:eq(2)').prop("selected", false);
                $('#toHalf>option:eq(2)').prop("selected", false);


                $(".four").show();
            }
            else
            {
                $("#leave_count").removeAttr("data-final");
                 $("#date2,#date1,#leave_count,#reason").val("");
                 $("#myFile").val(null);


//$("#fromHalf:selected").prop("selected", false)

                 $('#fromHalf>option:eq(0)').attr('selected', true);
                $('#toHalf>option:eq(0)').attr('selected', true);

                $('#fromHalf>option:eq(1)').prop("selected", false);
                $('#toHalf>option:eq(1)').prop("selected", false);

                $('#fromHalf>option:eq(2)').prop("selected", false);
                $('#toHalf>option:eq(2)').prop("selected", false);

           
             $(".four").hide();   
            }

});
//////////////////////////////////////////////////////////////////////////////////////////////////
$('body').on('click', '.edit-user', function() {
            //  $( "#user-history-body" ).load('user-leave-history.php' + " #user-history-body" );

            var main = $(this).parent('.edit-btn').prev('.notes-text-edit1');
            var user_id = $(main).find("input[name='edit-user-id']").val();
            var applyID = $(main).find("input[name='edit-user-apply-id']").val();
            var leaveType = $(main).find('#leave_select_edit_user').find(':selected').html();
            var fromDateEditUser = $(main).find("input[name='date1-edit-user']").val();
            var toDateEditUser = $(main).find("input[name='date2-edit-user']").val();
            var count = $(main).find("input[name='leave_count_edit_user']").val();
            var reasonEditUser = $(main).find("textarea[name='reason-edit-user']").val();
            var fromtype_edit=$(main).find('#fromHalf_user_edit').find(':selected').val();
            var totype_edit=$(main).find('#toHalf_user_edit').find(':selected').val();
            var full_causaul_total=$(main).find("input[name='edit-user-id']").attr("data-full_causaul_leave");
            var half_causaul_total=$(main).find("input[name='edit-user-id']").attr("data-half_causaul_leave");
            var vacation_total=$(main).find("input[name='edit-user-id']").attr("data-vacation");
            var sick_total=$(main).find("input[name='edit-user-id']").attr("data-sick");

            //////console.log(user_id+"=" +applyID+"="+leaveType+"="+fromDateEditUser+"=" +toDateEditUser+"="+count+"="+reasonEditUser+"=" +fromtype_edit+"="+totype_edit+"=" +full_causaul_total+"="+half_causaul_total+"=" +vacation_total+"=" +sick_total);

         
if(leaveType == "Vacation Leave") {
            if(vacation_total==0 || parseInt(count>vacation_total))
            {
                alert("You do not have vacation leave");
                return false;
            }
 }
else if(leaveType == "Sick Leave")
 {
            if(sick_total==0)
            {
                alert("You do not have Sick leave");
                return false;
            }
            else if(count>sick_total)
            {
             alert("You do not have Sick leave2");
                return false;   
            }   
 }

             if(fromtype_edit==1 && totype_edit==1)
            {
                var full_causaul_leave=count;
                var half_causaul_leave=0;
            }
            else if((fromtype_edit==2 || fromtype_edit==3) && (totype_edit==3 ||totype_edit==2))
            {
                var full_causaul_leave=count-1;
                var half_causaul_leave=2;   
            }
            else if(((fromtype_edit==2 || fromtype_edit==3) && totype_edit==1) || ((totype_edit==3 ||totype_edit==2) && fromtype_edit==1))
            {
                var full_causaul_leave=count-0.5;
                var half_causaul_leave=1;   
            }
         //////console.log(full_causaul_leave,half_causaul_leave,"ss"); 



                if (leaveType == "Vacation Leave") {
                var today = new Date();
                var month = ["01", "02", "03", "04", "05", "06","07", "08", "09", "10", "11", "12"][today.getMonth()];
                var date = month +'/'+today.getDate()+'/'+today.getFullYear();
              //      //////console.log(date)
                var start = new Date(fromDateEditUser);
                var end = new Date(date);

                var diffDate = (start - end) / (1000 * 60 * 60 * 24);
                var days = Math.round(diffDate);    
                //////console.log("dfd",count,days);

                    var jan_from=fromDateEditUser.split('/')[0];

                  if (count>1 && count<=2 && days<7 && jan_from!="01" ){
                    alert("Your Leave cannot be applied. For taking vacation leave one or two leave, You have to notice it 7days before OR Please apply through unpaid leave");
                    return false;
                  }
                  else if (count>2 && count<=5 && days<10 && jan_from!="01"){
                    alert("Your Leave cannot be applied. For taking  vacation leave three or four leave or five, You have to notice it 10 days before OR Please apply through unpaid leave");
                    return false;
                  }
                      else if (count>5 && days<21 && jan_from!="01"){
                    alert("Your Leave cannot be applied. For taking vacation leave more than five, You have to notice it 21 days before OR Please apply through unpaid leave");
                    return false;
                  }
            }
            else if (leaveType == "Casual Leave") {
            
               
                    var full_cau_chk=full_causaul_total-full_causaul_leave;
                    var half_cau_chk=half_causaul_total-half_causaul_leave;
                    //////console.log(full_cau_chk,half_cau_chk,"reun");  
                    if(full_cau_chk<0 || half_cau_chk<0){     
                    alert("Your Causual Leave cannot be applied. You do not have balance leave OR Please apply through unpaid leaves");
                    return false;
                        }
            }
            // else if (leaveType == "Sick Leave") {
        
            //     //////console.log(count,"dfdf");
            //     if(count>=2 && $("#myFile").val()==""){
            //         alert("Your Leave cannot be applied. For taking Sick leave more than two days or more than that, You have to upload Doctor's Note OR Please apply through unpaid leaves");
            //         return false;

            //       }
            // }
            else  if (leaveType == "Maternity Leave") {
            
                
                if(count>182){
                    alert("You cannot take Maternity leave more than 182 days  and if you want to take then please apply the remaining leave through  unpaid leaves");
                    return false;

                  }
                  // else if(count<= 182 && $("#myFile").val()=="")
                  // {
                  //   alert("Please upload Doctor's Note");
                  //           return false;
                  //}

            }
            //  //////console.log(full_causaul_leave+"=" +half_causaul_leave);
            //   alert(main);
            // alert(user_id);
            // alert(applyID);
            // alert(leaveType);
            // alert(fromDateEditUser);
            // alert(toDateEditUser);
            // alert(count);
            // alert(reasonEditUser);
            //FormData
            var formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('applyID', applyID);
            formData.append('leaveType', leaveType);
            formData.append('fromDateEditUser', fromDateEditUser);
            formData.append('toDateEditUser', toDateEditUser);
            formData.append('leaveCount', count);
            formData.append('reasonEditUser', reasonEditUser);
            formData.append('fromType', fromtype_edit);
            formData.append('toType', totype_edit);
            formData.append('full_causaul_leave', full_causaul_leave);
            formData.append('half_causaul_leave', half_causaul_leave);
            $.ajax({
                type: 'post',
                url: 'api.php?api=edit',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
               //////console.log(data);
                 location.reload();

                },
                error: function(data) {
                    alert(
                        "An error has occcured while editing user leave. Please try again"
                    );
                }
            });
            //$(".grid-container").load("leave-management.php" + " .grid-container");
            // $(".user-history-body").load("user-leave-history.php" + " .user-history-body");
            // $('.grid-row-1').load('user-leave-history.php');
            $(".notes-overlay-edit1, .notes-content-edit1").removeClass("active");
            $(".success-msg").css("z-index", "unset");
            $(".successfully-edited").css("display", "block").delay(1000)
                .fadeOut(400);
            // window.location.reload();
            //  $(".admin-history-body").load("admin-leave-history.php" + " .admin-history-body");
            //  $(".user-history-body").load("user-leave-history.php" + " .user-history-body");
            // $('.grid-row-1').load('user-leave-history.php');
            // $('.grid-row-1').load('user-leave-history.php' + " .user-history-body");

            //           window.location.reload();
        });





// ---------select user name and dates ajax (by shabnam)-----------

// submit button ajax by admin
$('#selButton').click(function(){
    var name = document.getElementById('sel-name').value
    var startDate = document.getElementById('start-Date').value
    var endDate = document.getElementById('end-Date').value
    var user_id = $('#user_id').val();

if (name =='0') {
          alert(" Please Select the Employee Name");
            return(false);
        }


     if (startDate == '') {
          alert(" Please Select the Start Date");
            return(false);
        }


     if (endDate == '') {
          alert(" Please Select the End Date");
            return(false);
        }


    if(endDate <= startDate){
          alert("'End Date should be greater than equal to Start Date.'");
            return false;
        }




    //////console.log(startDate, endDate, name,user_id);
     $.ajax({
      url: 'api.php?api=admin_select_his',
        type: "POST",
        data: {
            name_id: name,
            stime : startDate,
            etime: endDate,
            user_id:user_id
        },
        success: function(res) {
               console.log(res);
          //  //////console.log(res);
             $("#admin-history-body-table").empty();
 if ( res != ""){

            let data = JSON.parse(res);
    
                var count = '1';
                for (var i = 0; i < data.length; i++) {
                    var html = "";
                    html ="<tr class='table-data' data-id='"+data[i].id +"' data-user-id='"+data[i].user_id +"' data-count='"+data[i].count +"'><td class=customerIDCellt>" + count + "</td><td class='emp-data'>" + data[i].name + "&nbsp;<i class='fas fa-chevron-down'></i></td><td class=customerIDCellt>" + data[i].from + "</td><td class=customerIDCellt>" + data[i].to + "</td><td class=customerIDCellt>" + data[i].Req_date + "</td><td class='type'>" + data[i].leave_type + "</td><td class='funct_status'>" + data[i].funct_status + "</td><td class='post_status'>" + data[i].post_status + "</td><td class=customerIDCellt>";

                    if(data[i].funct_status=='pending' && data[i].post_status=='pending')
                    {
                       var mail="<i class='fa fa-pencil-alt admin-pencil'></i>";
                    }
                    else
                    {
                        var mail="";
                    }
                    mail=mail+"</td><td>";


                    if(data[i].funct_status=='pending' && data[i].post_status=='pending')
                    {
                       var mail2="<i class='fa fa-times admin-cross'></i>";
                    }
                    else
                    {
                        var mail2="";
                    }
                    mail2=mail2+"</td></tr>";

                    var next="<tr class='more-info'><td colspan='14'><div class='more-info-grid'><div class='info-1'><p>"+data[i].name+"</p><br><p>DOCTOR'S NOTE</p><br><p class='note-img'>";
                    if(data[i].image!=null)
                    {
                       var next2="<img src="+data[i].image+" alt='small_img'></p></div><div class='info-2'><p>"+data[i].leave_type+"</p><br>";
                    }
                    else
                    {
                       var next2="<img src='images/noimage.jpeg' alt='small_img'></p></div><div class='info-2'><p>"+data[i].leave_type+"</p><br>";
                    }
                    next=next+next2;

                      var today = new Date();
                      var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();

                      var from_date = new Date(data[i].from);
                      var from_today = from_date.getFullYear()+'-'+(from_date.getMonth()+1)+'-'+from_date.getDate();
                      if(date>from_today)
                      {
                        var next3="<div class='leave-button' style='opacity:0.2;'><button>Approve</button><button>Deny</button><button>Cancel</button></div>";
                      }
                      else
                      {
                        var next3="<div class='leave-button'><button name='approve' type='submit' class='approve'>Approve</button><button name='deny' type='submit' class='deny'>Deny</button><button name='cancel' type='submit' class='cancel'>Cancel</button></div>";
                      }

                    next=next+next3;


                    var end="</div></div></td></tr>";
                 html=html+mail+mail2+next+end;

                    count++
                    $('#admin-history-body-table').append(html);
                }


              }
              else
              {
                var html="<tr><td class=customerIDCellt><span>No Leave History</span></td></tr>";
                              $('#admin-history-body-table').append(html);

              }
    }
    });
});



// submit button ajax by user
$('#usrButton').click(function(){
     var startDate = document.getElementById('start-Date').value
     var endDate = document.getElementById('end-Date').value
     var user_id = $('#user_id').val();


  if (startDate == '') {
          alert(" Please Select the Start Date")
            return(false);
        }

     if (endDate == '') {
          alert(" Please Select the End Date")
            return(false);
        }

    if(endDate <= startDate)
        {
          alert("'End Date should be greater than equal to Start Date.'");
            return false;
        }

     //////console.log(startDate, endDate, user_id);
      $.ajax({
       url: 'api.php?api=get_his_user_dates',
         type: "POST",
         data: {
             stime : startDate,
             etime: endDate,
             user_id:user_id
         },
         success: function(res) {
            // //////console.log(res);
               $(".user-history-body").empty();

                 if (res != '') {
                     let data = JSON.parse(res);
               //    //////console.log(data);
                     var count = '1';
                     for (var i = 0; i < data.length; i++) {
                         var a = data[i].final_status;
                         var b = data[i].final_status;
                         var c = data[i].final_approved_date;
                                       $('.user-history-body').append(`
                                                 <tr class='table-data' data-id=` + data[i].id + ` data-user-id=` +
                            data[i].user_id + `>
                                                 <td>` + count + `</td>
                                                 <td>` + data[i].Req_date + `</td>
                                                 <td class='type'>` + data[i].leave_type + `</td>
                                                 <td>` + data[i].from + `</td>
                                                 <td>` + data[i].to + `</td>
                                                 <td class='count'>` + data[i].count + `</td>
                                                 <td>` + data[i].reason + `</td>
                                                 <td></td>
                                                 <td class='status'>` + data[i].final_status + `</td>
                                                 <td>` + (c == "null" ? `` : c) + `</td>
                                                 <td>` + (b == 'Pending' ?
                                 '<i class="fa fa-pencil-alt user-pencil"></i>' : '') + `</td>
                                                 <td>` + (a == 'Denied' ? '' : '<i class="fa fa-times user-cross"></i>') + `</td>
                                          </tr>
                                      `);
                         count++;
                     }
                 } else {
                     $('.user-history-body').append(`
                                    <tr>
                         <td><span>No Leave History</span></td>
                   </tr>
                          `);
                 }
             },
              error: function(data) {
                 alert(
                     "An error has occcured while listing user leave history. Please try again"
                 );
             }
         });
 });

///////////////////////////////////////////////////////////////////////////////////////////////////
// get user name from database

    $.ajax({
             url: "api.php?api=team_list",
            type: "GET",
            data: {},
            success: function(data) {
           //console.log(data);
              let data2 = JSON.parse(data);
               //////console.log(data2);
               // //////console.log(data2.data.length);
                  $("#sel-name").append('<option value="0">Select</option>');
                for (var i = 0; i < data2.data.length ; i++) {
                    $("#sel-name").append('<option value="' + data2.data[i].user_id + '">' + data2.data[i].name + '</option>');

                }
                //////console.log(data2.length);
            }
        });


    });
    </script>
</body>

</html>
