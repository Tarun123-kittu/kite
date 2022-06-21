<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Email</title>
    <style>
        body{
            background-color: #f4f4f4 !important;
            padding: 0;
            margin: 0;
            font-family: 'Lato', sans-serif;
        }

        .main
        {
            border-radius: 1em;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 5em;
            /* height: 90vh; */
            display: table;
            background-color: #fff;
            text-align: center;
        }

        .main-header
        {
            background-color: #f9a900;
            opacity: 0.7;
            border-top-left-radius: 1em;
            border-top-right-radius: 1em;
        }

        .head-logo img {
            width: 10%;
            margin: 0 auto;
            display: table-cell;
        }

        .main-body h1{
            font-family: 'Lato', sans-serif;
            font-size: 3em;
            color: #3c3c3c;
            margin-bottom: 0.1em;
        }

        .main-body
        {
            padding: 3em 1em;
        }

        .main-body a
        {
            font-family: 'Lato', sans-serif;
            font-size: 1.6em;
            color: #00adff;
        }

        .main-body span
        {
            font-size: 2em;
            color: #3c3c3c;
        }

        .main-body p
        {
            font-size: 1.6em;
            font-family: 'Lato', sans-serif;
            color: #3c3c3c;
        }

        .pswd-btn {
            margin-top: 3em;
        }

        .pswd-btn a
        {
            font-size: 1.4em;
            background-color: #024da0;
            padding: 0.8em 2em;
            color: #fff;
            text-decoration: none;
            font-style: italic;
            border-radius: 10em;
        }

        .main-footer
        {
            padding: 1em 3em;
            /* border-bottom-style: inset; */
            border-bottom-left-radius: 1em;
            border-bottom-right-radius: 1em;
        }

        .main-footer h4{
            font-family: 'Lato', sans-serif;
            margin-bottom: 0em;
            font-size: 1.2em;
            color: #3c3c3c;
        }

        .main-footer hr{
            background-color: #9f9f9f;
            height: 1px;
        }

        .main-footer a{
            font-family: 'Lato', sans-serif;
            text-decoration: none;
            color: #00adff;
        }

        .copyright
        {
            text-align: center;
            font-family: 'Lato', sans-serif;
            margin-bottom: 0em;
            font-size: 1em;
            margin-top: 2em;
            color: #3c3c3c;
        }

        @media screen and (max-width:1466px) {

            .head-logo img {
                width: 12%;
            }

        }

        @media screen and (max-width:1200px)
        {
            .main-body {
                padding: 2em 1em;
            }

            .pswd-btn a {
                padding: 0.7em 1.7em;
            }

            .head-logo img {
                width: 14%;
            }
        }

        @media screen and (max-width:1112px)
        {
            .main-body p {
                font-size: 1.3em;
            }

            .main-body h1 {
                font-size: 2.3em;
            }

        }

        @media screen and (max-width:915px)
        {
            .head-logo img {
                width: 16%;
            }

            .main-body h1 {
                font-size: 2.1em;
            }
            
        }

        @media screen and (max-width:780px)
        {
            .head-logo img {
                width: 18%;
            }

            .main-body p {
                font-size: 1.3em;
            }

            .main-body h1 {
                font-size: 2.1em;
            }

            .pswd-btn a {
                font-size: 1.1em;
            }

            .main-body a {
                font-size: 1.4em;
            }

            .pswd-btn a {
                font-size: 1.1em;
            }

            .main {
                border-radius: 1em;
                width: 80%;
            }

            .main-body span
            {
                font-size: 1.4em;
            }

        }

        @media screen and (max-width:550px)
        {
            .main-body p {
                font-size: 1em;
            }
        }

    </style>

</head>
<body>
    <div class="main">
       
        <div class="main-body">
            <h1>Welcome</h1>
            <a href="">{{ $data->email }}</a> <span>!</span>
            <p>Please click on the button below to reset your password.</p>
            <div class="pswd-btn">
                <a href="{{ url('reset-password', [$data->email,$data->password_token], false) }}">Reset my password</a>
            </div>
            
        </div>
        
    </div>

</body>
</html>