<?php
$insert = false;
$update = false;
$delete = false;
// Connect to the Database 

require_once("config.php");

// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `products` WHERE `p_id` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $product_name = $_POST["product_nameEdit"];
        $product_price = $_POST["product_priceEdit"];
        $product_quentity = $_POST["product_quentityEdit"];
        $product_category = $_POST["product_category"];
        $supplier_id = $_POST["supplier_id"];

        // Sql query to be executed
        $sql = "UPDATE `products` SET `product_name` = '$product_name' , `price` = '$product_price' , `quentity` = '$product_quentity' , `category` = '$product_category' , `supplier_id` = '$supplier_id' WHERE `products`.`p_id` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        $product_name = $_POST["product_name"];
        $product_price = $_POST["product_price"];
        $product_quentity = $_POST["product_quentity"];
        $product_category = $_POST["product_category"];
        $supplier_id = $_POST["supplier_id"];

        // Sql query to be executed
        $sql = "INSERT INTO `products` ( `product_name`, `price`, `quentity`, `category`, `supplier_id`) VALUES ('$product_name', '$product_price','$product_quentity','$product_category','$supplier_id')";
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
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/style.css" importance="">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="main-main-main">
        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit this Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="products.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="form-group">
                                <label for="product_nameEdit">Product Name </label>
                                <input type="text" class="form-control" id="product_nameEdit" name="product_nameEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="priceEdit">Price </label>
                                <input type="number" class="form-control" id="priceEdit" name="product_priceEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="quentityEdit">Quentity </label>
                                <input type="number" class="form-control" id="quentityEdit" name="product_quentityEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="product_category">
                                    <option selected>Select Category</option>
                                    <option value="Fertilizers">Fertilizers</option>
                                    <option value="Pestisites" active>Pestisites</option>
                                    <option value="Seeds">Seeds</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="supplier_id">
                                    <option selected>Select Supplier</option>
                                    <?php
                                    $sql2 = "SELECT * FROM `suppliers`";
                                    $result2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        echo '<option value="' . $row2['supplier_id'] . '">' . $row2['supplier_name'] . '</option>';
                                    }
                                    ?>
                                </select>
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

        <!-- Add Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Products</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="products.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="pname">Product Name </label>
                                <input type="text" class="form-control" id="pname" name="product_name"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="price">Price </label>
                                <input type="number" class="form-control" id="price" name="product_price"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="quentity">Quentity </label>
                                <input type="number" class="form-control" id="quentity" name="product_quentity"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" id="categoryEdit" name="product_category">
                                    <option selected>Select Category</option>
                                    <option value="Fertilizers">Fertilizers</option>
                                    <option value="Pestisites">Pestisites</option>
                                    <option value="Seeds">Seeds</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" id="supplierEdit" name="supplier_id">
                                    <option selected>Select Supplier</option>
                                    <?php
                                    $sql2 = "SELECT * FROM `suppliers`";
                                    $result2 = mysqli_query($conn, $sql2);
                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                        echo '<option value="' . $row2['supplier_id'] . '">' . $row2['supplier_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Add Modal -->



        <?php require('Components/nav.php') ?>

        <div class="main-content" id="main-content">
            <?php
            require('Components/header.php');
            ?>

            <?php
            if ($insert) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> Product has Been Added Successfully
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span>
                            </button>
                        </div>";
            }
            ?>
            <?php
            if ($delete) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Your Product has been deleted successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <?php
            if ($update) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Your Product has been updated successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <div class="products">
                <div class="container my-4">
                    <h2>Products</h2>
                    <button class='add btn btn-sm btn-primary' id="" onclick="handelAdd()">Add Products</button>
                </div>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price (Rs.)</th>
                                <th scope="col">Quentity</th>
                                <th scope="col">Category</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- `product_name`, `price`, `quentity`, `category`, `supplier_id` -->
                            <?php
                            $sql = "SELECT * FROM `products`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quentity'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>";
                                $idd = $row['supplier_id'];
                                $sql2 = "SELECT * FROM `suppliers` WHERE supplier_id=$idd";
                                $result2 = mysqli_query($conn, $sql2);
                                while ($row2 = mysqli_fetch_assoc($result2)) {
                                    echo $row2['supplier_name'];
                                }
                                echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>
                                    <td> <button class='edit btn btn-sm btn-primary' id=" . $row['p_id'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['p_id'] . ">Delete</button>  </td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <!-- To Generate Stock Report For All -->

    <div class="products hidden" id="makepdf">
        <div class="container my-4">
            <h2>SMG Fertilizers Stock Report</h2>
        </div>

        <div class="container my-4">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quentity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Last Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `products`";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quentity'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>";
                        $idd = $row['supplier_id'];
                        $sql2 = "SELECT * FROM `suppliers` WHERE supplier_id=$idd";
                        $result2 = mysqli_query($conn, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo $row2['supplier_name'];
                        }
                        echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>

    <!-- To Generate Stock Report For Fertilizers -->

    <div class="products hidden" id="makepdff">
        <div class="container my-4">
            <h2>SMG Fertilizers Stock Report</h2>
        </div>

        <div class="container my-4">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quentity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Last Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `products` WHERE category='Fertilizers'";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quentity'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>";
                        $idd = $row['supplier_id'];
                        $sql2 = "SELECT * FROM `suppliers` WHERE supplier_id=$idd";
                        $result2 = mysqli_query($conn, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo $row2['supplier_name'];
                        }
                        echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>

    <!-- To Generate Stock Report For Pestisites -->

    <div class="products hidden" id="makepdfp">
        <div class="container my-4">
            <h2>SMG Fertilizers Stock Report</h2>
        </div>

        <div class="container my-4">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quentity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Last Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `products`WHERE category='Pestisites'";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quentity'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>";
                        $idd = $row['supplier_id'];
                        $sql2 = "SELECT * FROM `suppliers` WHERE supplier_id=$idd";
                        $result2 = mysqli_query($conn, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo $row2['supplier_name'];
                        }
                        echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>

    <!-- To Generate Stock Report For Seeds -->

    <div class="products hidden" id="makepdfs">
        <div class="container my-4">
            <h2>SMG Fertilizers Stock Report</h2>
        </div>

        <div class="container my-4">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quentity</th>
                        <th scope="col">Category</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Last Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `products` WHERE category='Seeds'";
                    $result = mysqli_query($conn, $sql);
                    $sno = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $sno = $sno + 1;
                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quentity'] . "</td>
                                    <td>" . $row['category'] . "</td>
                                    <td>";
                        $idd = $row['supplier_id'];
                        $sql2 = "SELECT * FROM `suppliers` WHERE supplier_id=$idd";
                        $result2 = mysqli_query($conn, $sql2);
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            echo $row2['supplier_name'];
                        }
                        echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <hr>
    </div>
    </div>
    </div>

    <button id="button" class="btn btn-primary mx-4">Generate Overall Stock Report</button>
    <button id="buttonf" class="btn btn-primary mx-4">Generate Fertilizers Stock Report</button>
    <button id="buttonp" class="btn btn-primary mx-4">Generate Pestisites Stock Report</button>
    <button id="buttons" class="btn btn-primary mx-4">Generate Seeds Stock Report</button>


    <script>
        let button = document.getElementById("button");
        let buttonf = document.getElementById("buttonf");
        let buttonp = document.getElementById("buttonp");
        let buttons = document.getElementById("buttons");

        let makepdf = document.getElementById("makepdf");
        let makepdff = document.getElementById("makepdff");
        let makepdfp = document.getElementById("makepdfp");
        let makepdfs = document.getElementById("makepdfs");

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

        buttonf.addEventListener("click", function () {
            let mywindow = window.open("", "PRINT",
                "height=700,width=1200");
            mywindow.document.write(makepdff.innerHTML);
            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            mywindow.close();
            return true;
        });

        buttonp.addEventListener("click", function () {
            let mywindow = window.open("", "PRINT",
                "height=700,width=1200");
            mywindow.document.write(makepdfp.innerHTML);
            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            mywindow.close();
            return true;
        });

        buttons.addEventListener("click", function () {
            let mywindow = window.open("", "PRINT",
                "height=700,width=1200");
            mywindow.document.write(makepdfs.innerHTML);
            mywindow.document.close();
            mywindow.focus();
            mywindow.print();
            mywindow.close();
            return true;
        });
    </script>


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
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                tr = e.target.parentNode.parentNode;
                product_name = tr.getElementsByTagName("td")[0].innerText;
                price = tr.getElementsByTagName("td")[1].innerText;
                quentity = tr.getElementsByTagName("td")[2].innerText;
                console.log(product_name, price, quentity);
                product_nameEdit.value = product_name;
                priceEdit.value = price;
                quentityEdit.value = quentity;
                snoEdit.value = e.target.id;
                console.log(e.target.id)
                $('#editModal').modal('toggle');
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this Product!")) {
                    console.log("yes");
                    window.location = `products.php?delete=${sno}`;
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