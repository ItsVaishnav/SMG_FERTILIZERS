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
    $sql = "DELETE FROM `farmers` WHERE `farmer_id` = $sno";
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
        $sql = "UPDATE `farmers` SET `farmer_name` = '$farmer_name' , `farmer_phone` = '$farmer_phone' , `farmer_address` = '$farmer_address' WHERE `farmers`.`farmer_id` = $sno";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            $update = true;
        } else {
            echo "We could not update the record successfully";
        }
    } else {
        $farmer_name = $_POST["farmer_name"];
        $farmer_phone = $_POST["farmer_phone"];
        $farmer_address = $_POST["farmer_address"];
        // Sql query to be executed
        $sql = "INSERT INTO `farmers` ( `farmer_name`, `farmer_phone`, `farmer_address`) VALUES ('$farmer_name', '$farmer_phone','$farmer_address')";
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
    <title>Farmers</title>
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
                    <form action="farmers.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="form-group">
                                <label for="farmer_nameEdit">Farmer Name</label>
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
                    <form action="farmers.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="farmer_name">Farmers Name </label>
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
                        <strong>Success!</strong> Farmer Details has been updated successfully
                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>×</span>
                        </button>
                    </div>";
            }
            ?>
            <div class="products">
                <div class="container my-4">
                    <h2>Farmers</h2>
                    <button class='add btn btn-sm btn-primary' id="" onclick="handelAdd()">Add New Farmer</button>
                </div>

                <div class="container my-4">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Farmers Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Last Update On</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `farmers`";
                            $result = mysqli_query($conn, $sql);
                            $sno = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $sno = $sno + 1;
                                echo "<tr>
                                    <th scope='row'>" . $sno . "</th>
                                    <td>" . $row['farmer_name'] . "</td>
                                    <td>" . $row['farmer_phone'] . "</td>
                                    <td>" . $row['farmer_address'] . "</td>
                                    <td>" . $row['Date_Time'] . "</td>
                                    <td> <button class='edit btn btn-sm btn-primary' id=" . $row['farmer_id'] . ">Edit</button> <button class='delete btn btn-sm btn-primary' id=d" . $row['farmer_id'] . ">Delete</button>  </td>
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
                farmer_name = tr.getElementsByTagName("td")[0].innerText;
                farmer_phone = tr.getElementsByTagName("td")[1].innerText;
                farmer_address = tr.getElementsByTagName("td")[2].innerText;
                console.log(farmer_address);
                farmer_nameEdit.value = farmer_name;
                farmer_phoneEdit.value = farmer_phone;
                farmer_addressEdit.value = farmer_address;
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
                    window.location = `farmers.php?delete=${sno}`;
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