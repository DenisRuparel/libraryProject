<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
include('function.php');
if (!isset($_SESSION["uid"])) {
  header("location:admin_login.php");
} 
?>
<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Return Book Records:</h6>
  </div>
      <div class="card-body">

<div class="table-responsive">
  <table class="table table-bordered" id="datatableid" width="100%" cellspacing="0">
    <thead>
      <tr>
        <th> Book ID </th>
        <th> User ID </th>
        <th> Book Issue Date</th>
        <th> Book Expected Return Date</th>
        <th> Book Return Date</th>
        <th> Book Fines</th>
        <th> Book Status</th>
        <th> Days</th>
        <th> Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    $query = "SELECT * FROM f_issue_book WHERE book_issue_status = 'Return'";
    $query_run = mysqli_query($connection, $query);
    if(mysqli_num_rows($query_run) > 0){
      while($row = mysqli_fetch_assoc($query_run)){
        $status = $row["book_issue_status"];
                    
        // if($status == 'Issue'){
        //   $status = '<h5><span class="badge badge-success">Issue</span></h5>';
        // }

        // if($status == 'Not Return'){
        //   $status = '<h5><span class="badge badge-danger">Not Return</span></h5>';
        // }

        if($status == 'Return'){
           $status = '<h5><span class="badge badge-warning">Return</span></h5>';
        }
        $issue_date = $row['issue_date_time'];

        $cur_date = $row['return_date_time'];

        $days = strtotime($cur_date)-strtotime($issue_date); 

        $expected_date = $row['expected_return_date']; 

        $res = strtotime($expected_date)-strtotime($issue_date); 

        $fine = null;

        if ($days <= $res) {
          $status = '<h5><span class="badge badge-warning">Return</span></h5>';
        }
        else {
          $late = strtotime($cur_date)-strtotime($expected_date); 
          $status = '<h5><span class="badge badge-danger">'.floor($late/(24*60*60)).' Day Late Return</span></h5>';

          $fine_func = get_one_day_fines($connection);

          $fine = floor($late/(24*60*60)) * $fine_func;
        }
      ?>
        <tr>
        <td><?php  echo $row['book_id']; ?></td>
        <td><?php  echo $row['user_id']; ?></td>
        <td><?php  echo $row['issue_date_time']; ?></td>
        <td><?php  echo $row['expected_return_date']; ?></td>
        <td><?php  echo $row['return_date_time']; ?></td>
        <td><?php  echo $fine; ?></td>
        <td><?php  echo $status; ?></td>
        <td><?php  echo floor($days/(24*60*60)); ?></td>
        <td>
        <?php
          echo'
          <a href="faculty_issue_book.php?action=view&code='.convert_data($row["issue_book_id"]).'" class="btn btn-primary">
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
  </div>
  </div>
<?php
// include('admin/footer.php');
?>