<?php
// session_start();
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
?>
<?php
//for add book
// $email = "";
// $name = "";
$errors = array();
$success = array();
if(isset($_POST['savebtn'])){
  $book_id = $_POST['book_id'];
  $book_title = $_POST['book_title'];
  $catagory = $_POST['catagory'];
  $author_name = $_POST['author_name'];
  $price = $_POST['price'];
  $publication = $_POST['publication'];
  $purchase_date = $_POST['purchase_date'];
  $quantity = $_POST['quantity'];
  $availability = 'available';

  $bookid_query = "SELECT * FROM books WHERE book_id='$book_id' ";
  $bookid_query_run = mysqli_query($connection, $bookid_query);
  if(mysqli_num_rows($bookid_query_run) > 0){ 
      $errors['b_id'] = "Book ID that you have entered is already exist!";
  }

  if(count($errors) === 0){
      $query = "INSERT INTO books(book_id, book_title, catagory, author_name, price, publication, purchase_date, quantity, availability) VALUES ('$book_id','$book_title','$catagory','$author_name','$price','$publication','$purchase_date','$quantity','$availability')";
      $query_run = mysqli_query($connection, $query);
      
      if($query_run){
          $success['addbook'] = "Book Added Successsfully!";
          $_SESSION['b_id'] = $book_id;
          // $_SESSION['book_title'] = $book_title;
      }
      else{
          $errors['add-error'] = "Failed To Add Book Record!";
      }
  }
}
?>

<div class="modal fade" id="addbook" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalLabel">Add Book Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="add_books.php" method="POST" autocomplete="">

        <div class="modal-body">

            <div class="form-group">
                <label> Book id </label>
                <input type="text" name="book_id" class="form-control" placeholder="Enter Book's id" required>
            </div>
            <div class="form-group">
                <label>Book Title</label>
                <input type="text" name="book_title" class="form-control" placeholder="Enter Book's Title" required>
            </div>
            <div class="form-group">
                <label>Catagory</label>
                <input type="text" name="catagory" class="form-control" placeholder="Enter Book's Catagory" required>
            </div>
            <div class="form-group">
                <label>Author Name</label>
                <input type="text" name="author_name" class="form-control" placeholder="Enter Book Author's Name" required>
            </div>
            <div class="form-group">
                <label>Price</label>
                <input type="number" name="price" class="form-control" placeholder="Enter Book's Price" required>
            </div>
            <div class="form-group">
                <label>Publication</label>
                <input type="text" name="publication" class="form-control" placeholder="Enter Book's Publication" required>
            </div>
            <div class="form-group">
                <label>Purchase Date</label>
                <input type="date" name="purchase_date" class="form-control" placeholder="Enter Book's Purchase Date" required>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" placeholder="Enter Book's Quantity" required>
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
    <h6 class="m-0 font-weight-bold text-primary">Add Book Records: &nbsp;
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addbook">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
              Add
            </button>
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
            <th> Book id </th>
            <th> Book Title </th>
            <th> Catagory </th>
            <th> Author Name</th>
            <th> Price </th>
            <th> Publication </th>
            <th> Purchase Date </th>
            <th> Quantity </th>
            <th> Availability </th>
            <th>EDIT </th>
            <th>DELETE </th>
          </tr>
        </thead>
        <tbody>
        <?php
        $query = "SELECT * FROM books";
        $query_run = mysqli_query($connection, $query);
        if(mysqli_num_rows($query_run) > 0){
          while($row = mysqli_fetch_assoc($query_run)){
            $availabel = '';
            if($row['availability'] == 'Available'){
							$availabel = '<h5><span class="badge badge-success">Available</span></h5>';
						}
						else{
							$availabel = '<h5><span class="badge badge-danger">Not Availabel</span></h5>';
						}
          ?>
            <tr>
            <td><?php  echo $row['book_id']; ?></td>
            <td><?php  echo $row['book_title']; ?></td>
            <td><?php  echo $row['catagory']; ?></td>
            <td><?php  echo $row['author_name']; ?></td>
            <td><?php  echo $row['price']; ?></td>
            <td><?php  echo $row['publication']; ?></td>
            <td><?php  echo $row['purchase_date']; ?></td>
            <td><?php  echo $row['quantity']; ?></td>
            <td><?php  echo $availabel; ?></td>
              <td>
                  <form action="modify_book.php" method="post">
                      <input type="hidden" name="edit_id" value="<?php echo $row['book_id'];?>">
                      <button  type="submit" name="edit_btn" class="btn btn-primary"> EDIT</button>
                  </form>
              </td>
              <td>
                  <form action="modify_book.php" method="post">
                    <input type="hidden" name="delete_id" value="<?php echo $row['book_id'];?>">
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
<!-- /.container-fluid -->

<?php
// include('admin/scripts.php');
include('admin/footer.php');
?>