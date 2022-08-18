<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Tracker | Message Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css"
        integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <style>
        body {
            background: var(--dragon-gold);
        }

        .message__box {
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            margin: 0;
            border: 1px solid;
            padding: 5px;
        }

        .green {
            color: green;
        }

        .red {
            color: #96031a;
        }
    </style>
</head>

<body>
    <div class="body__container">
        <div class="message__box">
            <h1>Leave Has Been <span class="green">Denied</span> For <i>siddhant</i></h1>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

    </script>
</body>

</html>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="js/main.js"></script>
            <script>
            //	alert("he");
var apply_id = "<?php echo $_GET['apply_id']; ?>";// table = apply_leave
var user_id = "<?php echo $_GET['user_id']; ?>"; //table = apply_leave
var login_id = "<?php echo $_GET['login_id']; ?>"; //table = login
var type= "<?php echo str_replace("_"," ",$_GET['type']); ?>";
var count="<?php echo $_GET['count']; ?>";
// var fromDate= " echo $_GET['fromDate']; ?>";
// var toDate=" echo $_GET['toDate']; ?>";
var funct_status ="denied";
var post_status="denied";


$.ajax({
                    type: 'post',
                    url: 'api.php?api=denied_status',
                    data: {
                         apply_id: apply_id,
                        login_id : login_id,
                        user_id:user_id,
                        type:type,
                        count:count,
                        funct_status:funct_status,
                        post_status:post_status
                        // deduct:deduct
                    },
                    success: function (data) {
                      console.log(data);
                    },
                    error: function (data) {
                        alert(
                            "An error has occcured while approving. Please try again"
                        );
                    }
                });
            </script>