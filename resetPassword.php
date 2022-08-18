<?php
//    $title = 'Objects Wiki | Reset Password Page';
    $token=$_GET['token'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Reset Password Page</title>
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
            <h3>72 Dragons Employee Leave Tracker Reset Password</h3>
            <div class="contact-info">
                <fieldset>
                    <label><i class="fas fa-key"></i>&nbsp;&nbsp;Create a New password</label>
                    <input type="text" class="login-password" name="pass1" tabindex="1" autofocus>
                </fieldset>
                <fieldset>
                    <label><i class="fas fa-key"></i>&nbsp;&nbsp;Re-enter Your New password</label>
                    <input type="text" class="login-password" name="pass2" tabindex="1" autofocus>
                </fieldset>
                <input type="hidden" name="token" value="<?php echo $token;?>">
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
            // AJAX for submitting new & verify password.
            $("body").on("click", ".login-btn", function (e) {
                e.preventDefault();

                var pass1 = $("input[name='pass1']").val();
                var pass2 = $("input[name='pass2']").val();

                
                var token = $("input[name='token']").val();



                if (pass1 == "") {
                    alert('Please enter the password');
                    return false;
                }

                if (pass2 == "") {
                    alert('Please enter the password');
                    return false;
                }

                


                //FormData
                var formData = new FormData();
                formData.append('pass1', pass1);
                formData.append('pass2', pass2);
                formData.append('token', token);
                //console.log(email);

                $.ajax({
                    type: 'post',
                    url: 'login_db.php?api=reset_password',
                    data:{pass1:pass1,pass2:pass2,token:token},
                    success: function (data) {
                        console.log(data);
                        if(data == 'yes')
                                  {
                                    alert('password updated');
                                    window.location.href='./login.php';
                                  }
                                  else if(data=='no')
                                  {
                                    alert('Please try again');
                                    window.location.href='./resetPassword.php';
                                  }
                    },
                    error: function (data) {
                        alert(
                            "An error has occcured while entering password. Please try again"
                        );
                    }
                });

                $(".success-msg").css("z-index", "unset");
                $(".successfully-saved").css("display", "block").delay(1000).fadeOut(400);
                $("input[name='pass1']").val("");
                $("input[name='pass2']").val("");
            });
        });
    </script>
</body>

</html>