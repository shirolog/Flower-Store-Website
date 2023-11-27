<?php 
require('./config.php');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location:./login.php');
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
    $product_qty = 1;

    
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
    header('Location: ./wishlist.php');
    exit();
}

if(isset($_GET['delete'])){

    $delete_id = $_GET['delete'];

    $dlelete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE id= ?");
    $dlelete_wishlist->execute(array($delete_id));
    header('Location: ./wishlist.php');
    exit();

}


if(isset($_GET['delete_all'])){

    $dlelete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id= ?");
    $dlelete_wishlist->execute(array($user_id));
    header('Location: ./wishlist.php');
    exit();

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wishlist</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php  require('./header.php'); ?>    

<!-- heading section -->
<div class="heading">
    <h3>your wishlist</h3>
    <p><a href="./home.php">home</a> / wishlist</p>
</div>

<!-- wishlist section -->
<section class="wishlist">

    <h1 class="title">product added</h1>

    <div class="box-container">
        <?php 
        $grand_total = 0;
        $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id= ? ");
        $select_wishlist->execute(array($user_id));
        if($select_wishlist->rowCount() > 0){
            while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
        ?>

            <form action="" method="post" class="box">
                <a href="./wishlist.php?delete=<?= $fetch_wishlist['id']; ?>"
                class="fas fa-times" onclick="return confirm('delete this from wishlist?')"></a>
                <a href="./view_page.php?pid=<?= $fetch_wishlist['pid']; ?>" 
                class="fas fa-eye"></a>
                <img src="./assets/uploaded_img/<?= $fetch_wishlist['image']; ?>" class="image" alt="">
                <div class="name"><?= $fetch_wishlist['name']; ?></div>
                <div class="price">$<?= $fetch_wishlist['price']; ?>/-</div>
                <input type="hidden" name="product_id" value="<?= $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="product_name" value="<?= $fetch_wishlist['name']; ?>">
                <input type="hidden" name="product_price" value="<?= $fetch_wishlist['price']; ?>">
                <input type="hidden" name="product_image" value="<?= $fetch_wishlist['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
        <?php 
            $grand_total += $fetch_wishlist['price'];
        }
        }else{
            echo '<p class="empty">your wishlist is empty</p>';
        }
        ?>
    </div>

    <div class="wishlist_total">
        <p>grand total : <span><?= $grand_total; ?> /-</span></p>
        <a href="./shop.php" class="option-btn">continue shopping</a>
        <a href="./wishlist.php?delete_all" class="delete-btn 
        <?= ($grand_total > 1)?'' : 'disabled' ?>" onclick="return confirm('delete all from wishlist?')">delete all</a>
    </div>
</section>



<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>