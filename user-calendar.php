<?php
include "api.php";
$obj=new api();
$datepickr_details=$obj->get_data();
$only_sat_sun=$obj->only_sat_sun();
//echo $datepickr_details;


   // include 'login_db.php';
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
<div class="new">
    <div id="datepicker"></div>
</div>



<div class="status-list">
    <div class="status-list-icon">
        <div class="status-icon today"></div>
        <p>Today</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon work"></div>
        <p>Working Day</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon half-day"></div>
        <p>Half Day</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon non-work"></div>
        <p>Non-Working Day</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon approve"></div>
        <p>Approved</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon deny"></div>
        <p>Denied</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon pending"></div>
        <p>Pending</p>
    </div>
    <div class="status-list-icon">
        <div class="status-icon merge"></div>
        <p>Merged Activities</p>
    </div>
</div>
<script>

// //console.log("heelo")
//



// $(document).ready(function(newdate) {
function test(newdata){
        var datepickr_details = '<?php  echo $datepickr_details; ?>';
      //  //console.log(datepickr_details);
        if(newdata != undefined){
            var datepickr_details = newdata;
            $("#datepicker").html("");
        }
        var only_sat_sun = '<?php  echo $only_sat_sun; ?>';
        // //console.log(datepickr_details);



        if (datepickr_details != 'null') {
            let data = JSON.parse(datepickr_details);
             ////console.log(data)
            let only_sat_sun2 = JSON.parse(only_sat_sun);
            //console.log(only_sat_sun2);

        // //console.log(only_sat_sun2)
             // //console.log(data);
            if($('#ui-datepicker-div')){
                $('#ui-datepicker-div').remove();
                $("#datepicker").removeClass("hasDatepicker");
                // //console.log(123)
            }
            $("#datepicker").datepicker({

                numberOfMonths: 2,
                // changeMonth:true,
                // changeYear:true,

                beforeShowDay: function(date) {
                    // // //console.log(1);

                    var month = date.getMonth()+1 ;
                    // var month = 6;

                    // //console.log("hello=" + month)
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;
                    // //console.log(newdate)

                    // Check date in Array


                    // //console.log(only_sat_sun2['sun']);

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }
////////////////////////////////////////
                    
////////////////////////////////////////

//console.log(data);
                    for (var i = 0; i < data.length; i++) {


                        // //console.log(typeof(range));
                        // //console.log(data[0].final_status);


                  if (data[i].statuss == 'Approved' && data[i].type=='2') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            // //console.log(range);
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_approved_firsthalf", tooltip_text];
                            }
                        }
                  else if (data[i].statuss == 'Approved' && data[i].type=='3') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            // //console.log(range);
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_approved_secondhalf", tooltip_text];
                            }
                        }
                  else if (data[i].statuss == 'Approved' && data[i].type=='1') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            // //console.log(range);
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_approved", tooltip_text];
                            }
                        }else if (data[i].statuss == 'Denied') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_denied", tooltip_text];
                            }
                        } else if (data[i].statuss == 'Pending') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_pending", tooltip_text];
                            }
                        } else if (data[i].statuss == 'holiday') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_holiday", tooltip_text];
                            }
                        } else if (data[i].statuss == 'Working') {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_workinglist", tooltip_text];
                            }
                        } else {
                            var range = [data[i].dates];
                            var tooltip_text = data[i].tooltips;
                            if ($.inArray(newdate, range) != -1) {
                                return [true, "highlight_comman", tooltip_text];
                            }
                        }


                    }




                    return [true];

                }

            });
        } else {
            ////console.log("yes");
            let only_sat_sun2 = JSON.parse(only_sat_sun);
            //  //console.log(only_sat_sun2['sun'].length);
            $("#datepicker").datepicker({
                numberOfMonths: 2,
                beforeShowDay: function(date) {
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var day = date.getDate();

                    // Change format of date
                    var newdate = day + "-" + month + '-' + year;

                    for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                        var s_range = [only_sat_sun2['sun'][j]];

                        // //console.log(s_range);
                        if ($.inArray(newdate, s_range) != -1) {
                            return [true, "sun_sat"];
                        }

                    }

                    return [true];

                }
            });

        }

    // });

};
test();
</script>
