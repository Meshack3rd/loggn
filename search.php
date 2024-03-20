<?php
session_start();


$page_title = "Search Details";
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <?php
                if (isset($_POST["search"])) {
                    $reg = $_POST["reg"];
                    
                $con = mysqli_connect("localhost", "root", "", "dist");

                $query = mysqli_query($con, "SELECT * FROM users WHERE registration = '$reg'");

                $row = mysqli_fetch_array($query);
                echo "Your Contacts Are:";
                echo "<br>"."name: " .$row["name"]; 
                echo "<br>" ."email: " .$row["email"];
                echo "<br>" ."phone No: " .$row["phone"];
                echo "<br>" ."registration No: " .$row["registration"];
               
       
       
                
               
                

                }





                ?>



                <div class="card">
                    <div class="card-header">
                        <h5>Search</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">

                            <div class="form-group mb-3">
                                <label>Enter registration no</label>
                                <input type="text" name="reg" class="form-control" placeholder="Enter New Password">
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" name="search" class="btn btn-success w-100">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>