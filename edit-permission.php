<?php 
include 'login_db.php';
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
    <title>Leave Tracker | Edit Permission Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"
        integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
           .main_permission_container {
            margin: 50px auto;
            width: 100%;
            max-width: 1200px;
            background: var(--dragon-black);
            color: var(--dragon-gold);
            padding: 10px;
        }

        .main_permission_container h2 {
            text-align: center;
        }

        .input_container {
            margin: 20px auto;
        }

        .input_container label {
            margin-right: 10px;
        }

        .input_container input[type='text'],
         #position_select,
        #functional_select,
        #location {
            border: 1px solid var(--dragon-gold);
            background: var(--black);
            color: var(--dragon-gold);
            padding: 5px;
            font-size: 14px;
            width: 300px;
            outline: none;
            cursor: pointer;
        }

        .permission_button {
            margin-top: 40px;
        }

        .permission_button button[type='submit'] {
            cursor: pointer;
            border: 1px solid var(--dragon-gold);
            background: var(--black);
            color: var(--dragon-gold);
            margin: 0 0 5px;
            padding: 5px 10px;
            font-size: 15px;
            outline: none;
            cursor: pointer;
        }

        .input_container input[type='checkbox']:after {
            content: '';
            display: inline-block;
            width: 18px;
            height: 18px;
            margin-top: -4px;
            border: 1px solid var(--dragon-gold);
            background: var(--black);
            cursor: pointer;
            padding: 2px;
        }

        .input_container input[type='checkbox']:checked:after {
            content: '\2713';
            width: 18px;
            height: 18px;
            font-size: 16px;
            color: var(--dragon-gold);
        }
#blah {
            display: none;
            width: 100%;
            height: 100%;
            padding: 0 200px;
            object-fit: contain;
        }

        .profile-info {
            margin-top: 10px;
            font-size: 13.8px;
            color: #AE943F;
        }

        input.insInput {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .uploadBox {
            border: 1px solid #AE943F;
            height: 200px;
            width: 100%;
            box-sizing: border-box;
            padding: 20px;
            overflow: hidden;
            position: relative;
            background-color: black;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        .uploadBox img {
            width: 100%;
            height: 100%;
            padding: 0 200px;
            object-fit: contain;
        }

        .edited-img {
            width: 100%;
            height: 100%;
            padding: 0 200px;
            object-fit: contain;
        }

        .upload-label {
            /* position: relative; */
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
        }

        .uploadPlus {
            margin: 20px auto;
            border: #AE943F 1px solid;
            width: 18px;
            height: 18px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--dragon-gold);
        }

        .browse-text {
            text-align: center;
            color: #AE943F;
        }

        @media screen and (max-width:1024px) {
            .main_permission_container {
                margin: 10px;
                width: unset;
                max-width: unset;
            }

            .input_container input[type='text'],
            #position_select,
            #functional_select {
                width: 100%;
            }
            /* only unset the blah padding for mobile upload pic */
            #blah {
                padding: unset;
            }
        }
    </style>
</head>

<body>
  <input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['user_id']; ?>"> 
    <div class="main_permission_container">
        <h2>PERMISSION PAGE</h2>

        <?php 
$data=$login->all_user_details($_SESSION['user_id']);
$data2=json_decode($data,true);
//print_r($data2);
foreach ($data2 as $key => $value) {


?>


<form id='permission_form'>

   <img src="<?php echo $value['image']; ?>" style="width:15%;">

    <h4 class="profile-info">Upload Photo*</h4>
            <div class="uploadBox" id="insUp">
                <input type="file" class="insInput" name="image" onchange="readURL(this);" multiple>
                <img id="blah" src="" alt="" style="" />
                <div class="upload-label">
                    <div class="uploadPlus">
                        +
                    </div>
                    <div class="browse-text">Click here to browse your files or drag and drop images</div>
                </div>
            </div>

            <div class="input_container">
                <label>Username*</label>
                <input type="text" id="username" name="username" autocomplete="off" value="<?php echo $value['name']; ?>" />
            </div><br>
            <div class="input_container">
                <label>Email ID*</label>
                <input type="text" id="email" name="email" autocomplete="off" value="<?php echo $value['username']; ?>" />
            </div><br>


            <div class="input_container">
                <label>Location</label>
                <select id="location" name="location">
                    <option><?php echo $value['location']; ?></option>

                    <?php 
                    $ex_one=$login->all_loctn_ex_one($value['location']);
                    $ex_one2=json_decode($ex_one,true);
                    //print_r($ex_one2);
                    foreach ($ex_one2 as $key2 => $value2) {

                        ?>
                    <option><?php echo $value2; ?></option>
                   
                        <?php
                    }

                     ?>

                </select>
            </div><br>


        <div class="input_container">
                <label>Click If You Are A Manager*</label>
                <?php 
                $check_stat=$login->checkdata($value['name']);
               // echo $check_stat;
                if($check_stat)
                {
                    ?>
                        <input type="checkbox" id="check" name="check" checked="checked" />
                        <span class="checkmark"></span>
                <?php
               }
               else
               {
                ?>
                        <input type="checkbox" id="check" name="check"  />
                        <span class="checkmark"></span>                
               <?php
               }

                 ?>
            </div><br>


            <div class="input_container">
                <label>Select Location Manager*</label>
                <select id="position_select" name="position_select">
                    <option value="<?php echo $value['p_login']; ?>"><?php echo $value['name_P']; ?></option>

                    <?php 
                    // $ex_one=$login->all_postn_ex_one($value['name_P']);
                    $ex_one=$login->all_postn_ex_one($value['name_P'],$value['name']);
                    $ex_one2=json_decode($ex_one,true);
                   // print_r($ex_one2);
                    foreach ($ex_one2 as $key2 => $value2) {

                        ?>
                    <option value="<?php echo $value2['login_id']; ?>"><?php echo $value2['name_P'] ?></option>
                   
                        <?php
                    }

                     ?>

                </select>
            </div><br>

            <div class="input_container">
                <label>Select Functional Manger*</label>
                <select id="functional_select" name="functional_select">
                    <option value="<?php echo $value['f_login']; ?>"><?php echo $value['name_F']; ?></option>
                    <?php 
                    // $ex_one=$login->all_func_ex_one($value['name_F']);
                     $ex_one=$login->all_func_ex_one($value['name_F'],$value['name']);
                    $ex_one2=json_decode($ex_one,true);
                    //print_r($ex_one2);
                    foreach ($ex_one2 as $key2 => $value2) {

                        ?>
                    <option value="<?php echo $value2['login_id']; ?>"><?php echo $value2['name_F'] ?></option>
                   
                        <?php
                    }

                     ?>
                </select>
            </div>
            <div class="permission_button">
                <button type="submit" class="cancel_user">Cancel</button>
                <button type="submit" class="submit_edit_user">Submit</button>
            </div>
        </form>

<?php 
}
         ?>
        
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/main.js"></script>
      <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah').css('display', 'unset');
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }   
    </script>
</body>

</html>
