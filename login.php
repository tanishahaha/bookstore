<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']) );

    $select_users=mysqli_query($conn,"SELECT * FROM `users` WHERE email='$email' AND password='$password'") or die('query failed');

    if(mysqli_num_rows($select_users) > 0){
        $row=mysqli_fetch_assoc($select_users);

        if($row['user_type'] =='admin'){
            $_SESSION['admin_name']=$row['name'];
            $_SESSION['admin_email']=$row['email'];
            $_SESSION['admin_id']=$row['id'];
            header('location:admin_page.php');

        }elseif($row['user_type'] =='user'){
            $_SESSION['user_name']=$row['name'];
            $_SESSION['user_email']=$row['email'];
            $_SESSION['user_id']=$row['id'];
            header('location:home.php');
        }
    }else{
        $message[]='Incorrect email or password';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fa-solid fa-xmark" onclick="this.parentElement.remove();"></i>
        </div>
    ';    
    }
    
}
?>


<div class="box login_box">
    <span class="borderline"></span>
    <form action="" method="post">
    <h2>Login</h2>

        <div class="inputbox">
            <input type="email" name="email" required="required">
            <span>Email</span>
            <i></i>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required="required">
            <span>Password</span>
            <i></i>
        </div>
        
        <div class="links">
            <a href="#">Forgot Password</a>
            <a href="register.php">Sign in</a>
        </div>

        <input type="submit" value="Login" name="submit">
    </form>
</div>
<script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
</body>
</html>