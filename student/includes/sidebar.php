<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.html"); // Redirect to login page if not logged in
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";

$logged_in_student_id = $_SESSION['student_id'];

// Query to fetch summarized data for the logged-in student
$attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE student_id = '$logged_in_student_id'")->fetch_assoc()['total'];
$grades_count = $conn->query("SELECT COUNT(*) as total FROM grades WHERE student_id = '$logged_in_student_id'")->fetch_assoc()['total'];

// Fetch student info
$student_info = $conn->query("SELECT * FROM students WHERE id = '$logged_in_student_id'")->fetch_assoc();
$student_name = htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name']);
?>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse vh-100">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>" aria-current="page" href="dashboard.php">
          <i class="fa-solid fa-house"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'attendance.php') ? 'active' : ''; ?>" href="attendance.php">
          <i class="fa-solid fa-calendar-check"></i> Attendance
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'grades.php') ? 'active' : ''; ?>" href="grades.php">
          <i class="fa-solid fa-graduation-cap"></i> Grades
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'profile.php') ? 'active' : ''; ?>" href="profile.php">
          <i class="fa-solid fa-user-graduate"></i> Profile
        </a>
      </li>
    </ul>
  </div>
</nav>

<style>
    /* Sidebar links */
    .nav-link {
        display: block;
        color: #000;
        padding: 10px;
        text-decoration: none;
    }

    /* Active/current link */
    .nav-link.active {
        background-color: #007bff; /* Change this to your desired background color */
        color: #fff; /* Change this to your desired text color */
        font-weight: bold;
        border-left: 5px solid #007bff;
    }

    /* Links on mouse-over */
    .nav-link:hover:not(.active) {
        background-color: #555;
        color: white;
    }
</style>
