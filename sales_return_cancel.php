<?php
    require 'config.php';
    $s_r_id = $_GET['return_id'];
    $s_t_id = 0;

    $sql = "SELECT * FROM `sales_return` WHERE return_id=$s_r_id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $s_t_id = $row['sales_transaction_id'];
        $p_id = $row['p_id'];
        $quantity = $row['quantity'];
        $p_total = $row['p_total'];
        
        $sql1 = "SELECT * FROM `sales` WHERE sales_transaction_id=$s_t_id AND p_id=$p_id";
        $result1 = mysqli_query($conn,$sql1);
        while($row1 = mysqli_fetch_assoc($result1)){
            $pre_total = $row1['p_total'];
            $pre_quantity = $row1['quantity'];
        }

    }

    $sql = "DELETE FROM `sales_return` WHERE return_id=$s_r_id";
    $result = mysqli_query($conn,$sql);

    $sql1 = "DELETE FROM `sales_return_manage` WHERE return_id=$s_r_id";
    $result1 = mysqli_query($conn,$sql1);
    if($result && $result1){
        header("location: Sales_transactions.php");
    }else{
        echo "error";
    }
?>