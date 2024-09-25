<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the parent is logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: ../login.html"); // Redirect to login page if not logged in
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";

$logged_in_parent_id = $_SESSION['parent_id'];

// Query to fetch summarized data for the logged-in parent
$attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE parent_id = '$logged_in_parent_id'")->fetch_assoc()['total'];
$grades_count = $conn->query("SELECT COUNT(*) as total FROM grades WHERE parent_id = '$logged_in_parent_id'")->fetch_assoc()['total'];

// Fetch parent info
$parent_info = $conn->query("SELECT * FROM parents WHERE id = '$logged_in_parent_id'")->fetch_assoc();
$parent_name = htmlspecialchars($parent_info['first_name'] . ' ' . $parent_info['last_name']);
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
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'children.php') ? 'active' : ''; ?>" href="children.php">
          <i class="fa-solid fa-child"></i> Childern
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'fees_record.php') ? 'active' : ''; ?>" href="fees_record.php">
          <i class="fa-solid fa-file-invoice-dollar"></i> Fees Record
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'messages.php') ? 'active' : ''; ?>" href="messages.php">
          <i class="fa-solid fa-envelope"></i> Messages
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'announcements.php') ? 'active' : ''; ?>" href="announcements.php">
          <i class="fa-solid fa-bullhorn"></i> Announcements
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

