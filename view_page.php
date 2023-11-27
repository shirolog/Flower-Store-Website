<?php 
require('./config.php');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location:./login.php');
    exit();
}

if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
    $product_name = $_POST['product_name'];
    $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
    $product_price = $_POST['product_price'];
    $product_price = filter_var($product_price, FILTER_SANITIZE_STRING);
    $product_image = $_POST['product_image'];
    $product_image = filter_var($product_image, FILTER_SANITIZE_STRING);

    $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id= ? AND name= ?");
    $select_wishlist->execute(array($user_id, $product_name));

    
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ? AND name= ?");
    $select_cart->execute(array($user_id, $product_name));

    if($select_wishlist->rowCount() > 0){
        $message[] = 'already added to wishlist!';
    }elseif($select_cart->rowCount() > 0){
        $message[] = 'already added to cart!';
    }else{
        $insert_wishlist = $conn->prepare("INSERT INTO `wishlist` (user_id, pid, name, price, image) 
        VALUES (?, ?, ?, ?, ?)");
        $insert_wishlist->execute(array($user_id, $product_id, $product_name, $product_price, $product_image));
        $message[] = 'product added to wishlist!!';
    }
    $_SESSION['message'] = $message;
    header('Location: ./view_page.php?pid='. $product_id);
    exit();
}



if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);
    $product_name = $_POST['product_name'];
    $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
    $product_price = $_POST['product_price'];
    $product_price = filter_var($product_price, FILTER_SANITIZE_STRING);
    $product_image = $_POST['product_image'];
    $product_image = filter_var($product_image, FILTER_SANITIZE_STRING);
    $product_qty = $_POST['product_qty'];
    $product_qty = filter_var($product_qty, FILTER_SANITIZE_STRING);
    
    
    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ? AND name= ?");
    $select_cart->execute(array($user_id, $product_name));

    if($select_cart->rowCount() > 0){
        $message[] = 'already added to cart!';
    }else{

        $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) 
        VALUES (?, ?, ?, ?, ?, ?)");
        $insert_cart->execute(array($user_id, $product_id, $product_name, $product_price,
         $product_qty, $product_image));
        $message[] = 'product added to cart!';



        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id= ? AND name= ?");
        $select_wishlist->execute(array($user_id, $product_name));

        if($select_wishlist->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id= ? AND name= ?");
            $delete_wishlist->execute(array($user_id, $product_name));
        }
    }
    $_SESSION['message'] = $message;
    header('Location: ./view_page.php?pid='. $product_id);
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php  require('./header.php'); ?>    

<!-- quick-view section -->
<section class="quick-view">

    <h1 class="title">product details</h1>

    <?php
    if(!isset($_GET['pid'])){
        $_GET['pid']= '';
    } 

    if(isset($_GET['pid'])){
        $pid = $_GET['pid'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE id= ?");
        $select_products->execute(array($pid));
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
        
        <form action="" method="post" class="box">
                <img class="image" src="./assets/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                <div class="details">$<?= $fetch_products['details']; ?>/-</div>
                <input type="number" name="product_qty" class="qty" value="1" min="0">
                <input type="hidden" name="product_id" value="<?= $fetch_products['id']; ?>">
                <input type="hidden" name="product_name" value="<?= $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?= $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?= $fetch_products['image']; ?>">
                <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
    <?php 
    }
    }else{
        echo '<p class="empty">no products details available!</p>';
    } 
    }
    ?>

    <div class="more-btn">
        <a href="./home.php" class="option-btn">go to home page</a>
    </div>

</section>



<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>