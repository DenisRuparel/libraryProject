<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php');
?>
<?php
    $id = $_GET['id'];
    $query = "SELECT * FROM requests WHERE enrollment_number='$id'";
    $query_run = mysqli_query($connection, $query);
    // $arr = mysqli_fetch_array($query_run);
    if(mysqli_fetch_array($query_run)){
        foreach($query_run as $row){
            $eno = $row['enrollment_number'];
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $email = $row['email'];
            $contact = $row['contact'];
            $password = $row['password'];
            $activation = $row['activation'];
            $avatar = $row['user_avatar'];
            $date = $row['date'];
    
            $insert = "INSERT INTO register(enrollment_number, first_name, last_name, email, contact, password, activation, user_avatar, date) VALUES ('$eno','$fname','$lname','$email','$contact','$password','$activation','$avatar','$date')";
            $insert_run = mysqli_query($connection, $insert);
        }
        $delete = "DELETE FROM requests WHERE enrollment_number='$id'";
        $delete_run = mysqli_query($connection, $delete);
        if($delete_run){
            echo '<div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
              <span class="text-success">"Account Has Been Accepted!"</span>
            </div>';
        }
        else{
            echo '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                  <span class="text-danger">"Unknown Error Occured!"</span>
                </div>';
        }
    }
    else{
        echo '<div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
              <span class="text-danger">"Error Occured!"</span>
            </div>';
    }

?>

<?php
include('admin/footer.php');
?>