<?php
    require 'config.php';
    $sales_transaction_id = $_GET['sales_transaction_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Sales Transaction </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
        .flex-flex{
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="container">
        <div class="card" id="makepdf">
        <div class="products">
                <div class="container my-4">
                    <h1>SMG Fertilizers Nimsod</h1>
                    <h6>Contact No : 9011153942</h6>
                    <hr>
                    <?php
                        $farm_id = "";
                        $sql = "SELECT * FROM `sales_transactions` WHERE sales_transaction_id=$sales_transaction_id";
                        $result = mysqli_query($conn , $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            $farm_id = $row['farmer_id'];
                        }
                        $sqll = "SELECT * FROM `farmers` WHERE farmer_id=$farm_id";
                        $resultt = mysqli_query($conn,$sqll);
                        while($roww = mysqli_fetch_assoc($resultt)){
                            echo "Farmer Name : ".$roww['farmer_name']."";
                        }
                        echo "<br>";
                        $sql = "SELECT * FROM `sales_transactions` WHERE sales_transaction_id=$sales_transaction_id";
                        $result = mysqli_query($conn , $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            echo "Date And Time : ".$row['Date_Time']."";
                        }
                    ?>
                </div>
                <hr>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quentity</th>
                                <th scope="col">Price (Rs.)</th>
                                <th scope="col">Total (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `sales`WHERE sales_transaction_id=$sales_transaction_id";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>";
                                $p = $row['p_id'];
                                $sqlp = "SELECT * FROM `products` WHERE p_id=$p";
                                $resultp = mysqli_query($conn, $sqlp);
                                while ($rowp = mysqli_fetch_assoc($resultp)) {
                                    echo $rowp['product_name'];
                                }
                                echo "</td>
                                    <td>" . $row['quantity'] . "</td>
                                    <td>";
                                $p = $row['p_id'];
                                $sqlp = "SELECT * FROM `products` WHERE p_id=$p";
                                $resultp = mysqli_query($conn, $sqlp);
                                while ($rowp = mysqli_fetch_assoc($resultp)) {
                                    echo $rowp['price'];
                                }
                                echo "</td>
                                    <td>" . $row['p_total'] . "</td>
                                    </tr>";
                            }
                                $done = TRUE;
                            ?>
                            <tr>
                                
                                <td>Total Amount </td>
                                <td id="total">
                                    <?php
                                    if($done){
                                        $sql = "SELECT * FROM `sales`WHERE sales_transaction_id=$sales_transaction_id";
                                        $result = mysqli_query($conn, $sql);
                                        $total = 0;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $total +=$row['p_total'];
                                        }
                                        echo "Rs.".$total.""; 
                                    }
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
        <div class="flex-flex">
            <button class="btn btn-outline-success mx-4" id="button">Print Bill</button>
            <a href="Sales_transactions.php"><button class="btn btn-outline-danger mx-4">Close</button></a>
        </div>
    </div>
        <!-- Java Script -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>



<script>

    let button = document.getElementById("button");
    let makepdf = document.getElementById("makepdf");

    button.addEventListener("click", function () {
        let mywindow = window.open("", "PRINT",
            "height=700,width=1200");
        mywindow.document.write(makepdf.innerHTML);
        mywindow.document.close();
        mywindow.focus();
        mywindow.print();
        mywindow.close();

        return true;
    });
</script>
</body>
</html>