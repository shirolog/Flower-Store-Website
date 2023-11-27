<?php 
require('./config.php');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location:./login.php');
    exit();
}




if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $dlelete_cart = $conn->prepare("DELETE FROM `cart` WHERE id= ?");
    $dlelete_cart->execute(array($delete_id));
    header('Location: ./cart.php');
    exit();

}


if(isset($_GET['delete_all'])){

    $dlelete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id= ?");
    $dlelete_cart->execute(array($user_id));
    header('Location: ./cart.php');
    exit();

}

if(isset($_POST['update_qty'])){

    $cart_id = $_POST['cart_id'];
    $cart_id = filter_var($cart_id, FILTER_SANITIZE_STRING);
    $cart_qty= $_POST['cart_qty'];
    $cart_qty = filter_var($cart_qty, FILTER_SANITIZE_STRING);

    $update_cart = $conn->prepare("UPDATE `cart` SET  quantity= ? WHERE id= ? ");
    $update_cart->execute(array($cart_qty, $cart_id));
    $message[] = 'cart quantity updated!';
    $_SESSION['message'] = $message;
    header('Location:./cart.php');
    exit();

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php  require('./header.php'); ?>    

<!-- heading section -->
<div class="heading">
    <h3>shopping cart</h3>
    <p><a href="./home.php">home</a> / cart</p>

</div>


<!-- cart section -->
<section class="shopping-cart">

    <h1 class="title">shopping cart</h1>

    <div class="box-container">
        <?php 
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ? ");
        $select_cart->execute(array($user_id));
        if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
        ?>

            <div action="" method="post" class="box">
                <a href="./cart.php?delete=<?= $fetch_cart['id']; ?>"
                class="fas fa-times" onclick="return confirm('delete this from cart?')"></a>
                <a href="./view_page.php?pid=<?= $fetch_cart['pid']; ?>" 
                class="fas fa-eye"></a>
                <img src="./assets/uploaded_img/<?= $fetch_cart['image']; ?>" class="image" alt="">
                <div class="name"><?= $fetch_cart['name']; ?></div>
                <div class="price">$<?= $fetch_cart['price']; ?>/-</div>
                <form action="" method="post">
                    <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                    <input type="number" name="cart_qty" min="1" class="qty" value="<?= $fetch_cart['quantity'] ?>">
                    <input type="submit" name="update_qty" class="option-btn" value="update">
                </form>
                <div class="sub-total"> sub-total : 
                <span>$<?= $sub_total = ($fetch_cart['quantity'] *  $fetch_cart['price']);?>/-</span></div>
            </div>
        <?php 
            $grand_total += $sub_total;
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
    </div>

    <div class="more-btn">
    <a href="./cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'' : 'disabled' ?>" 
    onclick="return confirm('delete all from cart?')">delete all</a>
    </div>

    <div class="cart_total">
        <p>grand total : <span><?= $grand_total; ?> /-</span></p>
        <a href="./shop.php" class="option-btn">continue shopping</a>
        <a href="./checkout.php" class="btn <?= ($grand_total > 1)?'' : 'disabled' ?>">proceed to checkout</a>
    </div>
</section>



<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>