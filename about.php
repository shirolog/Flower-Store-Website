<?php 
require('./config.php');
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('Location:./login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

    
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- custom css -->
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
<?php  require('./header.php'); ?>    

<!-- heading section -->
<div class="heading">
    <h3>about us</h3>
    <p><a href="./home.php">home</a> / about</p>
</div>

<!-- about section -->
<section class="about">

    <div class="flex">

        <div class="image">
            <img src="./assets/images/about-img-1.png" alt="">
        </div>
        
        <div class="content">
            <h3>why choose us?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum at iure nihil 
            sint culpa enim aliquid fugiat nostrum corrupti debitis.</p>
            <a href="./shop.php" class="btn">shop now</a>
        </div>
    </div>

    <div class="flex">
        
        <div class="content">
            <h3>what we provide?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum at iure nihil 
            sint culpa enim aliquid fugiat nostrum corrupti debitis.</p>
            <a href="./contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="./assets/images/about-img-2.jpg" alt="">
        </div>
    </div>

    
    <div class="flex">

        <div class="image">
            <img src="./assets/images/about-img-3.jpg" alt="">
        </div>
        
        <div class="content">
            <h3>who we are?</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum at iure nihil 
            sint culpa enim aliquid fugiat nostrum corrupti debitis.</p>
            <a href="#reviews" class="btn">client reviews</a>
        </div>
    </div>

</section>

<!-- reviews section -->
<section class="reviews" id="reviews">

    <h1 class="title">client's reviews</h1>

    <div class="box-container">

        <div class="box">
            <img src="./assets/images/pic-1.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

        <div class="box">
            <img src="./assets/images/pic-2.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

        <div class="box">
            <img src="./assets/images/pic-3.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

        <div class="box">
            <img src="./assets/images/pic-4.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

        <div class="box">
            <img src="./assets/images/pic-5.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

        <div class="box">
            <img src="./assets/images/pic-6.png" alt="">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
            Esse iusto ipsum asperiores qui delectus repellat commodi eligendi 
            blanditiis voluptatum id!</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <h3>john deo</h3>
        </div>

    </div>

</section>



<?php require('./footer.php'); ?>

<!-- custom js     -->
<script src="./assets/js/app.js"></script>
</body>
</html>