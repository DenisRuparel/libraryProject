<?php
// session_start();
// include('security.php');
// $email = "";
// $name = "";
// $errors = array();
// $success = array();

// if(isset($_POST['registerbtn']))
// {
//     $eno = $_POST['enrollmentnumber'];
//     $fname = $_POST['firstname'];
//     $lname = $_POST['lastname'];
//     $email = $_POST['email'];
//     $contact = $_POST['contact'];
//     $password = $_POST['password'];
//     $rpassword = $_POST['repeatpassword'];

//     if (empty($eno) || empty($fname) || empty($lname) || empty($email) || empty($contact) || empty($password) || empty($rpassword)) {
//         $errors['fields'] = "Empty Fields! Please Filled It!"; 
//     }
    
//     if($password !== $rpassword){
//         $errors['password'] = "Confirm password not matched!";
//     }

//     $eno_query = "SELECT * FROM register WHERE enrollment_number='$eno'";
//     $eno_query_run = mysqli_query($connection, $eno_query);
//     if(mysqli_num_rows($eno_query_run) > 0){
//         $errors['en_number'] = "Enrollment Number that you have entered is already exist!"; 
//     }

//     $email_query = "SELECT * FROM register WHERE email='$email'";
//     $email_query_run = mysqli_query($connection, $email_query);
//     if(mysqli_num_rows($email_query_run) > 0){
//         $errors['email_err'] = "E-mail that you have entered is already exist!"; 
//     }

//     $phone_query = "SELECT * FROM register WHERE contact='$contact'";
//     $phone_query_run = mysqli_query($connection, $phone_query);
//     if(mysqli_num_rows($phone_query_run) > 0){
//         $errors['contact_err'] = "Contact Number that you have entered is already exist!"; 
//     }

//     if(count($errors) === 0){
//         $insert_data = "INSERT INTO register(enrollment_number, first_name, last_name, email, contact, password) 
//                         VALUES ('$eno','$fname','$lname','$email','$contact','$password')";
//         $data_check = mysqli_query($connection, $insert_data);
//         if($data_check){
//             $subject = "Registration For Library | GP Porbandar Department Library";
//             $message="Hello '.$eno.',
//                         You Are Successfully Registered! in GP Porbandar Computer Department Library.
			        
//                         Thank you,
//                         GP Porbandar Department Library";
//             $sender = "From: denisruparel28@gmail.com";
//             if(mail($email, $subject, $message, $sender)){
//                 $_SESSION['status'] = "Your Account is Successfully Registered! We've sent a mail to your email - $email";
//                 $_SESSION['status_code'] = "success";
//                 $_SESSION['email'] = $email;
//                 $_SESSION['password'] = $password;
//                 // $success['register'] = "Your Account is Successfully Registered! We've sent a mail to your email - $email";
//                 header('location: register.php'); 
//                 exit();
//             }
//         }
//         else{
//             $errors['db-error'] = "Failed while inserting data into database!";
//         }
//     }
// }

//if user click login button
// if(isset($_POST['login_btn'])){
//     $eno_login = $_POST['enrollment_number'];
//     $password_login = $_POST['password'];
//     if (empty($eno_login) || empty($password_login)) {
//         $errors['fields'] = "Empty Fields! Please Filled It!"; 
//     }
//     $check_eno = "SELECT * FROM register WHERE enrollment_number = '$eno_login' and password = '$password_login' limit 1";
//     $res = mysqli_query($connection, $check_eno);
//     if(mysqli_num_rows($res) > 0){
//         $fetch = mysqli_fetch_assoc($res);
//         $status = $fetch['status'];
//             $_SESSION['new'] = 'true';
//             $_SESSION['user_name'] = $eno_login;
//             $_SESSION['password'] = $password_login;
//             header('location: index.php');
//     }
//     else{
//         $errors['incorrect-info'] = "Incorrect enrollment number or password!";
//     }
// }

// if(isset($_POST['logout_btn']))
// {
//     session_destroy();
//     unset($_SESSION['username']);
//     header('Location: login.php');
// }

// //email system start for forget password
// include('security.php');    
//     $mail="";
//     if(isset($_POST['rstbtn'])){
//         $f_mail=  ($_POST['email']);
//         $_SESSION['f_email']=$f_mail;
//         if($f_mail){
//             if(filter_var($f_mail, FILTER_VALIDATE_EMAIL)) {
//                 $sql=("select email,first_name,enrollment_number from register where email='$f_mail' ") or die (mysql_error());
//                 $results = mysqli_query($connection, $sql);
//                 $q=  mysqli_affected_rows($connection);
//                 if($q<1){
//                     echo'<div class="alert alert-danger absolue center text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                                 <span aria-hidden="true">×</span>
//                             </button>
//                                 <span class="text-danger">E-mail addresses did not match!</span>
//                         </div>';
//                 }
//                 else 
//                 if($q > 1){
//                     echo'<div class="alert alert-danger absolue center text-center" role="alert">
//                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                                 <span aria-hidden="true">×</span>
//                             </button>
//                                 <span class="text-danger">Duplicate e-mail address found!</span>
//                         </div>';
//                 }
//                 else 
//                     if($q == 1){
//                         $res=mysqli_fetch_array($results);
                        
