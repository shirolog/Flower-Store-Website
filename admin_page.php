<?php 
require('./config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location:./login.php');
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

<!-- dashboard section -->
<section class="dashboard">

    <h1 class="title">dashboard</h1>

    <div class="box-container">
        
        <div class="box">
            <?php 
            $total_pending = 0;
            $select_orders = $conn->prepare("SELECT * FROM  `orders` WHERE payment_status= ?");
            $select_orders->execute(array('pending'));
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                $total_pending += $fetch_orders['total_price'];
            }
            ?>
                <h3>$ <span><?= $total_pending; ?></span>-</h3>
                <p>total pendings</p>
        </div>

        <div class="box">
            <?php 
            $total_completes = 0;
            $select_orders = $conn->prepare("SELECT * FROM  `orders` WHERE payment_status= ?");
            $select_orders->execute(array('completed'));
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                $total_completes += $fetch_orders['total_price'];
            }
            ?>
                <h3>$ <span><?= $total_completes; ?></span>-</h3>
                <p>completed payments</p>
        </div>

        <div class="box">
            <?php 
            $select_orders = $conn->prepare("SELECT * FROM  `orders`");
            $select_orders->execute();
            $number_orders =$select_orders->rowCount();
            ?>
                <h3><span><?= $number_orders; ?></span></h3>
                <p>orders placed</p>
        </div>

        <div class="box">
            <?php 
            $select_products = $conn->prepare("SELECT * FROM  `products`");
            $select_products->execute();
            $number_products =$select_products->rowCount();
            ?>
                <h3><span><?= $number_products; ?></span></h3>
                <p>products added</p>
        </div>

        <div class="box">
            <?php 
            $select_users = $conn->prepare("SELECT * FROM  `users` WHERE user_type= ?");
            $select_users->execute(array('user'));
            $number_users =$select_users->rowCount();
            ?>
                <h3><span><?= $number_users; ?></span></h3>
                <p>normal users</p>
        </div>

        <div class="box">
            <?php 
            $select_users = $conn->prepare("SELECT * FROM  `users` WHERE user_type= ?");
            $select_users->execute(array('admin'));
            $number_admins =$select_users->rowCount();
            ?>
                <h3><span><?= $number_admins; ?></span></h3>
                <p>admin users</p>
        </div>

        <div class="box">
            <?php 
            $select_users = $conn->prepare("SELECT * FROM  `users`");
            $select_users->execute();
            $total_accounts =$select_users->rowCount();
            ?>
                <h3><span><?= $total_accounts; ?></span></h3>
                <p>total accounts</p>
        </div>

        <div class="box">
            <?php 
            $select_messages = $conn->prepare("SELECT * FROM  `message`");
            $select_messages->execute();
            $total_messages =$select_messages->rowCount();
            ?>
                <h3><span><?= $total_messages; ?></span></h3>
                <p>new messages</p>
        </div>

    </div>
        


</section>




<!-- custom js     -->
<script src="./assets/js/admin.js"></script>
</body>
</html>