<?php
//    $title = 'Objects Wiki | Forgot Password Page';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Forgot Password Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"
        integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">                      
</head>

<body>
    <!-- Navbar Section -->
<?php include('nav.php'); ?>

    <!-- Main Section -->
    <div class="container">
        <form id="contact">
            <h3>72 Dragons Employee Leave Tracker Forgot Password</h3>
            <div class="contact-info">
                <fieldset>
                    <label><i class="fas fa-envelope"></i>&nbsp;&nbsp;Email ID</label>
                    <input type="text" name="forgot_password" tabindex="1" autofocus>
                </fieldset>
                <fieldset>
                    <button type="submit" class="login-btn">Submit</button>
                </fieldset>

            </div>
        </form>
    </div>



    <script src=" https://code.jquery.com/jquery-3.5.1.min.js "></script>
    <script>
        function myFunction() {
            var x = document.getElementById("myTopnav");
            if (x.className === "topnav") {
                x.className += " responsive";
            } else {
                x.className = "topnav";
            }
        }
        $(document).ready(function () {
            // AJAX for submitting forgot password.
            $("body").on("click", ".login-btn", function (e) {
                e.preventDefault();

                var forgotPass = $("input[name='forgot_password']").val();

                if (forgotPass == "") {
                    alert('Please enter the email');
                    return false;
                }

                //FormData
                var formData = new FormData();
                formData.append('email', forgotPass);

                $.ajax({
                    type: 'post',
                    url: 'login_db.php?api=forgot_pwd',
                    data:{email:forgotPass},
                    success: function (res) {
                        alert(res);
                        //return false;
                    },
                    error: function (data) {
                        alert(
                            "An error has occcured while entering email. Please try again"
                        );
                    }
                });

                $(".success-msg").css("z-index", "unset");
                $(".successfully-saved").css("display", "block").delay(1000).fadeOut(400);
                $(".login-input").val("");
            });
        });
    </script>
</body>

</html>