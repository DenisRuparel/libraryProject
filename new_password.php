<?php
session_start();
include('security.php');
include('includes/header.php');
// require_once "code.php"; 
$f_email = $_SESSION['f_email'];
if($f_email == false){
    header('Location: login.php');
}
?>
<?php
$email = "";
$name = "";
$errors = array();
$success = array();
//if user click newpassbtn button
if(isset($_POST['newpassbtn'])){
    $_SESSION['info'] = "";
    $new_password = $_POST['newpassword'];
    $new_cpassword = $_POST['conpassword'];
    if($new_password !== $new_cpassword){
        $errors['new-password'] = "Confirm password does not matched!";
    }
    else{
        // $code = 0;
        $remail=$_SESSION['f_email'];         //getting this email using session
        $update_pass = "UPDATE register SET password = '$new_password' WHERE email = '$remail';";
        $run_query = mysqli_query($connection, $update_pass);
        if($run_query){
            $info = "Your password changed. Now you can login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password_changed.php');
        }
        else{
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}
?>
<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">New Password!</h1>
                                    </div>
                                    <?php 
                                        if(isset($_SESSION['info'])){
                                            ?>
                                            <div class="alert alert-success text-center">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                                <?php echo $_SESSION['info']; ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if(count($errors) > 0){
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
                                        }
                                    ?>
                                    <form class="user" method="POST" action="new_password.php" autocomplete="off">
                                        <div class="form-group">
                                            <input type="password" name="newpassword" class="form-control form-control-user"
                                                id="exampleInputnewpassword" aria-describedby="newpasswordHelp"
                                                placeholder="Enter New Password...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="conpassword" class="form-control form-control-user"
                                                id="exampleInputnpassword" aria-describedby="npasswordHelp"
                                                placeholder="Confirm Your Password...">
                                        </div>
                                        <button type="submit" name="newpassbtn" class="btn btn-primary btn-user btn-block"> Reset Password </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
<?php
include('includes/scripts.php'); 
?>