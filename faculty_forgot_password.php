<?php
session_start();
include('security.php');
include('faculties/header.php');
require "Send_Mail/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
?>
<?php
//email system start for forget password
include('security.php');    
    $mail="";
    if(isset($_POST['rstbtn'])){
        $reset_email=  ($_POST['email']);
        $_SESSION['reset_email']=$reset_email;
        if($reset_email){
            if(filter_var($reset_email, FILTER_VALIDATE_EMAIL)) {
                $sql=("select email,f_name,f_id from faculties where email='$reset_email' ") or die (mysql_error());
                $results = mysqli_query($connection, $sql);
                $q=  mysqli_affected_rows($connection);
                if($q<1){
                    // echo'<div class="alert alert-danger absolue center text-center" role="alert">
                    //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    //             <span aria-hidden="true">×</span>
                    //         </button>
                    //             <span class="text-danger">E-mail addresses did not match!</span>
                    //     </div>';
                    $errors['not-match-email'] = 'E-mail addresses did not match!'; 
                }
                else 
                if($q > 1){
                    // echo'<div class="alert alert-danger absolue center text-center" role="alert">
                    //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    //             <span aria-hidden="true">×</span>
                    //         </button>
                    //             <span class="text-danger">Duplicate e-mail address found!</span>
                    //     </div>';
                    $errors['dup-email'] = 'Duplicate e-mail address found!'; 
                }
                else 
                    if($q == 1){
                        $res=mysqli_fetch_array($results);
                        
                        // $id=$res['f_id'];
                        
                        // $key=md5(time());

                        // $rid= substr(md5(uniqid(rand(), 1), 3, 10));

                        // $key = $key . $rid;

                        // $sql=("UPDATE faculties SET activation='$key' where f_id='$id' ") or die (mysql_error());
                        
                        // $email=base64_encode($reset_email);
                        
                        $name=$res['f_name'];

                        $to = $res['email']; 
                        $mail = new PHPMailer(true);
                        $subject='Password Reset | GP Porbandar Department Library';
                        $message="Hello $f_name,<br> 
                                Someone requested to reset your password.<br>
                                If this was you,<a href='localhost/DLMS/faculty_new_password.php'>click here</a>to reset your password,
			                    
                                if not just ignore this email.
                                <br><br>
			                Thank you,
                                <br><br>
                                GP Porbandar Department Library
                                <br><br>";
                        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                        $mail->isSMTP();
                        $mail->SMTPAuth = true;
                        $mail->IsHTML(true);
                        $mail->AddReplyTo("denisruparel28@gmail.com");
                        $mail->Host = "smtp.gmail.com";
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->Username = "denisruparel28@gmail.com";
                        $mail->Password = "tvyzbzxvpaeeohux";

                        $mail->setFrom("denisruparel28@gmail.com","GP Porbandar Department Library");
                        $mail->addAddress($to, "");

                        $mail->Subject = $subject;  
                        $mail->Body = $message;

                        $m = $mail->send();
                            
                        if($m)
                        {
                            $mail="";
                            $_SESSION['new']='true';
                            header("Location:#");
                            echo "<script type='text/javascript'> document.location = '#'; </script>";
                            exit();
                            
                        }
                        else{
                            // echo'<div class="alert alert-danger absolue center text-center" role="alert">
                            //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            //             <span aria-hidden="true">×</span>
                            //         </button>
                            //             <span class="text-danger">Error occured while trying to send e-mail</span>
                            //     </div>';
                            $errors['err-occur'] = 'Error occured while trying to send e-mail!';
                        }
                    }          
            }
            else {
                // echo'<div class="alert alert-danger absolue center text-center" role="alert">
                //         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                //             <span aria-hidden="true">×</span>
                //         </button>
                //             <span class="text-danger">Invalid Format!</span>
                //     </div>';
                $errors['invalid-format'] = 'Invalid Format!';
            }
        }
        // else {
        //         echo'<div class="alert alert-danger absolue center text-center" role="alert">
        //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                 <span aria-hidden="true">×</span>
        //             </button>
        //                 <span class="text-danger">Enter your e-mail!</span>
        //         </div>';
        // }
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
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" method="POST">
                                    <?php                   
                                        if(isset($_SESSION['new'])=="true"){
                                        echo '<div class="alert alert-success absolue center text-center" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                            </button>
                                            <span class="text-success">A password reset link was sent to your e-mail</span>
                                            </div>';
                                            unset($_SESSION['new']); 
                                        }
                                    ?>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." required>
                                        </div>
                                        <button type="submit" name="rstbtn" class="btn btn-primary btn-user btn-block"> Reset Password </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="faculty_login.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
<?php
include('faculties/scripts.php'); 
?>