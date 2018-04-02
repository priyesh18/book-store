<?php
$conn=mysqli_connect("localhost", "root", "","ecom");
//$db=mysqli_select_db("ecom",$conn);	



function getIpAdd()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function cart(){
    if(isset($_GET['add_cart']))
    {
        global $conn;
        $ip=getIpAdd();
        $book_id=$_GET['add_cart'];
        $check_product="SELECT `bookid`, `ip_add`, `quantity` FROM `cart` WHERE  ip_add='$ip' AND bookid='$book_id'";
        $run_check=mysqli_query($conn, $check_product);
        if(mysqli_num_rows($run_check)>0)
        {
          //echo "Already added";
        }
        else {
          $insert_cart="INSERT INTO `cart`(`bookid`, `ip_add`) VALUES ('$book_id','$ip')";
          $run_cart = mysqli_query($conn, $insert_cart);
            echo "added";
          echo "<script>window.open('index.php','_self')</script>";
        }
    }
}
function total_items(){
    global $conn;
    $ip=getIpAdd();
    if(isset($_GET['add_cart']))
    {
        $get_items="SELECT * FROM `cart` WHERE `ip_add`='$ip'";
        $run=mysqli_query($conn, $get_items);
        $count = mysqli_num_rows($run);
    }
    else {
        $get_items="SELECT * FROM `cart` WHERE `ip_add`='$ip'";
        $run=mysqli_query($conn, $get_items);
        $count = mysqli_num_rows($run);
    }
    echo $count;
}

function mycart() {
  global $conn;
  $ip = getIpAdd();
    $count = 1;
  $get_cart = "SELECT * FROM `Books` WHERE `book_id` IN (SELECT `bookid` FROM cart WHERE ip_add LIKE '::1')";
  $cart_items = mysqli_query($conn,$get_cart);
$total_price =0;    
  while($bk = mysqli_fetch_array($cart_items)){
    $price_arr = array($bk['price']);
    //$total_price = array_sum($price_arr);
    $single_price = $bk['price'];
    $total_price += $single_price;  
    $bk_title = $bk['title'];
    echo "<tr>
                <td scope='row'><h3>".$count++."</h3></td>
                 <td scope='row' class='td-actions'>
                   
                   <h3> <div class='checkbox'>
                        <label>
		                  <input type='checkbox'  name='remove[]' value='".$bk['book_id']."'>
		                      
	                   </label>
                       </div></h3>
                      
                </td>
                <td><img src='assets/images/".$bk['image']."' width='60px' height='80px'></td>
                <td><h3>".$bk_title."</h3></td>
                <td><h3>1</h3></td>
                <td><h3>&#8377;".$single_price."</h3></td>
                
               
                
            </tr>";
    
  }
    echo "<tr><td colspan='6' align='right'><h3>Total=&#8377;".$total_price."</h3></td></tr>" ;
  
}

function getcats(){
	global $conn;

	$query4="SELECT * from category";
	$result=mysqli_query($conn, $query4);
	while($row=mysqli_fetch_array($result))
	{
		echo "<li role=\"presentation\"><a href=\"index.php?category=".$row['name']."\">".$row['name']."</a></li>";
	}

}
function getauths(){
	global $conn;

	$query3="SELECT DISTINCT author FROM Books";
	$result=mysqli_query($conn, $query3);
	while($row=mysqli_fetch_array($result))
	{
		echo "<li role=\"presentation\"><a href=\"#".$row['author']."\">".$row['author']."</a></li>";
	}

}

function getbooks(){
	global $conn;
    if(!isset($_GET['category'])){
	$query="SELECT * from Books";
	$result=mysqli_query($conn, $query);
	while($row=mysqli_fetch_array($result))
	{
		echo "<div class='col-lg-4 col-md-6'>
                            <div class='card'>
                                <img class='card-img' height='200px' width='100px' src='assets/images/".$row['image']."'>
                                <span class='content-card'>
                                    <h6>".$row['title']."</h6>
                                    <h7>".$row['author']."</h7>
                                </span>
                                <a href='index.php?add_cart=".$row['book_id']."'><button class='buybtn btn btn-warning btn-round btn-sm'>
	 								Add <i class='material-icons'>add_shopping_cart</i>
								</button></a>
                                <button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$row['book_id']."'>
	 								Know More
								</button>";
                                
           //code for modal
        echo "<div class='modal fade' id='".$row['book_id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4 class='modal-title' id='myModalLabel'>".$row['title']."</h4>
                      </div>
                      <div class='modal-body'>
                      <h4><p align='right'>&#8377;".$row['price']."</p></h4>".
                          $row['description']
                      ."</div>
                     
                    </div>
                  </div>
                </div>
                                
							</div>
                        </div>";    //the last two </div> are from previous echo.
	}
    }
}


function get_bycat(){
  global $conn;
  if(isset($_GET['category'])){
    $cat_id= $_GET['category'];
    $get_cat_pro = "SELECT * FROM Books WHERE category LIKE '$cat_id'";
    $run_cat_pro=mysqli_query($conn,$get_cat_pro);
    $count_cat = mysqli_num_rows($run_cat_pro);
    if($count_cat==0){
      echo "<h2>No books found</h2>";
    }
    while($row=mysqli_fetch_array($run_cat_pro))
  {
    echo "<div class='col-lg-4 col-md-6'>
                            <div class='card'>
                                <img class='card-img' height='200px' width='100px' src='assets/images/".$row['image']."'>
                                <span class='content-card'>
                                    <h6>".$row['title']."</h6>
                                    <h7>".$row['author']."</h7>
                                </span>
                                <a href='index.php?add_cart=".$row['book_id']."'><button class='buybtn btn btn-warning btn-round btn-sm'>
                  Add <i class='material-icons'>add_shopping_cart</i>
                </button></a>
                                <button class='knowbtn btn btn-warning btn-round btn-sm' data-toggle='modal' data-target='#".$row['book_id']."'>
                  Know More
                </button>";
                                
           //code for modal
        echo "<div class='modal fade' id='".$row['book_id']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                  <div class='modal-dialog'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                        <h4 class='modal-title' id='myModalLabel'>".$row['title']."</h4>
                      </div>
                      <div class='modal-body'>
                      <h4><p align='right'>&#8377;".$row['price']."</p></h4>".
                          $row['description']
                      ."</div>
                      
                    </div>
                  </div>
                </div>
                                
              </div>
                        </div>";    //the last two </div> are from previous echo.
  }
    }
  }

?>
