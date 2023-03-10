<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('security.php');
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">your issued Books: </h6>
  </div>
</div>

  <div class="card-body">

    <div class="table-responsive">
      <table class="table table-bordered" id="datatableid" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th> Book Id </th>
            <th> Book Title </th>
            <th> Book Issue Date</th>
            <th> Book Return Date</th>
            <th> Book Status</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $query = "SELECT * FROM issue_book 
          INNER JOIN books 
          ON books.book_id = issue_book.book_id 
          WHERE issue_book.user_id = '".$_SESSION['user_name']."' 
          ORDER BY issue_book.issue_book_id DESC";
        // $query = "SELECT book_id,book_title,issue_date,return_date FROM issue_book WHERE enrollment_number = '".$_SESSION['user_name']."' ";
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
              <td><?php  echo $row['book_title']; ?></td>
              <td><?php  echo $row['issue_date_time']; ?></td>
              <td><?php  echo $row['expected_return_date']; ?></td>
              <td><?php  echo $status; ?></td>
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
<!-- /.container-fluid -->

<?php
// include('includes/scripts.php');
include('includes/footer.php');
?>