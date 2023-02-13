<?php
// session_start();
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
include('function.php'); 
?>
<?php
$errors = array();
$success = array();
// $rdate = date("d/m/Y", strtotime("+15 days"));
if(isset($_POST["issue_book_button"])){
    // $formdata = array();

    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];

    if(empty($_POST["book_id"])){
        $errors['b-id'] = 'Book ID is required!';
    }
    // else{
    //     $formdata['book_id'] = trim($_POST['book_id']);
    // }

    if(empty($_POST["user_id"])){
        $errors['u-id'] = 'Student Enrollment Number is required!';
    }
    // else{
    //     $formdata['user_id'] = trim($_POST['user_id']);
    // }

    if($errors == ''){
        //Check Book Available or Not

        $query_select_books = "SELECT * FROM books 
        WHERE book_id = '$book_id' ";

        // $statement = $connection->prepare($query);

        // $statement->execute();

        $query_run_books = mysqli_query($connection,$query_select_books);

        if(mysqli_num_rows($query_run_books) > 0){
            foreach($query_run_books as $book_row){
                //check book is available or not
                if($book_row['availability'] == 'Available' && $book_row['quantity'] > 0){
                    //Check User is exist

                    $query_select_eno= "SELECT enrollment_number FROM register 
                    WHERE enrollment_number = '$user_id'
                    ";

                    $query_run_eno = mysqli_query($connection,$query_select_eno);          

                    if(mysqli_num_rows($query_run_eno) > 0){
                        foreach($query_run_eno as $user_row){
                                //Check User Total issue of Book

                                $book_issue_limit = get_book_issue_limit_per_user($connection);

                                $total_book_issue = get_total_book_issue_per_user($connection, $formdata['user_id']);

                                if($total_book_issue < $book_issue_limit){
                                    $total_book_issue_day = get_total_book_issue_day($connection);

                                    $today_date = get_date_time($connection);

                                    $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

                                    // $data = array(
                                    //     ':book_id'      =>  $formdata['book_id'],
                                    //     ':user_id'      =>  $formdata['user_id'],
                                    //     ':issue_date_time'  =>  $today_date,
                                    //     ':expected_return_date' => $expected_return_date,
                                    //     ':book_issue_status'    =>  'Issue'
                                    // );

                                    $insert_query = "INSERT INTO issue_book 
                                    (enrollment_number, book_id, issue_date, return_date, book_issue_status) 
                                    VALUES ('$user_id', '$book_id', '$today_date', '$expected_return_date', 'Issue')";

                                    // $statement = $connection->prepare($query);

                                    // $statement->execute($data);

                                    $insert_query_run = mysqli_query($connection, $insert_query);

                                    if ($insert_query_run) {
                                      $success['issuebook'] = "Book Issued Successsfully!";
                                    }
                                    else {
                                      $errors['issue-error'] = "Failed To Issue Book!";
                                    }

                                    $update_query = "UPDATE books 
                                    SET quantity = quantity - 1, 
                                    book_updated_on = '$today_date' 
                                    WHERE book_id = '$book_id'";

                                    // $connection->query($query);
                                    $update_query_run = mysqli_query($connection, $update_query);

                                    header('location:issue_book.php?msg=add');
                                }
                                else{
                                    $errors['r-book'] = 'User has already reached Book Issue Limit, First return pending book';
                                }
                        }
                    }
                    else{
                        $error['u-notfound'] = 'User not Found';
                    }
                }
                else{
                    $errors['b-notavailable'] = 'Book not Available';
                }
            }
        }
        else{
            $errors['b-notfound'] = 'Book not Found';
        }
    }
}
?>
<div class="container-fluid">
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary"> Issue Book </h6>
    </div>

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
      <li>
        <?php echo $showerror; ?>
      </li>
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
      <li>
        <?php echo $showsuccess; ?>
      </li>
      <?php
        }
          ?>
    </div>
    <?php
    }
      ?>

    <div class="card-body">
      <form action="issue_book.php" method="POST" autocomplete="">
        <div class="mb-3">
          <label class="form-label">Book ID</label>
          <input type="text" name="book_id" id="book_id" class="form-control" />
          <span id="book_id_result"></span>
        </div>
        <div class="mb-3">
          <label class="form-label">Student Enrollment Number</label>
          <input type="text" name="user_id" id="user_id" class="form-control" />
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
              var html = '<div class="list-group" style="position:absolute; width:93%">';

              if (responseData.length > 0) {
                for (var count = 0; count < responseData.length; count++) {
                  html += '<a href="#" class="list-group-item list-group-item-action"><span onclick="get_text(this)">' + responseData[count].id + ' - ' + responseData[count].book_title + '</span></a>';
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
              var html = '<div class="list-group" style="position:absolute; width:93%">';

              if (responseData.length > 0) {
                for (var count = 0; count < responseData.length; count++) {
                  html += '<span onclick="get_text1(this)"><a href="#" class="list-group-item list-group-item-action">' + responseData[count].enrollment_number + ' - ' + responseData[count].first_name + ' ' + responseData[count].last_name + '</span></a>';
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
// include('admin/scripts.php');
include('admin/footer.php');
?>