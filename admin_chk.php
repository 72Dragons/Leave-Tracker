	<!DOCTYPE html>
	<html lang="en">

	<head>
	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=], initial-scale=1.0">
	    <title>Checkbox</title>
	    <link rel="stylesheet" href="css/table.css">
	    <link rel="stylesheet" type="text/css" href="//use.fontawesome.com/releases/v5.7.2/css/all.css">

	    <style>
	        * {
	            box-sizing: border-box;
	        }

	        body {
	            margin: 0;
	            font-family: Arial, Helvetica, sans-serif;
	        }



	        #icon {
	            vertical-align: middle;
	            font-size: 40px;
	        }




	       .sub {
	            display: flex;
				padding: 5px;
				background-color: black;
				border: 1px solid #ae943f;;
	            margin: auto;
	            justify-content: center;
	            text-align: center;
	            display: grid;
				color: #ae943f;
				cursor: pointer;
	        }

	        .sub a {
	            text-decoration: none;
	        }



	        .header {
	            overflow: hidden;
	            background-color: #800000;
	            padding: 20px 10px;
	            margin-top: -10px;
	        }



	        .header h1 {
	            margin-right: 100px;
	            float: right;
	            color: black;
	            font-size: 18px;

	        }



	        .hover {
	            padding: 15px 25px;
	            font-size: 10px;
	            text-align: center;
	            cursor: pointer;
	            outline: none;
	            color: #fff;
	            background-color: #04AA6D;
	            border: none;
	            border-radius: 15px;
	            box-shadow: 0 9px #999;


	        }



	        .hover:hover {
	            background-color: #3e8e41
	        }

	        .hover:active {
	            background-color: #3e8e41;
	            box-shadow: 0 5px #666;
	            transform: translateY(4px);
	        }





	        @media screen and (max-width: 600px) {
	            .header h1 {
	                font-size: 14px;

	            }




	            /* second css */




	            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap');

	            * {
	                box-sizing: border-box;
	            }

	            body {
	                background-color: black;
	            }

	            body>div {
	                width: 100%;
	                height: auto;
	                display: flex;
	                font-family: 'Roboto', sans-serif;
	            }

	            .table_responsive {
	                max-width: 940px;
	                border: 1px solid #ae943f;
	                background-color: #efefef33;
	                padding: 5px;
	                overflow: auto;
	                margin: auto;
	                margin-top: 50px;
	                border-radius: 4px;
	                margin-bottom: 10px;
	            }






	            @media only screen and (max-width: 700px) {
	                .table_responsive {
	                    max-width: 400px;
	                    border: 1px solid #00bcd4;
	                    background-color: #efefef33;
	                    padding: 1px;
	                    overflow: auto;
	                    margin: auto;
	                    margin-top: 20px;
	                    border-radius: 4px;
	                    margin-bottom: 10px;
	                }


	                table th,
	                table td {
	                    border: 1px solid #00000017;
	                    padding: 10px 15px;
	                }

	            }


	            table {
	                width: 100%;
	                font-size: 15px;
	                color: #ae943f;
	                white-space: nowrap;
	                border-collapse: collapse;
	            }

	            table>thead {
	                background-color: #800000;
	                color: #fff;
	                height: 100px;

	            }

	            table>thead th {
	                padding: 45px;
	                padding-right: 60px;
	                padding-left: 60px;
	            }

	            table th,
	            table td {
	                border: 1px solid #00000017;
	                padding: 10px 15px;
	            }

	            table>tbody>tr>td>img {
	                display: inline-block;
	                width: 60px;
	                height: 60px;
	                object-fit: cover;
	                border-radius: 50%;
	                border: 4px solid #fff;
	                box-shadow: 0 2px 6px #0003;
	            }

	            .action_btn {
	                display: flex;
	                justify-content: center;
	                gap: 10px;
	            }

	            .action_btn>a {
	                text-decoration: none;
	                color: #444;
	                background: #fff;
	                border: 1px solid;
	                display: inline-block;
	                padding: 7px 20px;
	                font-weight: bold;
	                border-radius: 3px;
	                transition: 0.3s ease-in-out;
	            }

	            .action_btn>a:nth-child(1) {
	                border-color: #26a69a;
	            }

	            .action_btn>a:nth-child(2) {
	                border-color: orange;
	            }

	            .action_btn>a:hover {
	                box-shadow: 0 3px 8px #0003;
	            }

	            table>tbody>tr {
	                background-color: #fff;
	                transition: 0.3s ease-in-out;
	            }

	            table>tbody>tr:nth-child(even) {
	                background-color: rgb(238, 238, 238);
	            }

	            table>tbody>tr:hover {
	                filter: drop-shadow(0px 2px 6px #0002);
	            }


	            /* second css ends */


	            /* third section starts */
	    </style>

	</head>

	<body>



	    <div class="header">
	        <button class="hover" style="padding:8px; border: 1px solid black;background-color: #ae943f; border-radius: 8px; ">
	            <a style="text-decoration:none; color: black;" href="http://45.76.160.28:5005/leave-management.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>
	                Go Back</a>
	        </button>


	        <h1 style=" margin: auto;
	   width: 200px; font-weight: 900; color: #ae943f; ">
	            <i class="fas fa-file-invoice"></i>
	            ADMIN PERMISSION PAGE
	        </h1>
	    </div>
	   <div class="table_responsive">
	        <table>
	            <thead>
	                <tr>
	                    <th><i class="fa fa-id-card" aria-hidden="true"></i> Name</th>
	                    <th> <i class="fas fa-heading"></i> Functional Manager</th>
	                    <th><i class="fa fa-map-marker" aria-hidden="true"></i> Location Manager</th>
	                    <th> <i class="fa fa-calendar" aria-hidden="true"></i> Common</th>
	                </tr>
	            </thead>
	            <tbody>
	            </tbody>
	        </table>
	    </div>
	    </div>
	    <div>
	        <input type="submit" class="sub submit" value="submit">
	    </div>

	    </div>
	    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	    <script type="text/javascript">

	    	//click on checkboxx
	function first(checkbox)
	{
		if(checkbox.checked==true)
		{			
			$(checkbox).parent(".one").siblings(".third").children(".third").prop('checked', false);
			$(checkbox).parent(".two").siblings(".third").children(".third").prop('checked', false);
		}
		else
		{
		}
	}
	function both(checkbox)
	{
		if(checkbox.checked==true)
		{
			$(checkbox).parent(".third").siblings(".one").children(".first").prop('checked', false);
			$(checkbox).parent(".third").siblings(".two").children(".second").prop('checked', false);
		}
		else
		{
		}
	}


function run()
{
	        // get list
	        $.ajax({
	            type: 'get',
	            url: 'check_api.php?api=list',
	            data: {},
	            success: function(data2) {
	            //   console.log(data2);
	                  let data = JSON.parse(data2);
	                var html = "";
	                mail = '';
	                var count=1;
	                for (var i = 0; i < data.length; i++) {
	                    var mail = mail + '<tr><td><label>' + data[i].name + '</label></td><td class="one">';


	                    if (data[i].funct_mgr == null) {
	                        mail2 = '<input type="checkbox" class="first check_'+count+'" user_id='+data[i].memberID+' value="1" onchange="first(this);"  >';
	                    } else {
	                        mail2 = '<input type="checkbox" class="first check_'+count+'" user_id='+data[i].memberID+' value="1" onchange="first(this);" checked>';
	                    }
	                    mail = mail + mail2;

	                    var mail3 = '</td><td class="two">';
	                    mail = mail + mail3;
	                    if (data[i].postn_mgr == null) {
	                        mail4 = '<input type="checkbox" class="second check_'+count+'" user_id='+data[i].memberID+'  value="2" onchange="first(this);" >';
	                    } else {
	                        mail4 = '<input type="checkbox" class="second check_'+count+'" user_id='+data[i].memberID+' value="2" onchange="first(this);" checked>';
	                    }

	                    mail = mail + mail4;

	                    var mail5 = '</td><td class="third">';
	                    mail = mail + mail5;
	                    if (data[i].both != null) {
	                        var mail6 = '<input type="checkbox"  class="third check_'+count+'" user_id='+data[i].memberID+' value="3" onchange="both(this);" checked>';
	                    } else {
	                        var mail6 = '<input type="checkbox"  class="third check_'+count+'" user_id='+data[i].memberID+' value="3" onchange="both(this);">'
	                    }
	                    mail = mail + mail6;

	                    var mail7 = '</td></tr>';
	                    mail = mail + mail7;
	                    count++;
	                }
	                $("tbody").html(mail);
	            },
	            error: function(data) {
	                alert(
	                    "An error has occcured while logout. Please try again"
	                );
	            }
	        });

}
run();




	        $(".submit").click(function() {
	        	  var list = [];
	            $("tbody").each(function() {
	                var label_count = 0,
	                    label_count = $(this).find('label').length;
	                    //console.log(label_count);
	                var main = [];
	                for (let j = 1; j <= label_count; j++) {
	                    var sub = [];
	                    var checkbox = "";
						var checkbox = document.getElementsByClassName("check_" + j);

	                    var user_id = $(".check_" + j).attr("user_id");
	                   
	                    for (let i = 0; i < 3; i++) {
	                        if (checkbox[i].checked == true) {
	                            sub.push(checkbox[i].value);
	                        }
	                    }
	                    let arr = {
	                        [user_id]: sub
	                    };
	                    main.push(arr);
	                }
	               // console.log(main);
	           

 $.ajax({
	            type: 'post',
	            url: 'check_api.php?api=set',
	            data: {setdata:main},
	            success: function(data2) {
	            	console.log(data2);
	            	if(data2)
	            	{
	            		alert("Submitted")
	            		//location.reload();
	            	}
	            	else
	            	{
	            		alert("You cannot able to assign manager to this user. This user already has three manager, more than that cannot be assign.")
	            	}
	            }
	        });



	            });





	        });
	    </script>



	</body>

	</html>