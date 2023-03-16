<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
include('function.php');
if (!isset($_SESSION["uid"])) {
  header("location:admin_login.php");
} 
?>
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
        <th> Issue Days</th>
        <th> Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM issue_book WHERE book_issue_status = 'Return'";
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
        <td><?php  echo "hello" ?></td>
        <td>
        <?php
          echo'
          <a href="issue_book.php?action=view&code='.convert_data($row["issue_book_id"]).'" class="btn btn-primary">
            View
          </a>'
        ?>
        </td>
        </tr>
      <?php
      } 
    }
      ?>
    </tbody>
  </table>

</div>
</div>
</div>

</div>
<?php
// include('admin/footer.php');
?>