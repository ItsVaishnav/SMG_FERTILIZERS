<?php
require 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroGuard Dashboard</title>
    <link rel="stylesheet" href="css/style.css?<?php echo time(); ?>">
    <style>
        .image-card{
            width: 300px;
            height: 200px;
            overflow: hidden;
            margin: 30px 0px;
            border-radius: 25px;
        }

        .image-card img {
            width: 300px;
            height: 200px;
            transition: all 1s ease-in-out;
        }

        .image-card img:hover{
            transform: scale(1.5);
            cursor: pointer;
        }

        .flex-flex-flex {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            width: 100%;
            flex-wrap: wrap;
        }

        .h1 {
            margin: 20px 0px;
        }
    </style>
</head>

<body>
    <div class="main-main-main">
        <?php require('Components/nav.php') ?>
        <div class="main-content" id="main-content">
            <?php
            require('Components/header.php');
            ?>

            <h1 class="h1">-: Image Gallery :-</h1>
            <div class="dashboard">
                <div class="flex-flex-flex">
                    <div class="image-card">
                        <img src="images/01.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/02.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/03.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/04.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/05.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/06.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/07.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/08.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/09.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/10.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/11.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/12.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/13.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/14.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/15.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/16.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/17.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/18.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/19.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/20.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/21.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/22.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/23.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/24.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/25.jpg" alt="">
                    </div>
                    <div class="image-card">
                        <img src="images/26.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

</html>