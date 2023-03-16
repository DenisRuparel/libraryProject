<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
include('function.php');
if (!isset($_SESSION["uid"])) {
  header("location:admin_login.php");
} 
?>
<?php
$errors = NULL;
$success = array();
// $err = '';
// $rdate = date("d/m/Y", strtotime("+15 days"));
if(isset($_POST["issue_book_button"])){
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];

    // if(empty($_POST["book_id"])){
    //     $errors .= '<li>Book ID is required!</li>';
    // }

    // if(empty($_POST["user_id"])){
    //     $errors .= '<li>Student Enrollment Number is required!</li>';
    // }

    // if(empty($_POST["book_id"]) || empty($_POST["user_id"])){
    //     $errors .= '<li>Empty Fields Fill it!</li>';
    // }

    if($errors == NULL){
      $query = "SELECT * FROM books WHERE book_id = '$book_id'";

      $query_run= mysqli_query($connection, $query);

      if(mysqli_num_rows($query_run) > 0){

        foreach($query_run as $book_row){
        
          if($book_row['availability'] == 'Available'){
        
            $book_issue_limit = get_book_issue_limit_per_user($connection);

            $total_book_issue = get_total_book_issue_per_user($connection, $user_id);

            if($total_book_issue < $book_issue_limit){

              $total_book_issue_day = get_total_book_issue_day($connection);

              $today_date = get_date_time($connection);

              $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

              $insert_query = "INSERT INTO issue_book 
                              (book_id, user_id, issue_date_time, expected_return_date, return_date_time, book_fines, book_issue_status) 
                              VALUES ('$book_id', '$user_id', '$today_date', '$expected_return_date', '', '0 Rs.', 'Issue')";

                              $insert_query_run = mysqli_query($connection, $insert_query);

                              $update_query = "UPDATE books SET availability = 'Not Available', 
                                              book_updated_on = '$today_date' WHERE book_id = '$book_id'";

                              $update_query_run = mysqli_query($connection, $update_query);

                              echo "<script>window.location.href='issue_book.php?msg=add';</script>";
              }
              else{
                $errors .= 'User has already reached Book Issue Limit, First return pending book!';
              }
          }
          else{
            $errors .= 'Book not Available!';
          }
        }
      }
      else{
        $errors .= 'Book not Found!';
      }
    }
    else{
      $errors .= '<li>Some Error Occured!</li>';
    }
}

if(isset($_POST["book_return_button"])){
    if(isset($_POST["book_return_confirmation"])){ 
        $data = array(
          ':return_date_time'     =>  get_date_time($connection),
          ':book_issue_status'    =>  'Return',
          ':issue_book_id'        =>  $_POST['issue_book_id']
        );

        $query = "UPDATE issue_book 
        SET return_date_time = :return_date_time, 
        book_issue_status = :book_issue_status 
        WHERE issue_book_id = :issue_book_id";

        $statement = $connect->prepare($query);

        $statement->execute($data);

        $query = "UPDATE books 
        SET availability = 'Available' 
        WHERE book_id = '".$_POST["book_id"]."'";

        $connect->query($query);

        echo "<script>window.location.href='issue_book.php?msg=return';</script>";
    }
    else{
        $errors = 'Please first confirm return book received by click on checkbox';
    }
}   

$query = "SELECT * FROM issue_book 
          ORDER BY issue_book_id DESC";

$statement = mysqli_query($connection, $query);

?>
    <?php
      if(isset($_GET['msg'])){
        if($_GET['msg'] == 'add'){
          echo '<div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                    <span class="text-success">Book Issued Successfully!</span>
                </div>';
        }
        if($_GET['msg'] == 'return'){
          echo '<div class="alert alert-success" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                    <span class="text-success">Book Returned Successfully!</span>
                </div>';
        }
      }
    ?>
<?php 

