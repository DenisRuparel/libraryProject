<?php
include('admin/header.php'); 
include('admin/navbar.php'); 
include('security.php'); 
include('function.php');

// $total_book_issue_day = get_total_book_issue_day($connection);

// $today_date = get_date_time($connection);

// $expected_return_date = date('Y-m-d H:i:s', strtotime($today_date. ' + '.$total_book_issue_day.' days'));

// echo $expected_return_date;

// $today_date = "2023-03-17";

// $expected_return_date = "2023-03-31";

$query = "SELECT issue_date_time from issue_book";

$run = mysqli_query($connection, $query);

$output = mysqli_fetch_assoc($run);

$issue_date = $output['issue_date_time'];

$cur_date = date('Y-m-d H:i:s');

$days = strtotime($cur_date)-strtotime($issue_date);

// $fine = get_one_day_fines($connection);

echo "difference in ".$days/(24*60*60)." days";


// $date1 = "2021-01-25 10:15:23";

// $date2 = "2021-09-06 13:19:00";

// $difference = strtotime($date2)-strtotime($date1);

// echo "Difference is: ".floor($difference/(24*60*60))." days";




// $date1 = "2021-01-25";
// $date2 = "2021-09-06";
// $time1 = strtotime($date1);
// $time2 = strtotime($date2);
// $diff = $time1 - $time2;
// echo "difference in ".$diff/(24*60*60)." days";
?>