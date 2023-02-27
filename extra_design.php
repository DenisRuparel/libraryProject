<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Registered Students</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">

               <?php
                  require 'database/dbconfig.php';
                  $query = "SELECT enrollment_number FROM register ORDER BY enrollment_number";  
                  $query_run = mysqli_query($connection, $query);
                  $row = mysqli_num_rows($query_run);
                  echo '<h4> Total Students: '.$row.'</h4>';
                ?>
          
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


    $query = "SELECT * FROM settings";
    $query_run = mysqli_query($connection, $query);

    foreach($query_run as $row){
      $book_issue_limit = $row["library_issue_total_book_per_user"];

      $total_book_issue_day = $row["library_total_book_issue_day"];
    }

<!-- Earnings (Monthly) Card Example -->
    <!-- <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Issued Books</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50"
                      aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div> -->

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Collected Fines</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">1825</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
$errors = array();
$success = array();
// $rdate = date("d/m/Y", strtotime("+15 days"));
if(isset($_POST["issue_book_button"])){
  $book_id = $_POST['book_id'];
  $user_id = $_POST['user_id'];

  if(empty($_POST["book_id"])){
      $errors['b-id'] = 'Book ID is required!';
  }

  if(empty($_POST["user_id"])){
      $errors['u-id'] = 'Student Enrollment Number is required!';
  }

  if(empty($_POST["book_id"]) || empty($_POST["user_id"])){
      $errors['boru-id'] = 'Empty Fields Fill it!';
  }

  if($errors == ''){

    $book_issue_limit = get_book_issue_limit_per_user($connection);

    $total_book_issue = get_total_book_issue_per_user($connection, $user_id);

    if($total_book_issue < $book_issue_limit){
      $total_book_issue_day = get_total_book_issue_day($connection);

      $today_date = get_date_time($connection);

      $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

      $insert_query = "INSERT INTO issue_book 
                      enrollment_number, book_id, issue_date, return_date, book_issue_status) 
                      VALUES ('$user_id', '$book_id', '$today_date', '$expected_return_date', 'Issue')";

                      $insert_query_run = mysqli_query($connection, $insert_query);

                      if ($insert_query_run) {
                        $success['issuebook'] = "Book Issued Successsfully!";
                      }
                      else {
                        $errors['issue-error'] = "Failed To Issue Book!";
                      }

                      $update_query = "UPDATE books SET quantity = quantity - 1, 
                                      book_updated_on = '$today_date' WHERE book_id = '$book_id'";

                      $update_query_run = mysqli_query($connection, $update_query);

                      header('location:issue_book.php?msg=add');
      }
      else{
        $errors['r-book'] = 'User has already reached Book Issue Limit, First return pending book!';
      }
    }
    else{
      $errors['err'] = 'Some Error Occured!';
    }
  }





















  // -------------------------------------------------------------------------------------------------------------
  $book_issue_limit = get_book_issue_limit_per_user($connection);

      $total_book_issue = get_total_book_issue_per_user($connection, $user_id);

      if($total_book_issue < $book_issue_limit){
        $total_book_issue_day = get_total_book_issue_day($connection);

        $today_date = get_date_time($connection);

        $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

        $insert_query = "INSERT INTO issue_book 
                        (book_id, user_id, issue_date_time, expected_return_date, book_issue_status) 
                        VALUES ('$book_id', '$user_id', '$today_date', '$expected_return_date', 'Issue')";

                        $insert_query_run = mysqli_query($connection, $insert_query);

                        if ($insert_query_run) {
                          $success['issuebook'] = "Book Issued Successsfully!";
                        }
                        else {
                          $errors['issue-error'] = "Failed To Issue Book!";
                        }

                        $update_query = "UPDATE books SET quantity = quantity - 1, 
                                        book_updated_on = '$today_date' WHERE book_id = '$book_id'";

                        $update_query_run = mysqli_query($connection, $update_query);

                        header('location:issue_book.php?msg=add');
                      }
?>