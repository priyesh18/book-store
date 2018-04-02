<!doctype html>
<?php include("function/functions.php");
session_start();
?>
<html lang="en">

<head>
    <meta charset="utf-8" />


    <title>Books Store</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/material-kit.css" rel="stylesheet" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>

<body>

    <!-- Navbar will come here -->

     <nav class="navbar navbar-fixed-top" role="navigation" id="topnav">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
    		</button>
                <a class="navbar-brand" href="#">MyBookStore</a>

            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li ><a href="index.php">Home</a></li>
                    <?php 
                    
                    
                   
                    if(!isset($_SESSION['email'])){
                        echo "<li><a href='login1.php'>Login</a></li>";
                    }
                    else 
                    {
                        echo "<li><a href='logout.php'>Logout</a></li>";
                    }
                     if(isset($_SESSION['email'])){
                        $sess=$_SESSION['email'];
                        echo "<li><a>Hi ".$_SESSION['email']." !</a></li>";
                        
                    }
                    else {
                        echo "<li><a>Hi, Guest</a></li>";
                    }
                    ?>
                   
                    <li class="active"><a href="cart.php">my Cart<span class="badge"><?php total_items(); ?></span></a></li>
                    
                </ul>
                <form action="results.php" method="get" class="navbar-form navbar-right">
                    <div class="form-group label-floating">
                        <label class="control-label">Search Books</label>
                        <input type="text" name="user_query" class="form-control">
                    </div>
                    <button type="submit" name="search" class="btn btn-round btn-just-icon btn-primary"><i class="material-icons">search</i><div class="ripple-container"></div></button>
                </form>


            </div>

        </div>
    </nav>

    <!-- end navbar -->

    <div class="container">
        <table class="table-striped table">
            <thead class="thead-inverse">
                <tr>
                    <th>#</th>
                    <th>Remove</th>
                    <th colspan="2">Product </th>

                    
                    <th>Quantity</th>
                    
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <form action="cart.php" method="post">
                <?php mycart(); ?>

         
        
        <div align="right">
            <!--<button class="btn"><input type="submit" value="Update" name="update_cart"/></button>-->
            <button name="update_cart" type="submit" class="btn btn-danger">Update</button>
           <!--<input type="submit" name="update_cart" value="update">-->
           

        </div>
                </form>
   </tbody>

        </table>
      
    </div>
    <?php 
    $ip = getIpAdd();
    if(isset($_POST['update_cart']))
    {
        foreach($_POST['remove'] as $remove_id){
            $delete_books = "delete from cart where bookid = '$remove_id' AND ip_add = '$ip'";
            $run_delete = mysql_query($delete_books, $conn);
            if($run_delete){
                echo "<script>window.open('cart.php','_self');</script>";
            }
        }
    }
        ?>

    <div class="container" align="right" ><h3> <a  style="text-decoration:none " href="checkout.php">checkout </a></h3>
          </div>

</body>

<!--   Core JS Files   -->
<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="assets/js/nouislider.min.js" type="text/javascript"></script>

<!--  Plugin for the Datepicker, full documentation here: http://www.eyecon.ro/bootstrap-datepicker/ -->
<script src="assets/js/bootstrap-datepicker.js" type="text/javascript"></script>

<!-- Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc -->
<script src="assets/js/material-kit.js" type="text/javascript"></script>

</html>
