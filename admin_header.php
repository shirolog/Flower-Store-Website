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

<header class="header">

    <section class="flex">
        <a href="./admin_page.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="./admin_page.php">home</a>
            <a href="./admin_products.php">products</a>
            <a href="./admin_orders.php">orders</a>
            <a href="./admin_users.php">users</a>
            <a href="./admin_contacts.php">messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn"><i class="fas fa-bars"></i></div>
            <div id="user-btn"><i class="fas fa-user"></i></div>
        </div>

        <div class="account-box">
            <p>username : <span><?= $_SESSION['admin_name'];?></span></p>
            <p>email : <span><?= $_SESSION['admin_email'];?></span></p>
            <a href="./logout.php" class="delete-btn">logout</a>
            <div>new <a href="./login.php">login</a> | <a href="./register.php">register</a></div>
        </div>
    </section>
</header>