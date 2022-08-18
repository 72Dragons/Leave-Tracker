<?php 
// include 'login_db.php';
// include "api.php";
// echo "<pre>";
// print_r($_SESSION);
session_start();
// $date_picker_holiday_list=$obj->date_picker_holiday_list();
// $datepicker_working_list=$obj->datepicker_working_list();

// $only_sat_sun=$obj->only_sat_sun();
// $sat_sun=$obj->sat_sun();

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
    <link rel="stylesheet" href="css/main.css">
</head>

<style>
* {
    margin: 0 0 0 0;
    padding: 0 0 0 0;
    user-select: none;
}


.head {
    display: flex;
    justify-content: center;
    text-align: center;
    background-color: black;
    border-bottom: 0.5px solid #ae9440;
}

.head h1 {
    font-family: arial, sans-serif;
    color: #ae9440;
    padding: 15px 10px;
}

/* 
.select {
    margin: 2.5% 0 0 0;
    color: aqua;
    justify-content: center;
    display: flex;
}

.select label {
    color: #ae9440;
    margin: 0 5px 0 5px;
}

.select input {
    background-color: #ae9440;
    margin: 0 5px 0 5px;
    padding: 2px 2px;
    color: black;
    border: none;
    cursor: pointer;
}

.select select {
    background-color: #ae9440;
    color: black;
    border: none;
    cursor: pointer;
    width: 150px;
    text-align: center;
}

.select button {
    margin: 0 5px 0 5px;
    padding: 2px 2px;
    background-color: #ae9440;
    color: black;
    border: none;
    cursor: pointer;
} */

/* .table {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 2% 0 0 0;
    width:100%;
} */

.table {
    border: 1px solid #ae943f;
    width: 80%;
    margin: 2.5% 10% 0 10%;
    height: 450px;
    overflow: scroll;
    padding: 0 0 0 0;
}

.table::-webkit-scrollbar {
    width: 11px;
    height: 11px;
    background-color: black;
}

.table::-webkit-scrollbar-corner {
    background-color: black;
}

.table::-webkit-scrollbar-track {
    box-shadow: inset 0 0 3px black;
    background-color: #96031a;
}

.table::-webkit-scrollbar-thumb {
    background: #ad9440;
    border-radius: 18px;
}

.table::-webkit-scrollbar-thumb:hover {
    background: #c49f28;
    width: 9px;
}

table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    background-color: #ae943f;
    color: antiquewhite;
}

th {
    background-color: #96031a;
    color: #ae9940;
   /* font-family: "Times New Roman", Times, serif; */
}
td{
    color: black;
}
td,
th {
    border: 1px solid #14141533;
    text-align: center;
    padding: 8px;
}


/* media queries for the page */
@media (max-width:451px) and (min-width:350px) {
    .head h1{
        font-size:20px;
    }
    td,th{
        font-size:14px;
    }
}
/*  */
@media (max-width:350px) and (min-width:250px) {
    .head h1{
        font-size:17px;
    }
    td,th{
        font-size:12px;
    }
}
/*  */
@media (max-width:250px) and (min-width:180px) {
    .head h1{
        font-size:13px;
    }
    td,th{
        font-size:10px;
    }
}


</style>


<body>
    <!-- <div class="nav">
        <img src="\images\72dragonLogo_big.png" alt="">
    </div> -->
    <!-- thiis is the div for heading  -->
    <div class="head">
        <h1>Employee Attendance Page</h1>
    </div>
    <!-- admin selects dates and submit button -->
    <!-- div for the table so the details after submit can be shown -->
    <div class="table">

        <table>
            <tr>
                <th>Name</th>
            </tr>
            <!-- <tr>
                <td>Alfreds Futterkiste</td>
                <td>Maria Anders</td>
                <td>Germany</td>
            </tr>
            <tr>
                <td>Centro comercial Moctezuma</td>
                <td>Francisco Chang</td>
                <td>Mexico</td>
            </tr>
            <tr>
                <td>Ernst Handel</td>
                <td>Roland Mendel</td>
                <td>Austria</td>
            </tr>
            <tr>
                <td>Island Trading</td>
                <td>Helen Bennett</td>
                <td>UK</td>
            </tr>
            <tr>
                <td>Laughing Bacchus Winecellars</td>
                <td>Yoshi Tannamuri</td>
                <td>Canada</td>
            </tr>
            <tr>
                <td>Magazzini Alimentari Riuniti</td>
                <td>Giovanni Rovelli</td>
                <td>Italy</td>
            </tr> -->
            <tbody class="tbody">
                
            </tbody>
        </table>

    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$.ajax({
            url: 'api2.php?api=all_attdce',
            type: "GET",
            data: {},
            success: function(data) {
                    console.log(data)
                    let data2 = JSON.parse(data)
                   // console.log(data2)
                    //console.log(data2[0][1][1].name)
                    for (var i = 0; i < data2[0][1].length; i++){
                        $('.tbody').append(`
                            <tr data-id = ` +data2[0][1][i].memberID + `>
                            <td>` + data2[0][1][i].name + `</td>
                            </tr>
                        `)
                    }
        }
    })
</script>
