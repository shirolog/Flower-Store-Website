<?php 
require('./config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location:./login.php');
    exit();
}


if(isset($_POST['update_order'])){

    $update_payment = $_POST['update_payment'];
    $update_payment = filter_var($update_payment, FILTER_SANITIZE_STRING);
    $order_id = $_POST['order_id'];
    $order_id = filter_var($order_id, FILTER_SANITIZE_STRING);

    $update_orders = $conn->prepare("UPDATE `orders` SET payment_status= ? WHERE id= ?");
    $update_orders->execute(array($update_payment, $order_id));
    $message[] = 'payment status has been updated!';
    $_SESSION['message'] = $message;
    header('Location: ./admin_orders.php');
    exit();
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE id= ?");
    $delete_orders->execute(array($delete_id));
    header('Location: ./admin_orders.php');
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

<!-- placed-orders section -->
<section class="placed-orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">
        <?php 
        $select_orders =  $conn->prepare("SELECT * FROM  `orders`");
        $select_orders->execute();
        if($select_orders->rowCount() > 0){
            while($fetch_orders= $select_orders->fetch(PDO::FETCH_ASSOC)){
        ?>

        <div class="box">
            <p>user id : <span><?= $fetch_orders['user_id']; ?></span></p>
            <p>placed on: <span><?= $fetch_orders['placed_on']; ?></span></p>
            <p>name : <span><?= $fetch_orders['name']; ?></span></p>
            <p>number : <span><?= $fetch_orders['number']; ?></span></p>
            <p>email : <span><?= $fetch_orders['email']; ?></span></p>
            <p>address : <span><?= $fetch_orders['address']; ?></span></p>
            <p>total products : <span><?= $fetch_orders['total_products']; ?></span></p>
            <p>total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
            <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
            <form action="" method="post">
                <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                <select name="update_payment">
                    <option disabled selected><?= $fetch_orders['payment_status'] ?></option>
                    <option value="pending">pending</option>
                    <option value="completed">completed</option>
                </select>
                
                <input type="submit" name="update_order" value="update" class="option-btn">
                <a href="./admin_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn"
                onclick="return confirm('delete this order?');">delete</a>
            </form>
        </div>

        <?php 
        }
        }else{
            echo '<p class="empty">no orders placed yet!</p>';
        }        
        ?>
    </div>

</section>



<!-- custom js     -->
<script src="./assets/js/admin.js"></script>
</body>
</html>