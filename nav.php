<nav class="navbar">
    <label class="navbar-toggle" id="js-navbar-toggle" for="chkToggle">
        <i class="fa fa-bars"></i>
    </label>
    <a href="#" class="logo">
        <img src="images/72dragons-small.png" class="image--cover">
    </a>
    <h1 class="logo-label">72 DRAGONS EMPLOYEE LEAVE TRACKER</h1>
    <input type="checkbox" id="chkToggle"></input>
    <?php 
    if(!isset($_SESSION['user_id']))
        {
            //echo $_SESSION['user_id'];
        }
        else
        {
            ?>
            <ul class="main-nav" id="js-menu">
        <li>
<!--             <a href="#" class="nav-links"><i class="far fa-user-circle fa-3x"></i>&nbsp;&nbsp;<i
                    class="fa fa-caret-down"></i></a> -->

                    <?php 
                    $img=json_decode($login::image_send($_SESSION['user_id']),true);
                    ?>
                    <a href="#" class="nav-links"><img src="<?php echo $img[0]['image'];  ?>" class="image--cover">&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
            </a>
            <ul>
                <a href="login.php" class="log-out" data-id="<?php echo $_SESSION['user_id']; ?>">
                    <li>Logout</li>
                </a>
<!--                 <a href="edit-permission.php" class="edit_permission">
                    <li>Edit permission</li>
                </a> -->
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
                <!-- <a href="http://45.76.160.28:4000/main_webex/webex.php">
                    <li>WebEx Details</li>
                </a> -->
                <a href="attendance.php">
                    <li>Attendance</li>
                </a>
                <a href="admin_chk.php">
                    <li>Admin Permission Page</li>
                </a>
                <?php
                }
                elseif($funct_stats==false)
                {
                        echo "";
                }

                 ?>

                <a href="manual.php">
                    <li>Employee Manual</li>
                </a>
            </ul>
        </li>
    </ul>
            <?php
        }

     ?>
    
</nav