<?php

session_start();
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location:account.php');
    exit();
}

if(isset($_POST['login_btn'])){

    $Email = $_POST['Email'];
    $Password = md5($_POST['Password']);

    $stmt = $conn -> prepare('SELECT user_id,user_name,user_email,user_password 
    FROM users 
    WHERE user_email=? 
    AND user_password=? 
    LIMIT 1');

    $stmt -> bind_param('ss', $Email, $Password);
    
    if($stmt -> execute()){
        $stmt->bind_result($user_id,$user_name,$user_email,$user_password);
        $stmt->store_result();
        
        if($stmt -> num_rows() == 1 ){
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logged_in'] = true;

            header('location: account.php?login_success=LOGGED IN SUCCESSFULLY');
        }
    else{
        header("location: login.php?error=Couldn't verify your account");
    }

    }else{
        header('location: login.php?error=something went wrong');

}


}


?>







<?php include("layout/header.php"); ?>


     <section id="login" class="section-m1">
         <div class="login-des">
            <h2 class="form-weight-bold"> LOGIN </h2>
            <hr class="mx-auto">
         </div>
        </section>

        <section id="login" class="section-m1">
        <p style="color: red;" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error'];} ?></p>
        <p style="color: red;" class="text-center"><?php if(isset($_GET['message'])) {echo $_GET['message'];} ?></p>
        <p style="color: red;" class="text-center"><?php if(isset($_GET['errorpaymentmessage'])) {echo $_GET['errorpaymentmessage'];} ?></p>
            </section>



         
     <section id="login" class="section-m1">
         <div>
            <form id="login-form" method="POST" action="login.php">
                <div class="login-form-class">
                    <label>EMAIL</label>
                    <input type="text" class="login-form-control" id="login-email" name="Email" placeholder="EMAIL" required/>
                </div>
                <div class="login-form-class">
                    <label>PASSWORD</label>
                    <input type="password" class="login-form-control" id="login-password" name="Password" placeholder="PASSWORD" required/>
                </div>
                <div class="login-form-class">
                    <input type="submit" class="button" id="login-btn" name="login_btn"  value="LOGIN"/>
                </div>
                <div class="login-form-class">
                    <a id="register-url" class="button" href="register.php">Don't have an Account? Register Here.</a>
                </div>
            </form>
         </div>

     </section>




     <?php include("layout/footer.php"); ?>