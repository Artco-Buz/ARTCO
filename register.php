<?php
session_start();
include('server/connection.php');

if(isset($_POST['register'])){

    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];

    if($Password !== $ConfirmPassword){
        header('location: register.php?error=Password Does NOT MATCH');
        exit();
    }
    else if(strlen($Password) < 6){
        header('location: register.php?error=Password must be at least 6 characters');
        exit();
    } 
    
    else {
        $stmt1 = $conn->prepare('SELECT count(*) FROM users WHERE user_email=?');
        $stmt1->bind_param('s', $Email);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($num_rows);
        $stmt1->fetch();

        if ( $num_rows != 0) {
            $stmt1->close();
            header('location: register.php?error=User with this email already exists');
            exit();
        }

        $stmt1->close();

        $stmt = $conn->prepare('INSERT INTO users (user_name, user_email, user_password)
                                VALUES (?, ?, ?)');

        $stmt->bind_param('sss', $Name, $Email, md5($Password));
        if ($stmt->execute()){
            $user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $Email;
            $_SESSION['user_name'] = $Name;
            $_SESSION['logged_in'] = true;
            $stmt->close();
            header('location: account.php?register_success=You Are Registered Successfully');
            exit();
        }
        else {
            $stmt->close();
            header('location: register.php?error=ERROR: Could Not Create the Account At the Moment');
            exit();
        }
    }

} else if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit();
}
?>






<?php include("layout/header.php"); ?>


     <section id="register" class="section-m1">
         <div class="register-des">
            <h2 class="form-weight-bold"> REGISTER </h2>
            <hr class="mx-auto">
         </div>

         <div>
            <form id="register-form" method="POST" action="register.php">
                <p style="color: red;"><?php if(isset($_GET['error'])) { echo $_GET['error'];} ?></p>

                <div class="register-form-class">
                    <label>NAME</label>
                    <input type="text" class="register-form-control" id="register-name" name="Name" placeholder="NAME" required/>
                </div>

                <div class="register-form-class">
                    <label>EMAIL</label>
                    <input type="text" class="register-form-control" id="register-email" name="Email" placeholder="EMAIL" required/>
                </div>

                <div class="register-form-class">
                    <label>PASSWORD</label>
                    <input type="password" class="register-form-control" id="register-password" name="Password" placeholder="PASSWORD" required/>
                </div>

                <div class="register-form-class">
                    <label>CONFIRM PASSWORD</label>
                    <input type="password" class="register-form-control" id="register-confirm-password" name="ConfirmPassword" placeholder="CONFIRM PASSWORD" required/>
                </div>
                
                
                <div class="register-form-class">
                    <input type="submit" class="button" id="register-btn" name="register" value="REGISTER"/>
                </div>

                <div class="register-form-class">
                    <a id="login-url" class="button" href="login.php">Have An Account? Login Here.</a>
                </div>
                

            </form>
         </div>

     </section>



     <?php include("layout/footer.php"); ?>