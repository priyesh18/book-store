<?php

session_start();
if(!isset($_SESSION['email'])){
    include("login1.php");
}
else{
    include("payment.php");
}

?>