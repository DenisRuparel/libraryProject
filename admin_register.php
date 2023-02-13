<?php
include('security.php'); 
include('includes/header.php'); 
?>
<?php
//admin register:
session_start();
$email = "";
$name = "";
$errors = array();
$success = array();
if(isset($_POST['signupbtn'])){
    $userid = $_POST['userid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mail = $_POST['mail'];
    $phoneno = $_POST['phoneno'];
    $pass = $_POST['pass'];
    $repeatpass = $_POST['repeatpass'];

    if (empty($userid) || empty($fname) || empty($lname) || empty($mail) || empty($phoneno) || empty($pass) || empty($repeatpass)) {
        $errors['fields'] = "Empty Fields! Please Filled It!"; 
    }
    
    if($pass !== $repeatpass){
        $errors['password'] = "Confirm password not matched!";
    }

    $id_query = "SELECT * FROM admin WHERE user_id = '$userid'";
    $id_query_run = mysqli_query($connection, $id_query);
    if(mysqli_num_rows($id_query_run) > 0){
        $errors['id'] = "User Id that you have entered is already exist!"; 
    }

    $mail_query = "SELECT * FROM admin WHERE email='$mail'";
    $mail_query_run = mysqli_query($connection, $mail_query);
    if(mysqli_num_rows($mail_query_run) > 0){
        $errors['mail_err'] = "E-mail that you have entered is already exist!"; 
    }

    $phoneno_query = "SELECT * FROM admin WHERE contact='$phoneno'";
    $phoneno_query_run = mysqli_query($connection, $phoneno_query);
    if(mysqli_num_rows($phoneno_query_run) > 0){
        $errors['phoneno_err'] = "Contact Number that you have entered is already exist!"; 
    }
    
    if(count($errors) === 0){
        $fill_data = "INSERT INTO admin(user_id, first_name, last_name, email, contact, password) VALUES ('$userid','$fname','$lname','$mail','$phoneno','$pass')";
        $check = mysqli_query($connection, $fill_data);
            if($check){
                $subject = "Registration As Admin For Library | GP Porbandar Department Library";
                $message="Hello '$userid',
                    You Are Successfully Registered! in GP Porbandar Computer Department Library.
                
                    Thank you,
                    GP Porbandar Department Library";
                $sender = "From: denisruparel28@gmail.com";
                if(mail($mail, $subject, $message, $sender)){
                    $_SESSION['status'] = "Your Account is Successfully Registered As a Admin! We've sent a mail to your email - $mail";
                    $_SESSION['status_code'] = "success";
                    $_SESSION['email'] = $mail;
                    $_SESSION['password'] = $pass;
                    header('location: admin_register.php');
                    exit();
                }
            }
            else{
                $errors['db-error'] = "Failed while inserting data into database!";
            }
    }        
}

?>

<body class="bg-gradient-primary">
  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
              <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button>
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
              ?>
              <?php
              if(isset($_SESSION['success']) && $_SESSION['success'] != ''){
                  // echo '<h4 class="bg-primary"> '.$_SESSION['success'].' </h4>';
                  echo '<div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                      <span class="text-success">'.$_SESSION['success'].'</span>
                    </div>';
                  unset($_SESSION['success']);
              }

              if(isset($_SESSION['status']) && $_SESSION['status'] != ''){
                  // echo '<h4 class="bg-danger"> '.$_SESSION['status'].' </h4>';
                  echo '<div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                      <span class="text-success">'.$_SESSION['status'].'</span>
                    </div>';
                  unset($_SESSION['status']);
              }
            ?>
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="admin_register.php" method="POST" autocomplete="">
                <div class="form-group">
                  <input type="text" name="userid" class="form-control form-control-user"
                    id="userid" placeholder="User Id  ">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="fname" class="form-control form-control-user" id="firstname"
                      placeholder="First Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="lname" class="form-control form-control-user" id="lastname"
                      placeholder="Last Name">
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" name="mail" class="form-control form-control-user" id="email"
                    placeholder="Email Address">
                </div>
                <div class="form-group">
                  <input type="tel" name="phoneno" class="form-control form-control-user" id="contact"
                    placeholder="Contact">
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="pass" class="form-control form-control-user" id="password"
                      placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="repeatpass" class="form-control form-control-user"
                      id="repeatpassword" placeholder="Repeat Password">
                  </div>
                </div>
                <button type="submit" name="signupbtn" class="btn btn-primary btn-user btn-block">Register</button>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="admin_login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<?php
include('includes/scripts.php');
?>