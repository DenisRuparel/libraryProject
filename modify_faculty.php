<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
// require_once "code.php";
?>
<?php
//For update faculties
if(isset($_POST['updatebtn'])){
    $f_id = $_POST['edit_faculty_id'];
    $f_name = $_POST['edit_first_name'];
    $l_name = $_POST['edit_last_name'];
    $email = $_POST['edit_email
    '];
    $contact = $_POST['edit_contact'];
    $password = $_POST['edit_password'];   

    $updatequery = "UPDATE faculties SET f_id='$f_id', f_name='$f_name',l_name='$l_name',email='$email',contact='$contact',password='$password' WHERE f_id='$f_id'";
    $update_query_run = mysqli_query($connection, $updatequery);

    if($update_query_run){
        $_SESSION['status'] = "Faculty Record Updated Successsfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>window.location.href='add_faculties.php';</script>";
    }
    else{
        $_SESSION['status'] = "Failed To Update Faculty Record!";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location.href='add_faculties.php';</script>";
    }
}

//for delete book
if(isset($_POST['delete_btn'])){
    $id = $_POST['delete_id'];

    $query = "DELETE FROM faculties WHERE f_id='$id' ";
    $query_run = mysqli_query($connection, $query);

    if($query_run){ 
        $_SESSION['status'] = "Faculty Record Deleted Successsfully!";
        $_SESSION['status_code'] = "success";
        echo "<script>window.location.href='add_faculties.php';</script>";
    }
    else{
        $_SESSION['status'] = "Failed To Delete Faculty Record!";
        $_SESSION['status_code'] = "error";
        echo "<script>window.location.href='add_faculties.php';</script>";
    }    
}

?>
<div class="container-fluid">

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header text-primary font-weight-bold">
            <i class="fas fa-user-edit text-primary"></i>Edit Faculty Records
        </div>
        
        <div class="card-body">
        <?php
            if(isset($_POST['edit_btn'])){
                $id = $_POST['edit_id'];
                $query = "SELECT * FROM faculties WHERE f_id='$id' ";
                $query_run = mysqli_query($connection, $query);
                foreach($query_run as $row){
                    ?>
                        <form action="modify_faculty.php" method="POST" autocomplete="">
                        <div class="form-group">
                            <label> Faculty id </label>
                            <input type="text" name="edit_faculty_id" value="<?php echo $row['f_id']?>" class="form-control" placeholder="Enter Faculty's id">
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="edit_first_name" value="<?php echo $row['f_name'] ?>" class="form-control" placeholder="Enter Faculty's First Name">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="edit_last_name" value="<?php echo $row['l_name'] ?>" class="form-control" placeholder="Enter Faculty's Last Name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="edit_email" value="<?php echo $row['email'] ?>" class="form-control" placeholder="Enter Faculty's Email">
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="tel" name="edit_contact" value="<?php echo $row['contact'] ?>" class="form-control" placeholder="Enter Faculty's Contact" >
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="edit_password" value="<?php echo $row['password'] ?>" class="form-control" placeholder="Enter Faculty's Password">
                        </div>
                            <a href="add_faculties.php" class="btn btn-danger"> CANCEL </a>
                            <button type="submit" name="updatebtn" class="btn btn-primary"> Update </button>
                        </form>
                        <?php
                }
            }
        ?>
        </div>
    </div>
</div>

</div>




<?php
// include('admin/scripts.php');
include('admin/footer.php');
?>