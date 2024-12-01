<?php
require_once "config.php";
$insert = false;
$update = false;
$delete = false;
$p = 0;
$return_id = $_GET['return_id'];
$sales_transaction_id = 0;
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

$sq = "SELECT * FROM `sales_return` WHERE return_id=$return_id";
$res = mysqli_query($conn, $sq);
while ($ro = mysqli_fetch_assoc($res)) {
    $sales_transaction_id = $ro['sales_transaction_id'];
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    // To update the values back to the previous transaction 
    $sql = "SELECT * FROM `sales_return_manage` WHERE sales_return_id=$sno";
    $result = mysqli_query($conn , $sql);
    while($row = mysqli_fetch_assoc($result)){
        $sales_transaction_id = $row['sales_transaction_id'];
        $p_id = $row['p_id'];
        $quantity = $row['quantity'];
        $p_total = $row['p_total'];
    }

    

    // Delete the transaction from the sales return table 
    $sql = "DELETE FROM `sales_return_manage` WHERE `sales_return_id` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
    $delete = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST["snoEdit"];
        $p_id = $_POST["product_nameEdit"];
        $product_quantity = $_POST["farmer_phoneEdit"];
        $p_total = 0;
        $stock = 0;
        $sqlp = "SELECT * FROM `products` WHERE p_id=$p_id";
        $resultp = mysqli_query($conn, $sqlp);
        while ($rowp = mysqli_fetch_assoc($resultp)) {
            $stock = $rowp['quantity'];
            $p_total = $rowp['price'] * $product_quantity;
        }
        // Sql query to be executed
        $sql = "UPDATE `sales` SET `p_id` = '$p_id' , `quantity` = '$product_quantity' ,`p_total` = $p_total WHERE `sales`.`sales_item_id` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        // Inserting the Data
        $p_id = $_POST["p_id"];
        $product_quantity = $_POST["product_quantity"];
        $farmers_id = 0;

        $sqlfarmer = "SELECT * FROM `sales_transactions` where sales_transaction_id=$sales_transaction_id";
        $resultfarmer = mysqli_query($conn, $sqlfarmer);
        while ($row = mysqli_fetch_assoc($resultfarmer)) {
            $farmers_id = $row["farmer_id"];
        }

        // Getting the price of the product
        $p_total = 0;
        $sqlp = "SELECT * FROM `products` WHERE p_id=$p_id";
        $resultp = mysqli_query($conn, $sqlp);
        while ($rowp = mysqli_fetch_assoc($resultp)) {
            $p_total = $rowp['price'] * $product_quantity;
        }

        // Adding the products to the cart

        $sql = "INSERT INTO `sales_return_manage` (`p_id`, `quantity`,`p_total`,`farmer_id`, `sales_transaction_id` , `return_id`) VALUES ('$p_id', '$product_quantity','$p_total','$farmers_id','$sales_transaction_id','$return_id')";
        $result = mysqli_query($conn, $sql);

        $sql = "SELECT * FROM `sales` WHERE p_id=$p_id";
        $result = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($result)){
            $pre_total = $row['p_total'];
            $pre_quantity = $row['quantity'];
        }
        $p_total = $pre_total - $p_total;
        $product_quantity = $pre_quantity - $product_quantity;

        $sql = "UPDATE `sales` SET `quantity`='$product_quantity',`p_total`='$p_total' WHERE p_id=$p_id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $insert = true;
        } else {
            echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales Return</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/style.css" importance="">
    <style>
        .flex-box {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <div class="main-main-main">
        <!-- Edit Modal -->
        <div class="modal fade" id="editModall" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="managesales.php?sales_transaction_id=<?php echo $sales_transaction_id ?>"
                        method="POST">
                        <div class="modal-body">
                            <input required type="hidden" name="snoEdit" id="snoEdit">
                            <div class="form-group">
                                <label for="product_nameEdit">Product Name</label>
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="product_nameEdit">
                                    <option selected id="product_nameEdit">Select Products</option>
                                    <?php
                                    $sql1 = "SELECT * FROM `products`";
                                    $result1 = mysqli_query($conn, $sql1);
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        echo '<option value="' . $row1['p_id'] . '">' . $row1['product_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="farmer_phone">Quantity</label>
                                <input required type="number" class="form-control" id="farmer_phoneEdit"
                                    name="farmer_phoneEdit" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Close Edit Modal -->

        <?php require('Components/nav.php') ?>

        <div class="main-content" id="main-content">
            <?php
            require('Components/header.php');
            ?>

            <?php
            if ($insert) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> The New Farmer has Been Added Successfully
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span>
                            </button>
                        </div>";
            }
            ?>
            <?php
            if ($delete) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Farmer has been deleted successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <?php
            if ($update) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Sales Details has been updated successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <div class="products">
                <div class="container my-4">
                    <h2>Update Sales Return</h2>
                    <form action="manage_sales_return.php?return_id=<?php echo $return_id ?>"
                        method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="farmer_name">Product Name</label>
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="p_id">
                                    <option selected>Select Products</option>
                                    <?php
                                    $sql1 = "SELECT * FROM `sales` WHERE sales_transaction_id=$sales_transaction_id";
                                    $result1 = mysqli_query($conn, $sql1);
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $p_idd = $row1['p_id'];
                                        $ss = "SELECT * FROM `products` WHERE p_id=$p_idd";
                                        $res = mysqli_query($conn, $ss);
                                        while ($rr = mysqli_fetch_assoc($res)){
                                            echo '<option value="' . $rr['p_id'] . '">' . $rr['product_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="farmer_phone">Return Quantity</label>
                                <input required type="number" class="form-control" id="farmer_phone"
                                    name="product_quantity" aria-describedby="quantity">
                            </div>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Transaction</button>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <h1>Sales Return </h1>
                </div>
                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `sales_return_manage`WHERE return_id=$return_id";
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
                                    <td> <button class='edit btn btn-sm btn-primary' id=" . $row['sales_return_id'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['sales_return_id'] . ">Delete</button>  </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="container">
                    <h1>Review of Sales Transaction</h1>
                </div>
                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                                <th scope="col">Total</th>
                                <th scope="col">Actions</th>
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
                                    <td><button class='delete btn btn-sm btn-warning' id=d" . $row['sales_item_id'] . ">Return All Items</button>  </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
            <div class="flex-box">
                <a href="Sales_transactions.php"><button class="btn btn-primary mx-4">Save</button></a>
                <a href="Sales_transactions_cancel.php?sales_transaction_id=<?php echo $sales_transaction_id; ?>"><button
                        class="btn btn-warning mx-4">Close</button></a>
            </div>
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
        function handelAdd() {
            $('#addModal').modal('toggle');
        }
    </script>
    <script>
        // This js is related to the Add and Edit the elements in the table 

        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                farmer_name = tr.getElementsByTagName("td")[0].innerText;
                farmer_phone = tr.getElementsByTagName("td")[1].innerText;
                product_nameEdit.value = <?php echo $p; ?>;
                product_nameEdit.innerHTML = farmer_name;
                farmer_phoneEdit.value = farmer_phone;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModall').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this Product!")) {
                    console.log("yes");
                    window.location = `manage_sales_return.php?delete=${sno}&return_id=<?php echo $return_id; ?>`;
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>
    <script src="js/script.js?<?php echo time(); ?>"></script>
</body>

</html>