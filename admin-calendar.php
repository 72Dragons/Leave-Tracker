<?php
include "api.php";
$obj=new api();
$datepickr_details=$obj->get_data();
$only_sat_sun=$obj->only_sat_sun();



//include 'login_db.php';
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
<div class="new1">
<!-- changes made by Ashish -->
    <div clas="newSelect" style="display:block; justify-content:center; text-align:center;margin:30px 0 0 0; ">
        <label for="Any" style="color:#ad9440; margin:0 5px 0 0;">Employee :</label>

        <select class='selectOptions' name="Any" id="selectOptions"
            style="color:#000000; background-color:#ad9440; border: 1px solid #ae943f; ">
            <option value="0">Select</option>
        </select>


    </div>


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

<!-- by Ashish -->
<style>
/* .new1 select{
  width: 140px;
} */
.new1 input {
    background-color: #ad9440;
    color: #000000;
    border: 1px solid #ae943f;
    margin: 13px 0px;
}

.ui-datepicker select.ui-datepicker-month,
.ui-datepicker select.ui-datepicker-year {
    width: 49%;
    background: #ae9440;
    border-style: none;
    color: black;
    text-align: center;
}
</style>
<!-- till here -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
// Ajax part done by the Ashish
$.ajax({
    type: 'GET',
    url: 'api.php?api=team_list',
    data: {},
    success: function(data) {
         //console.log(data);
        let data2 = JSON.parse(data);
        // //console.log(data2)
        for (var i = 0; i < data2.data.length; i++) {
            $('.selectOptions').append(
                `<option value="${data2['data'][i].user_id}">${data2['data'][i].name}</option>`)
        }
    }
});


$('#selectOptions').on('change', function() {
    // alert("something to alert")
    var name = $("#selectOptions option:selected").text();
 //   var startDate = document.getElementById('infinity').value;
 //   var endDate = document.getElementById('infinity1').value;
     //alert(name)
    // alert(startDate)
    // alert(endDate)
    // //console.log(name,startDate,endDate)
    if(name == 'Select'){
        alert('please select a name')
    }
// else if( startDate==''){
  //      alert("please select a start date")
   // }else if( endDate==''){
    //    alert("please select a end date")
   // }
    else{
        $.ajax({
        url: 'api.php?api=get_data',
        type: "POST",
        data: {
            name: name
        },
        success: function(data) {
            //alert("Submitted")
         //console.log(data);
         if(data=="null")
         {
            alert("no data");
  //          dataempty();
         }
         else
         {
                let data2 = JSON.parse(data)
                //console.log(data2);

                test(data)
                if (data2.length==0) {
                alert("NO data is available for this user");
                //test(data)
                }
           }


        }
    });
}
});
// till here by Ashish
//
function dataempty(){
//    alert("dataempty");
    if ($('#ui-datepicker-div')) {
            $('#ui-datepicker-div').remove();
            $("#datepicker").removeClass("hasDatepicker");
            // //console.log(123)
        }
    var only_sat_sun = '<?php  echo $only_sat_sun; ?>';
    let only_sat_sun2 = JSON.parse(only_sat_sun);
        //  //console.log(only_sat_sun2['sun'].length);
        $("#datepicker").datepicker({
            numberOfMonths: 2,
            changeMonth: true,
            changeYear: true,
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
    // });
}


// $(document).ready(function(newdate) {
function test(newdata) {
    //alert("new");
    // //console.log("helllllllo")
    // $(function(newdata) {
    // //console.log(newdata)
    // An array of highlighting dates ( 'dd-mm-yyyy' ) (can be added with dynamic values)
    var datepickr_details = '<?php  echo $datepickr_details; ?>';
    if (newdata != undefined) {
        var datepickr_details = newdata;
        ////console.log(datepickr_details);
        $("#datepicker").html("");
    }
    var only_sat_sun = '<?php  echo $only_sat_sun; ?>';
    // //console.log(datepickr_details);

    if (datepickr_details != 'null') {
        let data = JSON.parse(datepickr_details);
        // //console.log(data)
        let only_sat_sun2 = JSON.parse(only_sat_sun);
        // //console.log(only_sat_sun2)
        // //console.log(data);
        if ($('#ui-datepicker-div')) {
            $('#ui-datepicker-div').remove();
            $("#datepicker").removeClass("hasDatepicker");
            // //console.log(123)
        }
        $("#datepicker").datepicker({
            numberOfMonths: 2,
            changeMonth: true,
            changeYear: true,

            beforeShowDay: function(date) {

                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                var day = date.getDate();
                // Change format of date
                var newdate = day + "-" + month + '-' + year;

                // Check date in Array
                for (var j = 0; j < only_sat_sun2['sun'].length; j++) {
                    var s_range = [only_sat_sun2['sun'][j]];

                    if ($.inArray(newdate, s_range) != -1) {
                        return [true, "sun_sat"];
                    }

                }


//console.log(data);
                for (var i = 0; i < data.length; i++) {


                    // //console.log(typeof(range));
                    // //console.log(data[0].final_status);


                    // if (data[i].statuss == 'Approved') {
                    //     var range = [data[i].dates];
                    //     var tooltip_text = data[i].tooltips;
                    //     // //console.log(range);
                    //     if ($.inArray(newdate, range) != -1) {
                    //         return [true, "highlight_approved", tooltip_text];
                    //     }
                    // }
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
                        }
                     else if (data[i].statuss == 'Denied') {
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


};
test();
</script>
