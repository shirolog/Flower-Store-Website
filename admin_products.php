<?php 
require('./config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location:./login.php');
    exit();
}

if(isset($_POST['add_product'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './assets/uploaded_img/'.$image;

    $select_products = $conn->prepare("SELECT * FROM `products` WHERE name= ?");
    $select_products->execute(array($name));

    if($select_products->rowCount() > 0){
        $message[] = 'product name already exist!';
    }else{
        $insert_products = $conn->prepare("INSERT INTO `products` (name, details, price, image)
        VALUES(?, ?, ?, ?)");
        $insert_products->execute(array($name,$details, $price, $image));

        if($insert_products){
            if($image_size > 2000000){
                $message[] = 'image size is too large!';
            }else{
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'product added successfully!';
            }
        }

    }
    $_SESSION['message'] = $message;
    header('Location: ./admin_products.php');
    exit();
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    $select_products = $conn->prepare("SELECT image FROM `products` WHERE id= ?");
    $select_products->execute(array($delete_id));
    $fetch_products = $select_products->fetch(PDO::FETCH_ASSOC);

    unlink('./assets/uploaded_img/'.$fetch_products['image']);
    $delete_products = $conn->prepare("DELETE FROM `products` WHERE id= ?");
    $delete_products->execute(array($delete_id));
    $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid= ?");
    $delete_wishlist->execute(array($delete_id));
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid= ?");
    $delete_cart->execute(array($delete_id));
    header('Location:./admin_products.php');
    exit();
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/admin_style.css">
</head>
<body>
<?php require('./admin_header.php'); ?>  

<!-- add-products section -->

<section class="add-products">

    <form action="" method="post" enctype="multipart/form-data">
        <h3>add new product</h3>
        <input type="text" name="name" class="box" required
        placeholder="enter product name">
        <input type="number" name="price" class="box" min="0" required
        placeholder="enter product price">
        <textarea name="details" class="box" required cols="30" rows="10"
        placeholder="enter product details"></textarea>
        <input type="file" name="image" class="box" required
        accept="image/jpg, image/png, image/jpeg">
        <input type="submit" name="add_product" class="btn" value="add product">
    </form>
</section>

<!-- show-pruducts section -->
<section class="show-products">

    <div class="box-container">
        <?php 
        $select_products = $conn->prepare("SELECT * FROM  `products`");
        $select_products->execute();
        if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){                        
        ?>
            <div class="box">
                <div class="price">$<?= $fetch_products['price']; ?>/-</div>
                <img src="./assets/uploaded_img/<?= $fetch_products['image']; ?>" class="image" alt="">
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="details"><?= $fetch_products['details']; ?></div>
                <a href="./admin_update_product.php?update=<?= $fetch_products['id']; ?>"
                class="option-btn">update</a>
                <a href="./admin_products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn"
                onclick="return confirm('delete this product?');">delete</a>
            </div>
        <?php 
        }
        }else{
          echo '<p class="empty">no products added yet!</p>';  
        }
        ?>
    </div>

</section>





<!-- custom js     -->
<script src="./assets/js/admin.js"></script>
</body>
</html>