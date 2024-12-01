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
        $farmer_name = $_POST["farmer_name"];
        $farmer_id = 0;
        $sqlfarmer = "SELECT * FROM `farmers` WHERE farmer_name='$farmer_name'";
        $resultfarmer = mysqli_query($conn, $sqlfarmer);
        while ($rowfarmer = mysqli_fetch_assoc($resultfarmer)) {
            $farmer_id = $rowfarmer['farmer_id'];
        }
        if (mysqli_num_rows($resultfarmer) == 0) {
            $sqlInsert = "INSERT INTO `farmers` (`farmer_name`) VALUES ('$farmer_name')";
            $resultinsert = mysqli_query($conn, $sqlInsert);
            $sqlfarmer = "SELECT * FROM `farmers` WHERE farmer_name='$farmer_name'";
            $resultfarmer = mysqli_query($conn, $sqlfarmer);
            while ($rowfarmer = mysqli_fetch_assoc($resultfarmer)) {
                $farmer_id = $rowfarmer['farmer_id'];
            }
        }
        $sql = "INSERT INTO `sales_transactions` ( `farmer_id`) VALUES ('$farmer_id')";
        $result = mysqli_query($conn, $sql);
        $sql = "SELECT * FROM `sales_transactions`";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $sales_transaction_id = $row['sales_transaction_id'];
        }
        if ($result) {
            header("location: managesales.php?sales_transaction_id=$sales_transaction_id");
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
        <!-- Edit Modal -->
        <div class="modal fade" id="editModall" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Farmer Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="Sales_transactions.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="form-group">
                                <label for="farmer_nameEdit">Supplier Name</label>
                                <input type="text" class="form-control" id="farmer_nameEdit" name="farmer_nameEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="farmer_phone">Contact No </label>
                                <input type="number" class="form-control" id="farmer_phoneEdit" name="farmer_phoneEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="farmer_address">Address </label>
                                <input type="text" class="form-control" id="farmer_addressEdit"
                                    name="farmer_addressEdit" aria-describedby="emailHelp">
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
                        <h5 class="modal-title" id="addModalLabel">Add Farmer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="Sales_transactions.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="farmer_name">Suppliers Name </label>
                                <input type="text" class="form-control" id="farmer_name" name="farmer_name"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="farmer_phone">Contact No</label>
                                <input type="number" class="form-control" id="farmer_phone" name="farmer_phone"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="farmer_address">Address </label>
                                <input type="text" class="form-control" id="farmer_address" name="farmer_address"
                                    aria-describedby="emailHelp">
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
                    <h2>Sales Transactions</h2>
                    <form method="POST">
                        <button class='add btn btn-sm btn-primary' id="" type="submit">Create New Sales</button>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="farmer_address">Select Farmer</label>
                                <select class="form-select" aria-label="Default select example"
                                    style="width : 100%; padding : 15px 10px" name="farmer_name">
                                    <option selected value="Guest<?php
                                    function RandomString($length)
                                    {
                                        $keys = array_merge(range('a', 'z'), range('A', 'Z'), range(101, 999));
                                        for ($i = 0; $i < $length; $i++) {
                                            $key = $keys[array_rand($keys)];
                                        }
                                        return $key;
                                    }
                                    $randomm = RandomString(6);
                                    echo $randomm;
                                    ?>">Guest
                                        <?php
                                        echo $randomm;
                                        ?>
                                    </option>
                                    <?php
                                    $sql1 = "SELECT * FROM `farmers`";
                                    $result1 = mysqli_query($conn, $sql1);
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        echo '<option value="' . $row1['farmer_name'] . '">' . $row1['farmer_name'] . '</option>';
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
                            $sql = "SELECT * FROM `sales_transactions`";
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
        // This js is related to the Add and Edit the elements in the table 

        // views = document.getElementsByClassName('view');
        // Array.from(views).forEach((element) => {
        //     element.addEventListener("click", (e) => {
        //         console.log("edit");
        //         tr = e.target.parentNode.parentNode;
        //         s_sno = tr.getElementsByTagName("td")[0].innerText;
        //         tr = e.target.parentNode.parentNode;
        //         // s_sales_id = tr.getElementsByTagName("td")[1].innerText;
        //         // s_farmer = tr.getElementsByTagName("td")[2].innerText;
        //         // s_Items = tr.getElementsByTagName("td")[3].innerText;
        //         // s_Sales On = tr.getElementsByTagName("td")[4].innerText;
        //         console.log(s_sno);
        //         s_sno.innerText = s_sno;
        //         // s_sales_id.innerText = s_sales_id;
        //         // s_farmer.innerText = s_farmer;
        //         // s_Items.innerText = s_Items;
        //         // s_Sales.innerText = s_Sales;
        //         // farmer_nameEdit.value = farmer_name;
        //         // farmer_phoneEdit.value = farmer_phone;
        //         // farmer_addressEdit.value = farmer_address;
        //         // snoEdit.value = e.target.id;
        //         // console.log(e.target.id)
        //         // $('#editModall').modal('toggle');
        //     })
        // })

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