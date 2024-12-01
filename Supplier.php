<?php
$insert = false;
$update = false;
$delete = false;

require_once("config.php");
// Die if connection was not successful
if (!$conn) {
    die("Sorry we failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `suppliers` WHERE `supplier_id` = $sno";
    $result = mysqli_query($conn, $sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        // Update the record
        $sno = $_POST["snoEdit"];
        $supplier_name = $_POST["supplier_nameEdit"];
        $suppliers_phone = $_POST["suppliers_phoneEdit"];
        $supplier_address = $_POST["supplier_addressEdit"];

        // Sql query to be executed
        $sql = "UPDATE `suppliers` SET `supplier_name` = '$supplier_name' , `suppliers_phone` = '$suppliers_phone' , `supplier_address` = '$supplier_address' WHERE `suppliers`.`supplier_id` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        $supplier_name = $_POST["supplier_name"];
        $suppliers_phone = $_POST["suppliers_phone"];
        $supplier_address = $_POST["supplier_address"];
        // Sql query to be executed
        $sql = "INSERT INTO `suppliers` ( `supplier_name`, `suppliers_phone`, `supplier_address`) VALUES ('$supplier_name', '$suppliers_phone','$supplier_address')";
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
    <title>Suppliers</title>
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
                        <h5 class="modal-title" id="editModalLabel">Edit Supplier Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="Supplier.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="form-group">
                                <label for="supplier_nameEdit">Supplier Name</label>
                                <input type="text" class="form-control" id="supplier_nameEdit" name="supplier_nameEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="suppliers_phone">Contact No </label>
                                <input type="number" class="form-control" id="suppliers_phoneEdit" name="suppliers_phoneEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="supplier_address">Address </label>
                                <input type="text" class="form-control" id="supplier_addressEdit" name="supplier_addressEdit"
                                    aria-describedby="emailHelp">
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
                        <h5 class="modal-title" id="addModalLabel">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="Supplier.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="supplier_name">Suppliers Name </label>
                                <input type="text" class="form-control" id="supplier_name" name="supplier_name"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="suppliers_phone">Contact No</label>
                                <input type="number" class="form-control" id="suppliers_phone" name="suppliers_phone"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="supplier_address">Address </label>
                                <input type="text" class="form-control" id="supplier_address" name="supplier_address"
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
            <div class="products">
                <div class="container my-4">
                    <h2>Suppliers</h2>
                    <button class='add btn btn-sm btn-primary' id="" onclick="handelAdd()">Add New Supplier</button>
                </div>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Last Update On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `suppliers`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['supplier_name'] . "</td>
                                    <td>" . $row['suppliers_phone'] . "</td>
                                    <td>" . $row['supplier_address'] . "</td>
                                    <td>" . $row['Date_Time'] . "</td>
                                    <td> <button class='edit btn btn-sm btn-primary' id=" . $row['supplier_id'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['supplier_id'] . ">Delete</button>  </td>
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

edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                console.log("edit");
                tr = e.target.parentNode.parentNode;
                supplier_name = tr.getElementsByTagName("td")[0].innerText;
                suppliers_phone = tr.getElementsByTagName("td")[1].innerText;
                supplier_address = tr.getElementsByTagName("td")[2].innerText;
                console.log(supplier_address);
                supplier_nameEdit.value = supplier_name;
                suppliers_phoneEdit.value = suppliers_phone;
                supplier_addressEdit.value = supplier_address;
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
                    window.location = `Supplier.php?delete=${sno}`;
                }
                else {
                    console.log("no");
                }
            })
        })
    </script>
    <script src="js/script.js?<?php echo time();?>"></script>
</body>

</html>