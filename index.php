
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
    </style>
</head>
<body>
    <div class="main-main-main">
        <?php require('Components/nav.php')?>
        <div class="main-content" id="main-content">
            <?php
                require('Components/header.php');
            ?>
            
            <div class="dashboard">
                <div class="card">Return Records <span>
                <?php 
                        $sql = "SELECT * FROM `sales_return`";
                        $result = mysqli_query($conn,$sql);
                        echo mysqli_num_rows($result);
                        ?>
                </span></div>
                <div class="card">Sales Records <span>
                <?php 
                        $sql = "SELECT * FROM `sales_transactions`";
                        $result = mysqli_query($conn,$sql);
                        echo mysqli_num_rows($result);
                        ?>
                </span></div>
                <div class="card">Suppliers <span>
                    <?php 
                        $sql = "SELECT * FROM `suppliers`";
                        $result = mysqli_query($conn,$sql);
                        echo mysqli_num_rows($result);
                    ?>
                </span></div>
                <div class="card">Items <span>
                <?php 
                        $sql = "SELECT * FROM `products`";
                        $result = mysqli_query($conn,$sql);
                        echo mysqli_num_rows($result);
                    ?>
                </span></div>
                <div class="card">Farmers <span>
                <?php 
                        $sql = "SELECT * FROM `farmers`";
                        $result = mysqli_query($conn,$sql);
                        echo mysqli_num_rows($result);
                    ?>
                </span></div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
