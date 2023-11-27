<?php 
require('./config.php');
session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('Location:./login.php');
    exit();
}

if(isset($_POST['update_product'])){
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $update_p_id = $_POST['update_p_id'];
    $update_p_id = filter_var($update_p_id, FILTER_SANITIZE_STRING);

    $update_products = $conn->prepare("UPDATE  `products` SET name= ?, details= ?, price= ? WHERE id= ?");
    $update_products->execute(array( $name, $details, $price, $update_p_id));


    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = './assets/uploaded_img/'.$image;
    $old_image = $_POST['update_p_img'];
    $old_image = filter_var($update_p_img, FILTER_SANITIZE_STRING);

    if(!empty($image)){
        if($image_size > 2000000){
            $message[] = 'image file size is too large!';
        }else{
            $update_products = $conn->prepare("UPDATE `products` SET image= ? WHERE id= ?");
            $update_products->execute(array($image, $update_p_id));
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('./assets/uploaded_img/'.$old_image);
            $message[] = 'image updated successfully!';
        }
        $message[] = 'product update successfully!';
    }
    $_SESSION['message'] = $message;
    header('Location: ./admin_update_product.php?update='. $update_p_id);
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update product</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/admin_style.css">
</head>
<body>
<?php require('./admin_header.php'); ?>  

<!-- update-product section -->
<section class="update-product">

    <?php 
    if(!isset($_GET['update'])){
        $_GET['update'] = '';
    }
    $update_id = $_GET['update'];
    $select_products= $conn->prepare("SELECT * FROM  `products` WHERE id= ?");
    $select_products->execute(array($update_id));
    if($select_products->rowCount() > 0){
        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>

    <form action="" method="post" enctype="multipart/form-data"">
        <img class="image" src="./assets/uploaded_img/<?= $fetch_products['image']; ?>" alt="">
        <input type="hidden" name="update_p_id" value="<?= $fetch_products['id']; ?>">
        <input type="hidden" name="update_p_img" value="<?= $fetch_products['image']; ?>">
        <input type="text" name="name" class="box" value="<?= $fetch_products['name']; ?>" required
        placeholder="enter product name">
        <input type="number" name="price" class="box" min="0" value="<?= $fetch_products['price']; ?>" required
        placeholder="enter product price">
        <textarea name="details" class="box" required cols="30" rows="10" 
        placeholder="enter product details"><?= $fetch_products['details']; ?></textarea>
        <input type="file" name="image" class="box" 
        accept="image/jpg, image/png, image/jpeg">
        <input type="submit" name="update_product" class="btn" value="update product">
        <a href="./admin_products.php" class="option-btn">go back</a>
    </form>

    <?php 
    }
    }else{
        echo '<p class="empty">no update product select</p>';
    }    
    ?>

</section>



<!-- custom js     -->
<script src="./assets/js/admin.js"></script>
</body>
</html>