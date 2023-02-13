<?php
include('security.php');
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<!-- Begin Page Content -->
<div class="container-fluid">

<?php
  if(isset($_SESSION['new'])=="true"){
    echo '<div class="alert alert-success" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
        <span class="text-success">Hello! '.$_SESSION['user_name'].' Now You are logged in!</span>
      </div>';
    unset($_SESSION['success']); 
   }
  ?>

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
  </div>

  <!-- Content Row -->
  <div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Books</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php
                  require 'database/dbconfig.php';
                  $query = "SELECT book_id FROM books ORDER BY book_id";  
                  $query_run = mysqli_query($connection, $query);
                  $row = mysqli_num_rows($query_run);
                  echo '<h4> Total Books: '.$row.'</h4>';
                ?>
              </div>
            </div>
            <div class="col-auto">
              <i class="fa fa-book fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Issued/Return Books</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">115</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-book fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Paid Fines</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">50</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Row -->


<?php
// include('includes/scripts.php');
include('includes/footer.php');
?>