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
    header('Location: ./home.php');
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
    header('Location: ./home.php');
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

<!-- home section -->
<section class="home">

    <div class="content">
        <h3>new collections</h3>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. 
        Temporibus, illum nemo iusto voluptates delectus adipisci.</p>
        <a href="./about.php" class="btn">discover more</a>
    </div>

</section>

<!-- products section -->
<section class="products">

    <div class="title">latest products</div>

    <div class="box-container">
        <?php 
        $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
        $select_products->execute();
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
        ?>

            <form action="" method="post" class="box">
                <a href="./view_page.php?pid=<?= $fetch_products['id']; ?>"><i class="fas fa-eye"></i></a>
                <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                <img class="image" src="./assets/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                <div class="name"><?= $fetch_products['name']; ?></div>
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
            echo '<p class="empty">no products added yet!</p>';
        }        
        ?>
    </div>

    <div class="more-btn">
        <a href="./shop.php" class="option-btn">load more</a>
    </div>
</section>

<!-- home-contact section -->
<section class="home-contact">

    <div class="content">
        <h3>have any questions?</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
        Est unde saepe accusantium quidem debitis! Ex!</p>
        <a href="./contact.php" class="btn">contact us</a>
    </div>

</section>




<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>