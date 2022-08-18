<?php 
session_start();
if(isset($_SESSION['user_id']))
{
   header("Location:leave-management.php"); 
   exit();
}
else
{
   // header("Location:login.php");
   //  exit();
    echo "";
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"
        integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <!-- Navbar -->
    <?php include('nav.php'); ?>

    <!-- Main Section -->
    <div class="container">
        <form id="contact">
            <h3>72 Dragons Employee Leave Tracker Login</h3>
            <div class="contact-info">
                <fieldset>
                    <label><i class="far fa-user-circle"></i>&nbsp;&nbsp;USERNAME</label>
                    <input type="text" name="username" tabindex="1" autofocus>
                </fieldset>
                <fieldset>
                    <label><i class="fa fa-lock"></i>&nbsp;&nbsp;PASSWORD</label>
                    <input type="password" name="password" tabindex="2">
                </fieldset>
                <fieldset>
                    <button name="login" type="submit" id="contact-login">Login</button>
                </fieldset>
                <fieldset>
                    <button name="forgot" type="submit" id="contact-forgot"><a style="text-decoration: none;color: unset;" href="forgotPassword.php">Forgot Password</a></button>
                </fieldset>
                <!-- <fieldset>
                    <button name="staff" type="submit" id="contact-staff-account"><a style="text-decoration: none;color: unset;"href="permission.php">Click Here If You Do Not Have A Staff
                        Account</a></button>
                </fieldset> -->
                <!-- <p class="lang-select">Language Selection</p>
                <div class="flags">
                    <a title="USA" href="#">EN</a>
                    <a title="China" href="#">中文</a>
                </div> -->
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(document).ready(function () {


    //         $('body').on('click', '#contact-staff-account', function () {
    //     location.href = 'permission.php';
    // //alert("hi");
    // });
            // AJAX for submitting log-in info.
            $("body").on("click", "#contact-login", function (e) {
                e.preventDefault();

                var username = $("input[name='username']").val();
                var password = $("input[name='password']").val();

                if (username == "") {
                    alert('Please enter the username');
                    return false;
                }
                if (password == "") {
                    alert('Please enter the password');
                    return false;
                }

                //FormData
                var formData = new FormData();
                formData.append('username', username);
                formData.append('password', password);

                $.ajax({
                    type: 'post',
                    url: 'login_db.php?api=login_details',
                    data:{email:username,password:password},
                    success: function (data) {
 //                       let data = JSON.parse(res);
                         console.log(data);
                       // return false;

                         if(data=="1")
                                  {
                                    //alert('login successful');
                                    window.location.href='./leave-management.php';
                                  }
                                  else
                                  {
                                    alert("The Username Or Password Was Incorrect. Please Try Again.");
                                  }
                    },
                    error: function (data) {
                        alert(
                            "An error has occcured while logging in. Please try again"
                        );
                    }
                });
                $("input[name='username']").val("");
                $("input[name='password']").val("");
            });
        });
    </script>
</body>

</html>