if(isset($_GET["action"]))
{
    if($_GET["action"] == 'add')
    {
?>
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"> Issue Book </h6>
    </div>
    <div class="card-body">
      <form action="issue_book.php" method="POST" autocomplete="">
        <div class="mb-3">
          <label class="form-label">Book ID</label>
          <span style="color:red;">*</span>
          <input type="text" name="book_id" id="book_id" class="form-control" required/>
          <span id="book_id_result"></span>
        </div>
        <div class="mb-3">
          <label class="form-label">Student Enrollment Number</label>
          <span style="color:red;">*</span>
          <input type="text" name="user_id" id="user_id" class="form-control" required/>
          <span id="enrollment_number_result"></span>
        </div>
        <div class="mt-4 mb-0">
          <input type="submit" name="issue_book_button" class="btn btn-primary" value="Issue" />
        </div>
      </form>
      <script>
        var book_id = document.getElementById('book_id');

        book_id.onkeyup = function () {
          if (this.value.length > 0) {
            var form_data = new FormData();

            form_data.append('action', 'search_book_id');

            form_data.append('request', this.value);

            fetch('action.php', {
              method: "POST",
              body: form_data
            }).then(function (response) {
              return response.json();
            }).then(function (responseData) {
              var html = '<div class="list-group" style="position:absolute; width:97%">';

              if (responseData.length > 0) {
                for (var count = 0; count < responseData.length; count++) {
                  // html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text(this)">' + responseData[count].id + ' - ' + responseData[count].book_title + '</span></a>';
                  html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text(this)">'+responseData[count].id+'</span> - <span class="text-muted">'+responseData[count].book_title+'</span></a>';
                  // html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">' + responseData[count].id + ' - ' + responseData[count].book_title + '</a>';
                }
              }
              else {
                html += '<a href="#" class="list-group-item list-group-item-action">No Book Found</a>';
              }

              html += '</div>';

              document.getElementById('book_id_result').innerHTML = html;
            });
          }
          else {
            document.getElementById('book_id_result').innerHTML = '';
          }
        }

        function get_text(event) {
          document.getElementById('book_id_result').innerHTML = '';

          document.getElementById('book_id').value = event.textContent;
        }

        var user_id = document.getElementById('user_id');

        user_id.onkeyup = function () {
          if (this.value.length > 0) {
            var form_data = new FormData();

            form_data.append('action', 'search_user_id');

            form_data.append('request', this.value);

            fetch('action.php', {
              method: "POST",
              body: form_data
            }).then(function (response) {
              return response.json();
            }).then(function (responseData) {
              var html = '<div class="list-group" style="position:absolute; width:97%">';

              if (responseData.length > 0) {
                for (var count = 0; count < responseData.length; count++) {
                  html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text1(this)">'+responseData[count].enrollment_number+'</span> - <span class="text-muted">'+responseData[count].first_name+' '+ responseData[count].last_name + '</span></a>';
                }
              }
              else {
                html += '<a href="#" class="list-group-item list-group-item-action">No Student Found</a>';
              }
              html += '</div>';

              document.getElementById('enrollment_number_result').innerHTML = html;
            });
          }
          else {
            document.getElementById('enrollment_number_result').innerHTML = '';
          }
        }

        function get_text1(event) {
          document.getElementById('enrollment_number_result').innerHTML = '';

          document.getElementById('user_id').value = event.textContent;
        }

      </script>
    </div>
  </div>
</div>

</div>
<?php 
  }
        else if($_GET["action"] == 'view'){
            $issue_book_id = convert_data($_GET["code"], 'decrypt');

            if($issue_book_id > 0){
                $query = "SELECT * FROM issue_book 
                WHERE issue_book_id = '$issue_book_id'";

                $result = mysqli_query($connection, $query);

                foreach($result as $row){
                    $query = "SELECT * FROM books 
                    WHERE book_id = '".$row["book_id"]."' ";

                    $book_result = mysqli_query($connection, $query);

                    $query = "SELECT * FROM register 
                    WHERE enrollment_number = '".$row["user_id"]."'";

                    $user_result = mysqli_query($connection, $query);

                    if($errors != ''){
                        echo '<div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                              </button>'.$errors.'</div>';
                    }

                    foreach($book_result as $book_data){
                        echo '
                        <div class="container-fluid">
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                              <h4 class="m-0 font-weight-bold text-primary"> Book Details </h4>
                              <table class="table table-bordered">
                                  <tr>
                                      <th width="30%">Book ID</th>
                                      <td width="70%">'.$book_data["book_id"].'</td>
                                  </tr>
                                  <tr>
                                      <th width="30%">Book Title</th>
                                      <td width="70%">'.$book_data["book_title"].'</td>
                                  </tr>
                                  <tr>
                                      <th width="30%">Author</th>
                                      <td width="70%">'.$book_data["author_name"].'</td>
                                  </tr>
                              </table>
                              </div>
                            </div>
                          </div>
                        ';
                    }

                    foreach($user_result as $user_data)
                    {
                        echo '
                        <div class="container-fluid">
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                              <h4 class="m-0 font-weight-bold text-primary"> User Details </h4>
                              <table class="table table-bordered">
                                  <tr>
                                      <th width="30%">Enrollment Number</th>
                                      <td width="70%">'.$user_data["enrollment_number"].'</td>
                                  </tr>
                                  <tr>
                                      <th width="30%">Full Name</th>
                                      <td width="70%">'.$user_data["first_name"].' '.$user_data["last_name"].'</td>
                                  </tr>
                                  <tr>
                                      <th width="30%">Contact No.</th>
                                      <td width="70%">'.$user_data["contact"].'</td>
                                  </tr>
                                  <tr>
                                      <th width="30%">Email Address</th>
                                      <td width="70%">'.$user_data["email"].'</td>
                                  </tr>
                              </table>
                              </div>
                            </div>
                          </div>
                        ';
                    }

                    $status = $row["book_issue_status"];

                    $form_item = '';

                    if($status == "Issue"){
                        $status = '<h5><span class="badge badge-success">Issue</span></h5>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> I aknowledge that I have received Issued Book</label>
                        <br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }

                    if($status == 'Not Return'){
                        $status = '<h5><span class="badge badge-danger">Not Return</span></h5>';

                        $form_item = '
                        <label><input type="checkbox" name="book_return_confirmation" value="Yes" /> I aknowledge that I have received Issued Book</label><br />
                        <div class="mt-4 mb-4">
                            <input type="submit" name="book_return_button" value="Book Return" class="btn btn-primary" />
                        </div>
                        ';
                    }

                    if($status == 'Return'){
                        $status = '<h5><span class="badge badge-warning">Return</span></h5>';
                    }

                    echo '
                    <div class="container-fluid">
                      <div class="card shadow mb-4">
                        <div class="card-header py-3">
                          <h4 class="m-0 font-weight-bold text-primary"> Issue Book Details </h4>
                          <table class="table table-bordered">
                              <tr>
                                  <th width="30%">Book Issue Date</th>
                                  <td width="70%">'.$row["issue_date_time"].'</td>
                              </tr>
                              <tr>
                                  <th width="30%">Book Return Date</th>
                                  <td width="70%">'.$row["expected_return_date"].'</td>
                              </tr>
                              <tr>
                                  <th width="30%">Book Issue Status</th>
                                  <td width="70%">'.$status.'</td>
                              </tr>
                          </table>
                          <form method="POST">
                              <input type="hidden" name="issue_book_id" value="'.$issue_book_id.'" />
                              <input type="hidden" name="book_id" value="'.$row["book_id"].'" />
                              '.$form_item.'
                          </form>
                          </div>
                        </div>
                      </div>
                    ';
                }
            }
        }
}
else{
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
              Issue
            </a>
            <?php 
              if($errors != NULL) {
                // echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$errors.'</ul> <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                echo'<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">×</span>
                    </button>
                      <span class="text-danger">'.$errors.'</span>
                    </div>';
              }
            ?>
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
        }
      ?>
<?php
// include('admin/scripts.php');
include('admin/footer.php');
?>