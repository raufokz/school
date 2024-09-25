<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

include "../connect.php";

$logged_in_student_id = $_SESSION['student_id'];

// Query to fetch summarized data for the logged-in student
$attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE student_id = '$logged_in_student_id'")->fetch_assoc()['total'];
$grades_count = $conn->query("SELECT COUNT(*) as total FROM grades WHERE student_id = '$logged_in_student_id'")->fetch_assoc()['total'];

// Fetch student info
$student_info = $conn->query("SELECT * FROM students WHERE id = '$logged_in_student_id'")->fetch_assoc();
$student_name = $student_info['first_name'] . ' ' . $student_info['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> -->
  </head>
  <body>
  <?php include 'includes/navbar.php'; ?> <!-- Sidebar inclusion -->
    <div class="container-fluid">
      <div class="row">
        <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Dashboard for <?= $student_name ?></h1> <!-- Display the student's name -->
          </div>

          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Your Attendance Records</h5>
                  <p class="card-text"><?= $attendance_count ?></p> <!-- Display attendance count for the student -->
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Your Grades</h5>
                  <p class="card-text"><?= $grades_count ?></p> <!-- Display grades count for the student -->
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
