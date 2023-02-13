<?php
session_start();
include('security.php');
include('database/dbconfig.php');
include('includes/header.php'); 
error_reporting(0);
?>
<?php
//if user click login button
$email = "";
$name = "";
$errors = array();
$success = array();
if(isset($_POST['login_btn'])){
    $eno_login = $_POST['enrollment_number'];
    $password_login = $_POST['password'];
    if (empty($eno_login) || empty($password_login)) {
        $errors['fields'] = "Empty Fields! Please Filled It!"; 
    }
    $check_eno = "SELECT * FROM register WHERE enrollment_number = '$eno_login' and password = '$password_login' limit 1";
    $stmt = $connection->prepare($check_eno);
    $stmt->bind_param('ss',$eno_login,$password_login);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows>0) {
        $stmt->bind_result($eno,$fname,$lname,$email,$contact,$password,$avatar);
        while ($stmt->fetch()) {
            if ($stmt) {
                $_SESSION['new'] = 'true';
                $_SESSION['user_name'] = $eno_login;
                $_SESSION['name'] = $fname;
                $_SESSION['password'] = $password_login;
                $_SESSION['avatar'] = $avatar;
                header('location: index.php');
            }
        }
    }
    else{
        $errors['details'] = "Invalid Details!";
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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login here!</h1>
                                        <p class="text-center">Login with your enrollment number and password.</p>
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
                                    </div>
                                    <form class="user" action="login.php" method="POST" autocomplete="">
                                        <div class="form-group">
                                            <input type="number" name="enrollment_number" class="form-control form-control-user" placeholder="Enter Enrollment Number">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password">
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div> -->
                                        <button type="submit" name="login_btn" class="btn btn-primary btn-user btn-block"> Login </button>
                                    </form>
                                    <hr>    
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">New User? Create an Account!</a>
                                    </div>
                                </div>
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