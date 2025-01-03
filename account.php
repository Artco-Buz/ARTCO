<?php

session_start();
include("server/connection.php");

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit();
}

if(isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit();
    }
}

if(isset($_POST['change_password'])){
    $Password = $_POST['password']; // Ensure this matches the form name
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $user_email = $_SESSION['user_email']; // Use email from session

    if($Password !== $ConfirmPassword){
        header('location: account.php?error=Password Does NOT MATCH');
        exit();
    }
    else if(strlen($Password) < 6){
        header('location: account.php?error=Password must be at least 6 characters');
        exit();
    } 
    else{
        $stmt = $conn->prepare('UPDATE users SET user_password=? WHERE user_email=?');
        $stmt->bind_param('ss', md5($Password), $user_email);
        if ($stmt->execute()){
            header('location: account.php?message=Password has been updated successfully');
            exit();
        } else{
            header('location: account.php?error=Could Not update at the moment');
            exit();
        }
    }
}


if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];
    $stmt = $conn ->prepare("SELECT * FROM orders WHERE user_id=?");
    $stmt->bind_param("i",$user_id);
    $stmt->execute();

    $orders= $stmt->get_result();

}
?>


<?php include("layout/header.php"); ?>


     <section id="orders" class="section-p1 text-center">
         <div class="register-des">
            <h2 class="form-weight-bold"> ACCOUNT INFORMATION </h2>
            <hr class="mx-auto">
            <p class="text-center" style="color:green"> <?php if(isset($_GET['register_success'])) {echo $_GET['register_success'];}?></p>
            <p class="text-center" style="color:green"> <?php if(isset($_GET['login_success'])) {echo $_GET['login_success'];}?></p>
            <p class="text-center" style="color:red"> <?php if(isset($_GET['error'])) {echo $_GET['error'];}?></p>
            <p class="text-center" style="color:green"> <?php if(isset($_GET['message'])) {echo $_GET['message'];}?></p>   
         </div>
         </section>


     <section class="account-section-p1 ">
        <div class="col-lg-6 col-md-12 col-sm-12 account-form-container">
            <form id="account-form">
            <h3 class="font-weight-bold">Account Info</h3>
                <hr class="mx-auto">
                <div class="account-info">
                    <p><strong>Name: </strong>
                    <span> <?php if(isset($_SESSION['user_name'])){echo $_SESSION['user_name'];} ?> </span></p>
                    <p><strong>Email: </strong>
                    <span> <?php if(isset($_SESSION['user_email'])) {echo $_SESSION['user_email'];} ?></span></p>
                    <p><a href="#orders" id="order-btn">Your Orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">LOGOUT</a></p>
                </div>
            </form>
         </div>

         
         
         <div class="col-lg-6 col-md-12 col-sm-12 account-form-container">
            <form id="account-form" method="POST" action="account.php">
                <h3>Change Password</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required/>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="account-password-confirm" name="ConfirmPassword" placeholder="Confirm Password" required/>
                </div>
                <div class="form-group">
                    <input type="submit" value="Change Password" class="btn" name="change_password" id="change-password-btn"/>
                </div>
            </form>
         </div>
         </div>
       </div>
     </section>

     <section id="orders" class="section-p1 text-center">
         <div class="register-des">
            <h2 class="form-weight-bold"> YOUR ORDERS </h2>
            <hr class="mx-auto">
         </div>
         </section>


         <section id="cart-body" class="section-p1">
    <table width="100%">
        <thead>
            <tr>
                <td>Order ID</td>
                <td>Order Cost</td>
                <td>Order Status</td>
                <td>Order Date</td>
                <td>Order Details</td>
            </tr>
        </thead>

        <?php while($row = $orders->fetch_assoc()) { ?>
        <tbody>
            <tr>
                <td><?php echo $row['order_id']; ?></td>
                <td><span>₱<?php echo $row['order_cost']; ?></span></td>
                <td><span><?php echo $row['order_status']; ?></span></td>
                <td><span><?php echo $row['order_date']; ?></span></td>
                <td>
                    <form method="POST" action="order_details.php">
                        <input type="hidden" value="<?php echo $row['order_status'];?>" name="order_status"/>
                        <input type="hidden" value="<?php echo $row['order_id'];?>" name="order_id"/>
                        <input class="button" name="order_details_btn" type="submit" value="Details"/>
                    </form>
                </td>
            </tr>
        </tbody>
        <?php } ?>
    </table>
</section>


            

<?php include("layout/footer.php"); ?>

