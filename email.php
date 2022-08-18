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
    <style>
        body {
            background: var(--dragon-gold);
        }

        p {
            margin-top: 1em;
        }

        .mail__body__container {
            border: 1px solid var(--black);
            margin: 2em;
        }

        .mail__body__header,
        .mail__body__buttons {
            text-align: center;
            padding: 5em;
            border-bottom: 1px solid var(--black);
        }

        .button__container {
            margin: 1em;
        }

        .button__container button {
            width: 5em;
            padding: .3em 1.5em;
            border: none;
            outline: none;
            cursor: pointer;
            font-weight: bold;
        }

        .button__container button span {
            font-size: 22px;
        }

        .mail__body__approve {
            margin-right: .5em;
            background: green;
        }

        .mail__body__deny {
            background: var(--dragon-red);
        }

        .mail__body__link {
            text-align: center;
            padding: 10em;
        }

        .mail__body__link a {
            text-decoration: none;
            color: var(--dragon-dark-red);
            font-size: 2em;
            font-weight: bold;
        }

@media screen and (max-width:765px)
{
	.mail_body_header,
	.mail_body_buttons {
                padding: 5em 0;
		}
.mail_body_link {
                padding: 10em 0;
}
            }
    </style>
</head>

<body>
    <div class="mail__body__container">
        <div class="mail__body__header">
            <h1>NEW LEAVE APPLICATION</h1>
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Itaque praesentium minima hic repellat, alias
                ipsam blanditiis, expedita ut fuga rem inventore temporibus sit? Pariatur quia perferendis provident
                velit quam aut.</p>
        </div>
        <div class="mail__body__buttons">
            <p>To approve leave click here:</p>
            <div class="button__container">
                <a href=""><button class="mail__body__approve"><span>&#10003;</span></button></a>
                <a href=""><button class="mail__body__deny"><span>&#215;</span></button></a>
            </div>
        </div>
        <div class="mail__body__link">
            <a href="">OPEN IN LEAVE TRACKER APP</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

    </script>
</body>

</html>
