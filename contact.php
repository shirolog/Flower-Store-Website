<?php 
require('./config.php');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location:./login.php');
    exit();
}

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `message` WHERE
    name= ? AND email= ? AND number= ? AND message= ?");
    $select_message->execute(array($name, $email, $number, $msg));
    if($select_message->rowCount() > 0){
        $message[] = 'message  sent already!';
    }else{
        $inser_message = $conn->prepare("INSERT INTO `message` (user_id, name,
        email, number, message) VALUES(?, ?, ?, ?, ?)");
        $inser_message->execute(array($user_id, $name, $email, $number, $msg));
        $message[] = 'message  sent successfully!';
    }
    $_SESSION['message'] = $message;
    header('Location:./contact.php');
    exit();

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php  require('./header.php'); ?>    

<!-- heading section -->
<div class="heading">
    <h3>contact us</h3>
    <p><a href="./home.php">home</a> / contact</p>
</div>


<!-- contact section -->
<section class="contact">

    <form action="" method="post">
        <h3>send us message!</h3>
        <input type="text" name="name" placeholder="enter your name"
        class="box" required>
        <input type="email" name="email" placeholder="enter your email"
        class="box" required>
        <input type="number" name="number" min="0" placeholder="enter your number"
        class="box" required>
        <textarea name="msg" class="box" cols="30" rows="10"
        placeholder="enter your message" required></textarea>
        <input type="submit" value="send message" name="send" class="btn">
    </form>

</section>



<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>