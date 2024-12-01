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

        .flex-flex-flex {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap;
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
            <div class="products">
                <div class="container my-4 ">
                    <h2>Products</h2>
                    <div class="flex-flex-flex">
                        <form action="Stock.php" method="POST">
                            <input type="hidden" name="Fertilizres" id="Fertilizres">
                            <button class='add btn btn-sm btn btn-outline-success' type="submit">Stock of
                                Fertilizers</button>
                        </form>
                        <form action="Stock.php" method="POST">
                            <input type="hidden" name="Pestisites" id="Pestisites">
                            <button class='add btn btn-sm btn btn-outline-success' type="submit">Stock of
                                Pestisites</button>
                        </form>
                        <form action="Stock.php" method="POST">
                            <input type="hidden" name="Seeds" id="Seeds">
                            <button class='add btn btn-sm btn btn-outline-success' type="submit">Stock of Seeds</button>
                        </form>
                    </div>
                </div>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Product Name</th>
                                <th scope="col">Price (Rs.)</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Category</th>
                                <th scope="col">Supplier</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if (isset($_POST['Fertilizres'])) {
                                    $sql = 'SELECT * FROM `products` WHERE category="Fertilizers"';
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quantity'] . "</td>
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
                                } else if (isset($_POST['Pestisites'])) {
                                    $sql = 'SELECT * FROM `products` WHERE category="Pestisites"';
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quantity'] . "</td>
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
                                } else if (isset($_POST['Seeds'])) {
                                    $sql = 'SELECT * FROM `products` WHERE category="Seeds"';
                                    $result = mysqli_query($conn, $sql);
                                    $sno = 0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $sno = $sno + 1;
                                        echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quantity'] . "</td>
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
                                } else {
                                    echo "Error";
                                }
                            } else {
                                $sql = "SELECT * FROM `products`";
                                $result = mysqli_query($conn, $sql);
                                $sno = 0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $sno = $sno + 1;
                                    echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['product_name'] . "</td>
                                    <td>" . $row['price'] . "</td>
                                    <td>" . $row['quantity'] . "</td>
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
                        <th scope="col">Price (Rs.)</th>
                        <th scope="col">Quantity</th>
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
                                    <td>" . $row['quantity'] . "</td>
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
                        <th scope="col">Price (Rs.)</th>
                        <th scope="col">Quantity</th>
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
                                    <td>" . $row['quantity'] . "</td>
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
                        <th scope="col">Price (Rs.)</th>
                        <th scope="col">Quantity</th>
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
                                    <td>" . $row['quantity'] . "</td>
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
                        <th scope="col">Price (Rs.)</th>
                        <th scope="col">Quantity</th>
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
                                    <td>" . $row['quantity'] . "</td>
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
        <h2 class="mx-4 px-4">Generate Stock Reports From Here</h2>
    <div class="flex-flex-flex">
        <button id="button" class="btn btn btn-outline-info btn-Light mx-4">Generate Overall Stock Report</button>
        <button id="buttonf" class="btn btn btn-outline-info btn-Light mx-4">Generate Fertilizers Stock Report</button>
        <button id="buttonp" class="btn btn btn-outline-info btn-Light mx-4">Generate Pestisites Stock Report</button>
        <button id="buttons" class="btn btn btn-outline-info btn-Light mx-4">Generate Seeds Stock Report</button>
    </div>


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
                quantity = tr.getElementsByTagName("td")[2].innerText;
                console.log(product_name, price, quantity);
                product_nameEdit.value = product_name;
                priceEdit.value = price;
                quantityEdit.value = quantity;
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