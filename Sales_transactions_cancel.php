<?php
    require 'config.php';
    $s_t_id = $_GET['sales_transaction_id'];
    $sql = "DELETE FROM `sales_transactions` WHERE sales_transaction_id=$s_t_id";
    $result = mysqli_query($conn,$sql);
    $sql1 = "DELETE FROM `sales` WHERE sales_transaction_id=$s_t_id";
    $result1 = mysqli_query($conn,$sql1);
    if($result && $result1){
        header("location: Sales_transactions.php");
    }else{
        echo "error";
    }
?>