//                         $id=$res['enrollment_number'];
                        
//                         $rid= md5(uniqid(rand(),true));
                        
//                         $key=md5($rid);
//                         $sql=("UPDATE register SET activation='$key' where enrollment_number='$id' ") or die (mysql_error());
                        
//                         $email=base64_encode($f_mail);
                        
//                         $name=$res['first_name'];
                        
//                         $to=$res['email'];
//                         $subject='Password Reset | GP Porbandar Department Library';
//                         $message="Hello $name,<br> 
//                                 Someone requested to reset your password.<br>
//                                 If this was you,<a href='localhost/DLMS /new_password.php'>click here</a>to reset your password,
			                    
//                                 if not just ignore this email.
//                                 <br><br>
// 			                Thank you,
//                                 <br><br>
//                                 GP Porbandar Department Library
//                                 <br><br>";
                            
//                         $headers = "MIME-Version: 1.0" . "\r\n";
//                         $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        
//                         $headers .='From:noreply@gmail.com/';
//                         $m=mail($to,$subject,$message,$headers);
                            
//                         if($m)
//                         {
//                             $mail="";
//                             $_SESSION['new']='true';
//                             header("Location:#");
//                             echo "<script type='text/javascript'> document.location = '#'; </script>";
//                             exit();
                            
//                         }
//                         else{
//                             echo'<div class="alert alert-danger absolue center text-center" role="alert">
//                                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                                         <span aria-hidden="true">×</span>
//                                     </button>
//                                         <span class="text-danger">Error occured while trying to send e-mail</span>
//                                 </div>';
//                         }
//                     }          
//         }
//         else {
//             echo'<div class="alert alert-danger absolue center text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                         <span aria-hidden="true">×</span>
//                     </button>
//                         <span class="text-danger">Invalid Format!</span>
//                 </div>';
//         }
//         }
//         else {
//                 echo'<div class="alert alert-danger absolue center text-center" role="alert">
//                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//                         <span aria-hidden="true">×</span>
//                     </button>
//                         <span class="text-danger">Enter your e-mail!</span>
//                 </div>';
//         }
//     }

//if user click newpassbtn button
// if(isset($_POST['newpassbtn'])){
//     $_SESSION['info'] = "";
//     $new_password = $_POST['newpassword'];
//     $new_cpassword = $_POST['conpassword'];
//     if($new_password !== $new_cpassword){
//         $errors['new-password'] = "Confirm password does not matched!";
//     }
//     else{
//         // $code = 0;
//         $remail=$_SESSION['f_email'];         //getting this email using session
//         $update_pass = "UPDATE register SET password = '$new_password' WHERE email = '$remail';";
//         $run_query = mysqli_query($connection, $update_pass);
//         if($run_query){
//             $info = "Your password changed. Now you can login with your new password.";
//             $_SESSION['info'] = $info;
//             header('Location: password_changed.php');
//         }
//         else{
//             $errors['db-error'] = "Failed to change your password!";
//         }
//     }
// }







//admin register:
//     if(isset($_POST['signupbtn'])){
//         $userid = $_POST['userid'];
//         $fname = $_POST['fname'];
//         $lname = $_POST['lname'];
//         $mail = $_POST['mail'];
//         $phoneno = $_POST['phoneno'];
//         $pass = $_POST['pass'];
//         $repeatpass = $_POST['repeatpass'];
    
//         if (empty($userid) || empty($fname) || empty($lname) || empty($mail) || empty($phoneno) || empty($pass) || empty($repeatpass)) {
//             $errors['fields'] = "Empty Fields! Please Filled It!"; 
//         }
        
//         if($pass !== $repeatpass){
//             $errors['password'] = "Confirm password not matched!";
//         }
    
//         $id_query = "SELECT * FROM admin WHERE user_id = '$userid'";
//         $id_query_run = mysqli_query($connection, $id_query);
//         if(mysqli_num_rows($id_query_run) > 0){
//             $errors['id'] = "User Id that you have entered is already exist!"; 
//         }

//         $mail_query = "SELECT * FROM admin WHERE email='$mail'";
//         $mail_query_run = mysqli_query($connection, $mail_query);
//         if(mysqli_num_rows($mail_query_run) > 0){
//             $errors['mail_err'] = "E-mail that you have entered is already exist!"; 
//         }
    
//         $phoneno_query = "SELECT * FROM admin WHERE contact='$phoneno'";
//         $phoneno_query_run = mysqli_query($connection, $phoneno_query);
//         if(mysqli_num_rows($phoneno_query_run) > 0){
//             $errors['phoneno_err'] = "Contact Number that you have entered is already exist!"; 
//         }
        
