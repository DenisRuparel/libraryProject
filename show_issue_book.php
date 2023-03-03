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
?>
<?php
  if ($_GET["action"] == 'view') {
    echo 'hello';
  }
?>


<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Issue Book &nbsp;
            <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addbook">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
              Add
            </button> -->
            <a href="issue_book.php?action=add" class="btn btn-primary">
              <i class="fa fa-plus-circle" aria-hidden="true"></i>
              Add
            </a>
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
            <th> Book Id </th>
            <th> Enrollment Number </th>
            <th> Book Issue Date</th>
            <th> Book Return Date</th>
            <th> Book Status</th>
            <th> Action</th>
            <!-- <th>EDIT </th>
            <th>DELETE </th> -->
          </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM issue_book";
        $query_run = mysqli_query($connection, $query);
        if(mysqli_num_rows($query_run) > 0){
          while($row = mysqli_fetch_assoc($query_run)){
            $status = $row["book_issue_status"];
						
            if($status == 'Issue'){
							$status = '<h5><span class="badge badge-success">Issue</span></h5>';
						}

						if($status == 'Not Return'){
							$status = '<h5><span class="badge badge-danger">Not Return</span></h5>';
						}

						if($status == 'Return'){
							$status = '<h5><span class="badge badge-warning">Return</span></h5>';
						}
          ?>
            <tr>
            <td><?php  echo $row['book_id']; ?></td>
            <td><?php  echo $row['user_id']; ?></td>
            <td><?php  echo $row['issue_date_time']; ?></td>
            <td><?php  echo $row['expected_return_date']; ?></td>
            <td><?php  echo $status; ?></td>
            <td>
              <a href="issue_book.php?action=view&code='.convert_data($row["issue_book_id"]).'" class="btn btn-primary">
                View
              </a>
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