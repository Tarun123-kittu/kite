<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Email</title>
   

</head>
<body>
    <div class="main">
       
        <div class="main-body">
            <h1>Welcome your account is created below mentioned is your email and password. You can reset your password.</h1>

            <p>.</p>
            <div class="pswd-btn">
                <span>Email - </span><a href="">{{ $data->email }}</a> <span>!</span>
                <span>Password - </span><a href="">{{ $data->password }}</a> <span>!</span>
            </div>
            
        </div>
        
    </div>

</body>
</html>