//         if(count($errors) === 0){
//             $fill_data = "INSERT INTO admin(user_id, first_name, last_name, email, contact, password) VALUES ('$userid','$fname','$lname','$mail','$phoneno','$pass')";
//             $check = mysqli_query($connection, $fill_data);
//                 if($check){
//                     $subject = "Registration As Admin For Library | GP Porbandar Department Library";
//                     $message="Hello '$userid',
//                         You Are Successfully Registered! in GP Porbandar Computer Department Library.
			        
//                         Thank you,
//                         GP Porbandar Department Library";
//                     $sender = "From: denisruparel28@gmail.com";
//                     if(mail($mail, $subject, $message, $sender)){
//                         $_SESSION['status'] = "Your Account is Successfully Registered As a Admin! We've sent a mail to your email - $mail";
//                         $_SESSION['status_code'] = "success";
//                         $_SESSION['email'] = $mail;
//                         $_SESSION['password'] = $pass;
//                         header('location: register.php');
//                         exit();
//                     }
//                 }
//                 else{
//                     $errors['db-error'] = "Failed while inserting data into database!";
//                 }
//         }        
//     }



// //if user click login button
// if(isset($_POST['signinbtn'])){
//     $uid = $_POST['uid'];
//     $upassword = $_POST['upassword'];
//     if (empty($uid) || empty($upassword)) {
//         $errors['fields'] = "Empty Fields! Please Filled It!"; 
//     }
//     $checkuid = "SELECT * FROM admin WHERE user_id = '$uid' and password = '$upassword' limit 1";
//     $res = mysqli_query($connection, $checkuid);
//     if(mysqli_num_rows($res) > 0){
//         $fetch = mysqli_fetch_assoc($res);
//         $status = $fetch['status'];
//         $_SESSION['new'] = 'true';
//         $_SESSION['uid'] = $uid;
//         $_SESSION['upassword'] = $upassword;
//         header('location: home.php');
//     }
//     else{
//         $errors['incorrect-info'] = "Incorrect user id or password!";
//     }
// }


// admin logout
// if(isset($_POST['logoutbtn'])){
//     session_destroy();
//     unset($_SESSION['uid']);
//     header('Location: admin_login.php');
// }

//for add book
// if(isset($_POST['savebtn'])){
//     $book_id = $_POST['book_id'];
//     $book_title = $_POST['book_title'];
//     $catagory = $_POST['catagory'];
//     $author_name = $_POST['author_name'];
//     $price = $_POST['price'];
//     $publication = $_POST['publication'];
//     $purchase_date = $_POST['purchase_date'];

//     $bookid_query = "SELECT * FROM books WHERE book_id='$book_id' ";
//     $bookid_query_run = mysqli_query($connection, $bookid_query);
//     if(mysqli_num_rows($bookid_query_run) > 0){ 
//         $errors['b_id'] = "Book ID that you have entered is already exist!";
//     }

//     if(count($errors) === 0){
//         $query = "INSERT INTO books(book_id, book_title, catagory, author_name, price, publication, purchase_date) VALUES ('$book_id','$book_title','$catagory','$author_name','$price','$publication','$purchase_date')";
//         $query_run = mysqli_query($connection, $query);
        
//         if($query_run){
//             $success['addbook'] = "Book Added Successsfully!";
//         }
//         else{
//             $errors['add-error'] = "Failed To Add Book Record!";
//         }
//     }
// }

//for modify book
// if(isset($_POST['updatebtn'])){
//     $book_id = $_POST['edit_book_id'];
//     $book_title = $_POST['edit_book_title'];
//     $catagory = $_POST['edit_catagory'];
//     $author_name = $_POST['edit_author_name'];
//     $price = $_POST['edit_price'];
//     $publication = $_POST['edit_publication'];
//     $purchase_date = $_POST['edit_purchase_date'];   

//     $updatequery = "UPDATE books SET book_id='$book_id', book_title='$book_title',catagory='$catagory',author_name='$author_name',price='$price',publication='$publication',purchase_date='$purchase_date' WHERE book_id='$book_id'";
//     $update_query_run = mysqli_query($connection, $updatequery);

//     if($update_query_run){
//         $_SESSION['status'] = "Book Record Updated Successsfully!";
//         $_SESSION['status_code'] = "success";
//         echo "<script>window.location.href='add_books.php';</script>";
//     }
//     else{
//         $_SESSION['status'] = "Failed To Update Book Record!";
//         $_SESSION['status_code'] = "error";
//         echo "<script>window.location.href='add_books.php';</script>";
//     }
// }

//for delete book
// if(isset($_POST['delete_btn'])){
//     $id = $_POST['delete_id'];

//     $query = "DELETE FROM books WHERE book_id='$id' ";
//     $query_run = mysqli_query($connection, $query);

//     if($query_run){ 
//         $_SESSION['status'] = "Book Record Deleted Successsfully!";
//         $_SESSION['status_code'] = "success";
//         echo "<script>window.location.href='add_books.php';</script>";
//     }
//     else{
//         $_SESSION['status'] = "Failed To Delete Book Record!";
//         $_SESSION['status_code'] = "error";
//         echo "<script>window.location.href='add_books.php';</script>";
//     }    
// }
?>