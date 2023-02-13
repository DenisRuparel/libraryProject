<?php
// session_start();
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
?>
<?php
//for issue book

$errors = array();
$success = array();
if(isset($_POST['savebtn'])){
  $enrollment_number = $_POST['enrollment_number'];
  // $book_id= $_POST['book_id'];
  // $book_title=$_POST['book_title'];
  // $book_issue_date = $_POST['book_issue_date'];
  // $book_return_date = $_POST['book_return_date'];


  $bookid_query = "SELECT * FROM issue_book WHERE enrollment_number='$enrollment_number' ";
  $bookid_query_run = mysqli_query($connection, $bookid_query);
  if(mysqli_num_rows($bookid_query_run) > 0){ 
      $errors['enrollment_number'] = "Enrollment Number that you have entered is already exist!";
  }

  if(count($errors) === 0){
      $query = "INSERT INTO issue_book(enrollment_number,book_id,book_title,book_issue_date,book_return_date) VALUES ('$enrollment_number','$book_id','$book_title','$book_issue_date','$book_return_date')";
      $query_run = mysqli_query($connection, $query);
      
      if($query_run){
          $success['addbook'] = "Book issue Successsfully!";
      }
      else{
          $errors['add-error'] = "Failed To issue Book !";
      }
  }
}
?>
<!-- <div class="container-fluid">


<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">issue books : </h6> -->
    <div class="modal fade" id="addbook" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">issue Book Record :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="issue_book_admin.php" method="POST" autocomplete="">

        <div class="modal-body">

            <div class="form-group">
                <label> Enrollment Number </label>
                <input type="number" name="enrollment_number" class="form-control" placeholder="Enter Enrollment Number " required>
            </div>
            <div class="form-group">
                <label>Book Id </label>
                <input type="text" name="book_id" class="form-control" placeholder="Enter Book Id" required>
            </div>
            <div class="form-group">
                <label>Book Title </label>
                <input type="text" name="book_title" class="form-control" placeholder="Enter Book Title" required>
            </div>
            <div class="form-group">
                <label>Book Issue date</label>
                <input type="date" name="book_issue_date" class="form-control" placeholder="Enter Book Issue Date" required>
            </div>
            <div class="form-group">
                <label>Book Return Date</label>
                <input type="date" name="book_return_date" class="form-control" placeholder="Enter Book Return Date" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="savebtn" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Issue Book Records: &nbsp;
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addbook">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
              Issue
            </button> -->
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
            </h6>
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
      }
      elseif(count($errors) > 1){
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
      elseif(count($success) == 1){
        ?>
      <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
      </button>
        <?php
        foreach($success as $showsuccess){
          ?>
          <li><?php echo $showsuccess; ?></li>
          <?php
        }
          ?>
      </div>
      <?php
    }
      ?>
  </div>

  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered" id="datatableid" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> Enrollment Number </th>
            <th> Book Id </th>
            <th> Book Title </th>
            <th> Book Issue Date</th>
            <th> Book Return Date</th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM issue_book";
        $query_run = mysqli_query($connection, $query);
        if(mysqli_num_rows($query_run) > 0){
          while($row = mysqli_fetch_assoc($query_run)){
          ?>
            <tr>
            <td><?php  echo $row['enrollment_number']; ?></td>
            <td><?php  echo $row['book_id']; ?></td>
            <td><?php  echo $row['book_title']; ?></td>
            <td><?php  echo $row['issue_date']; ?></td>
            <td><?php  echo $row['return_date']; ?></td>
              <td>
                  <form action="issue_book_modify.php" method="post">
                      <input type="hidden" name="edit_id" value="<?php echo $row['enrollment_number'];?>">
                      <button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button>
                  </form>
              </td>
              <td>
                  <form action="issue_book_modify.php" method="post">
                    <input type="hidden" name="delete_id" value="<?php echo $row['enrollment_number'];?>">
                    <button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button>
                  </form>
              </td>
            </tr>
          <?php
          } 
        }
        else{
          echo "No Record Found";
        }
          ?>
        </tbody>
      </table>

    </div>
  </div>
</div>

</div>

