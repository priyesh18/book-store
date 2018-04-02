<!DOCTYPE html>
<?php
session_start();
include("function/functions.php");
include("includes/db.php");
?>
<html >
<head>
  <meta charset="UTF-8">
  <title>Signup/Login</title>
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,600" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
  
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>

      <link rel="stylesheet" href="login/css/style.css">
     <link rel="stylesheet" href="assets/css/styles.css">
    

  
</head>

<body style="margin-top:0px">

<div class="container-fluid">
    <div class="row"></div></div>
    
    
<nav class="navbar navbar-fixed-top" role="navigation">
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
                    <li><a href="index.php">Home</a></li>
                </ul>
            </div>
    </div>
    </nav>

  
<div class="container">
   <section id="formHolder">

      <div class="row">

         <!-- Brand Box -->
         <div class="col-sm-6 brand">
            <a href="#" class="logo">BookStore</a>

            <div class="heading">
               <h2>Crazy Reads</h2>
               <p>Because paperbacks are always in fashion</p>
            </div>

            <div class="success-msg">
               <p>Great! You are one of our members now</p>
               <a href="#" class="profile">Your Profile</a>
            </div>
         </div>


         <!-- Form Box -->
         <div class="col-sm-6 form">

            <!-- Login Form -->
            <div class="login form-peice switched">
               <form class="login-form" action="login1.php" method="post">
                  <div class="form-group">
                     <label for="loginemail">Email Adderss</label>
                     <input type="email" name="loginemail" id="loginemail" required>
                  </div>

                  <div class="form-group">
                     <label for="loginPassword">Password</label>
                     <input type="password" name="loginPassword" id="loginPassword" required>
                  </div>

                  <div class="CTA">
                     <input type="submit" name="login" value="Login">
                     <a href="#" class="switch">I'm New</a>
                  </div>
                   <a href="checkout.php?forgot_pass">Forgot password</a>
               </form>
            </div><!-- End Login Form -->


            <!-- Signup Form -->
            <div class="signup form-peice">
               <form action="login1.php" class="signup-form"  method="post">

                  <div class="form-group">
                     <label for="name">Full Name</label>
                     <input type="text" name="username" id="name" class="name">
                     <span class="error"></span>
                  </div>

                  <div class="form-group">
                     <label for="email">Email Address</label>
                     <input type="email" name="emailAdress" id="email" class="email">
                     <span class="error"></span>
                  </div>

                  <div class="form-group">
                     <label for="phone">Phone Number - <small>Optional</small></label>
                     <input type="text" name="phone" id="phone">
                  </div>
                  

                  <div class="form-group">
                     <label for="password">Password</label>
                     <input type="password" name="password" id="password" class="pass">
                     <span class="error"></span>
                  </div>

                  <div class="form-group">
                     <label for="passwordCon">Confirm Password</label>
                     <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                     <span class="error"></span>
                  </div>

                  <div class="CTA">
                     <input type="submit" value="Signup" name="signup" id="submit">
                     <a href="#" class="switch">I have an account</a>
                  </div>
               </form>
            </div><!-- End Signup Form -->
         </div>
      </div>

   </section>

</div>
 
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script src="login/js/index.js"></script>

    
    
    <?php if(isset($_POST['signup'])){
        $ip = getIpAdd();
        $c_name = $_POST['username'];
        $c_email = $_POST['emailAdress'];
        $c_phone = $_POST['phone'];
        $c_pass = $_POST['password'];
        $query = "INSERT INTO customer (`cust_ip`, `name`, `email`, `password`, `phone`) VALUES ('$ip','$c_name','$c_email','$c_pass','$c_phone')";
        $result = mysqli_query($conn, $query);
        if($result){
            echo "<script>alert('Registration Successful')</script>";
        }
        $get_items="SELECT * FROM `cart` WHERE `ip_add`='$ip'";
        $run=mysqli_query($conn, $get_items);
        $check_cart = mysqli_num_rows($run);
        if($check_cart==0){
            $_SESSION['email']=$c_email;
            echo "<script>window.open('index.php','_self')</script>";
        }
        else{
            $_SESSION['email']=$c_email;
            echo "<script>window.open('checkout.php','_self')</script>";
            
            
        }
        
    }
    //sign in
            if(isset($_POST['login'])){
                $email= $_POST['loginemail'];
                $pass = $_POST['loginPassword'];
                $sel_c="select * from customer where password='$pass' AND email='$email'";
                $run_c=mysqli_query($conn,$sel_c);
                $check_customer=mysqli_num_rows($run_c);
                if($check_customer==0)
                {
                    echo "<script>alert('Password or Username is incorrect')</script>";
                }
                 $ip = getIpAdd();
                    $get_items="SELECT * FROM `cart` WHERE `ip_add`='$ip'";
                    $run=mysqli_query($conn, $get_items);
                    $check_cart = mysqli_num_rows($run);
                    if($check_customer>0 AND $check_cart==0){
                        
                         $_SESSION['email']=$email;
                         echo "<script>alert('Login Successful')</script>";
                        echo "<script>window.open('index.php','_self')</script>";
                    }
                    if($check_customer>0 AND $check_cart>0){
                            $_SESSION['email']=$email;
                          echo "<script>alert('Login Successful')</script>";
                        echo "<script>window.open('checkout.php','_self')</script>";
            
            
        }
    
            }?>
</body>
</html>
