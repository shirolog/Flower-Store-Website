<?php 
if(isset($_SESSION['message'])){
    foreach($_SESSION['message'] as $message){
        echo '<div class="message">
        <span>'.$message.'</span>
        <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
    }
        unset($_SESSION['message']);
}
?>

<!-- header section -->
<header class="header">

    <section class="flex">

        <a href="./home.php" class="logo">flowers.</a>

        <nav class="navbar">
            <ul>
                <li><a href="./home.php">home</a></li>
                <li><a href="#">page +</a>
                    <ul>
                        <li><a href="./about.php">about</a></li>
                        <li><a href="./contact.php">contact</a></li>
                    </ul>
                </li>
                <li><a href="./shop.php">shop</a></li>
                <li><a href="./orders.php">orders</a></li>
                <li><a href="#">account +</a>
                    <ul>
                       <li><a href="./login.php">login</a></li> 
                       <li><a href="./register.php">register</a></li> 
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="./search_page.php"><i class="fas fa-search"></i></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php 
            $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE user_id= ?");
            $select_wishlist->execute(array($user_id));
            $count_wishlist = $select_wishlist->rowCount();
            ?>
            <a href="./wishlist.php"><i class="fas fa-heart"></i> <span>(<?= $count_wishlist; ?>)</span></a>
            <?php 
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id= ?");
            $select_cart->execute(array($user_id));
            $count_cart = $select_cart->rowCount();
            ?>
            <a href="./cart.php"><i class="fas fa-shopping-cart"></i> <span>(<?= $count_cart; ?>)</span></a>
        </div>

        
        <div class="account-box">
            <p>username : <span><?= $_SESSION['user_name'];?></span></p>
            <p>email : <span><?= $_SESSION['user_email'];?></span></p>
            <a href="./logout.php" class="delete-btn">logout</a>
        </div>

    </section>

</header>