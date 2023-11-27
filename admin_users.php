<?php 
require('./config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location:./login.php');
    exit();
}


if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $delete_users = $conn->prepare("DELETE FROM `users` WHERE id= ?");
    $delete_users->execute(array($delete_id));
    header('Location: ./admin_users.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/admin_style.css">
</head>
<body>
<?php require('./admin_header.php'); ?>  

<!-- users section -->
<section class="users">

    <h1 class="title">users account</h1>

    <div class="box-container">

    <?php 
    $select_users = $conn->prepare("SELECT * FROM `users`");
    $select_users->execute();
    if($select_users->rowCount() >0){
        while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
    ?>

        <div class="box">
            <p>user id : <span><?= $fetch_users['id']; ?></span></p>
            <p>username : <span><?= $fetch_users['name']; ?></span></p>
            <p>email : <span><?= $fetch_users['email']; ?></span></p>
            <p>user type : <span style="color:<?php if($fetch_users['user_type'] == 'admin')
            {echo 'var(--orange)';}; ?>"><?= $fetch_users['user_type']; ?></span></p>
            <a href="./admin_users.php?delete=<?= $fetch_users['id']; ?>" 
            onclick="return confirm('delete this user?')" class="delete-btn">delete</a>
        </div>
    <?php         
    }
    }
    ?>        
    </div>

</section>



<!-- custom js     -->
<script src="./assets/js/admin.js"></script>
</body>
</html>