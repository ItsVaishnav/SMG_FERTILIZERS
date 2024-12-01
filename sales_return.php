<?php
$insert = false;
$update = false;
$delete = false;
$sales_transaction_id = 0;
require_once("config.php");
// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `sales_transactions` WHERE `sales_transaction_id` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $farmer_name = $_POST["farmer_nameEdit"];
        $farmer_phone = $_POST["farmer_phoneEdit"];
        $farmer_address = $_POST["farmer_addressEdit"];

        // Sql query to be executed
        $sql = "UPDATE `sales_transactions` SET `farmer_name` = '$farmer_name' , `farmer_phone` = '$farmer_phone' , `farmer_address` = '$farmer_address' WHERE `sales_transactions`.`farmer_id` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        $sales_transaction_id = $_POST["sales_transaction_id"];
        $sql = "INSERT INTO `sales_return` ( `sales_transaction_id`) VALUES ('$sales_transaction_id')";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT * FROM `sales_return` WHERE sales_transaction_id=$sales_transaction_id";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $return_id = $row['return_id'];
        }
        if ($result) {
            header("location: manage_sales_return.php?return_id=$return_id");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Transactions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/style.css" importance="">
</head>
<body>
    <div class="main-main-main">
        <?php require('Components/nav.php') ?>
        <div class="main-content" id="main-content">
            <?php
            require('Components/header.php');
            $randomm = "";
            ?>

            <?php
            if ($insert) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>Success!</strong> The New Supplier has Been Added Successfully
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                            <span aria-hidden='true'>×</span>
                            </button>
                        </div>";
            }
            ?>
            <?php
            if ($delete) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Supplier has been deleted successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <?php
            if ($update) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>Success!</strong> Supplier Details has been updated successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>

            <!-- action="managesales.php?sales_transaction_id=<?php //echo $sales_transaction_id ?>" -->

            <div class="products">
                <div class="container my-4">
                    <h2>Sales Return</h2>
                    <form method="POST">
                        <button class='add btn btn-sm btn-primary' id="" type="submit">Add Sales Return</button>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="farmer_address">Select Sales Transaction ID</label>
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="sales_transaction_id" required>
                                    <option value="">Select Sales Id</option>
                                    <?php
                                    $sql1 = "SELECT * FROM `sales_transactions`";
                                    $result1 = mysqli_query($conn, $sql1);
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        echo '<option value="' . $row1['sales_transaction_id'] . '"> S_ID : ' . $row1['sales_transaction_id'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <!-- <a class='add btn btn-sm btn-primary' id="" href="sales.php">Add New Supplier</a> -->
                </div>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Sales_Id</th>
                                <th scope="col">Farmer</th>
                                <th scope="col">Items</th>
                                <th scope="col">Sales On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `sales_return`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['sales_transaction_id'] . "</td>
                                    <td>";
                                    
                                    $farm_id = $row['farmer_id'];
                                    $sqll = "SELECT * FROM `farmers` WHERE farmer_id=$farm_id";
                                    $resultt = mysqli_query($conn,$sqll);
                                    while($roww = mysqli_fetch_assoc($resultt)){
                                        echo $roww['farmer_name'];
                                    }                                    
                                     
                                    echo "</td>
                                    <td>";
                                    
                                    $s_t_id = $row['sales_transaction_id'];
                                    $sqll = "SELECT * FROM `sales` WHERE sales_transaction_id=$s_t_id";
                                    $resultt = mysqli_query($conn,$sqll);
                                    $num = mysqli_num_rows($resultt);
                                    echo $num;
                                    echo "</td>
                                    <td>" . $row['Date_Time'] . "</td>
                                    <td> 
                                    <a href='view_sales_transaction.php?sales_transaction_id=".$row['sales_transaction_id']."'><button class='view btn btn-sm btn-primary' id=d".$row['sales_transaction_id'].">View</button></a>
                                    <a href='managesales.php?sales_transaction_id=".$row['sales_transaction_id']."'><button class='edit btn btn-sm btn-primary' id=" . $row['sales_transaction_id'] . ">Edit</button></a>
                                    <button class='delete btn btn-sm btn-primary' id=d" . $row['sales_transaction_id'] . ">Delete</button>  
                                    </td>
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
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit ");
                sno = e.target.id.substr(1);

                if (confirm("Are you sure you want to delete this Product!")) {
                    console.log("yes");
                    window.location = `Sales_transactions.php?delete=${sno}`;
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