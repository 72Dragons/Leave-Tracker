<?php
include 'login_db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Permission Page</title>
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
    #location,
    #Cnumbers,
    #levels{
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
    <div class="main_permission_container">
        <h2>PERMISSION PAGE</h2>
        <form id='permission_form'>
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
                <input type="text" id="username" name="username" autocomplete="off" placeholder="Enter your name..." />
            </div><br>
            <div class="input_container">
                <label>Password*</label>
                <input type="text" id="password" name="password" autocomplete="off"
                    placeholder="Create your password..." />
            </div><br>
            <div class="input_container">
                <label>Email ID*</label>
                <input type="text" id="email" name="email" autocomplete="off" placeholder="Enter your company ID..." />
            </div><br>

            <!-- changes by Ashish -->
            <div class="input_container">
                <label>Contact Number*</label>
                <input type="number" name="contact" id="Cnumbers">
            </div><br>
            <div class="input_container">
                <label>Clearence Level</label>
                <select name="levels" id="levels">
                    <option value="">Select Level *</option>
                    <option value="1">Intern Level</option>
                    <option value="2">Employee Level</option>
                    <option value="3">Head Level</option>
                    <option value="4">High Head Level</option>
                    <option value="5">Admin Level</option>
                </select>
            </div><br>
            <!-- this point till Ashish worked -->

            <div class="input_container">
                <label>Location*</label>
                <select id="location" name="location">
                    <option value="">Select Location</option>
                    <option value="">India</option>
                    <option value="">USA</option>
                    <option value="">Hong Kong</option>
                    <option value="">China</option>
                </select>
            </div><br>


            <!-- <div class="input_container">
                <label>Location*</label>
                <input type="text" id="location" name="location" autocomplete="off"
                    placeholder="Enter your country name..." />
            </div><br> -->

            <div class="input_container">
                <label>Click If You Are A Manager*</label>
                <input type="checkbox" id="check" name="check" />
                <span class="checkmark"></span>
            </div><br>
            <div class="input_container">
                <label>Select Position Manager*</label>
                <select id="position_select" name="position_select">
                    <option value="">Select Position Manager</option>
                    <?php 
                    $data=$login::all_postn();
                    $data2=json_decode($data,true);
                    foreach ($data2 as $key => $value) {
                        ?>
                    <option value="<?php echo $value['login_id']; ?>"><?php echo $value['name_P']; ?></option>
                    <?php 
                    }
                     ?>

                </select>
            </div><br>
            <div class="input_container">
                <label>Select Functional Manger*</label>
                <select id="functional_select" name="functional_select">
                    <option value="">Select Functional Manger</option>
                    <?php
                        $dat=$login::all_func();
                    $dat2=json_decode($dat,true);
                    foreach ($dat2 as $key => $value) {
                        ?>
                    <option value="<?php echo $value['login_id']; ?>"><?php echo $value['name_F']; ?></option>
                    <?php
                    }
?>

                </select>
            </div>
            <div class="permission_button">
                <button type="submit" class="cancel_user">Cancel</button>
                <button type="submit" class="submit_user">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah').css('display', 'unset');
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {
        $('.cancel_user').click(function() {
            //alert('hi');
            window.location.href = 'login.php';
        });
    });
    </script>
</body>

</html>