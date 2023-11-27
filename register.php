<?php 
require('./config.php');
session_start();

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = md5($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = md5($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    $select_users= $conn->prepare("SELECT * FROM `users` WHERE email= ?");
    $select_users->execute(array($email));

    if($select_users->rowCount() > 0){
        $message[] = 'user already exist!';
        $_SESSION['message'] = $message;
        header('Location: ./register.php');
        exit();
    }else{
        if($pass != $cpass){
            $message[] = 'confirm password not matched!';
            $_SESSION['message'] = $message;
            header('Location: ./register.php');
            exit();
        }else{
            $insert_users = $conn->prepare("INSERT INTO  `users` (name, email, password)
            VALUES(?, ?, ?) ");
            $insert_users->execute(array($name, $email, $cpass));
            $message[] = 'registered successfully!';
            $_SESSION['message'] = $message;
            header('Location: ./login.php');
            exit();
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

<?php 
if(isset($_SESSION['message'])){
    foreach($_SESSION['message'] as $message){
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
    }
        unset($_SESSION['message']);
}
?>


<!-- form-container section -->
<section class="form-container">

    <form action="" method="post">
        <h3>register now</h3>
        <input type="text" name="name" class="box" 
        placeholder="enter your username" required>
        <input type="email" name="email" class="box" 
        placeholder="enter your email" required>
        <input type="password" name="pass" class="box" 
        placeholder="enter your password" required>
        <input type="password" name="cpass" class="box" 
        placeholder="confirm your password" required>
        <input type="submit" class="btn" name="submit" value="regiter now">
        <p>already have an account? <a href="./login.php">login now</a></p>
    </form>
</section>
    
</body>
</html>