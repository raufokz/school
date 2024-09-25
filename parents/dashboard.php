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

// Parent's session information
$parent_id = $_SESSION['parent_id'];
$parent_email = $_SESSION['parent_email'];
$parent_name = $_SESSION['parent_name'];

include "/xampp/htdocs/School-management-website/connect.php"; // Database connection

// Query to fetch summarized data for the logged-in parent
$attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE student_id IN (SELECT id FROM students WHERE parent_id = '$parent_id')")->fetch_assoc()['total'];
$grades_count = $conn->query("SELECT COUNT(*) as total FROM grades WHERE student_id IN (SELECT id FROM students WHERE parent_id = '$parent_id')")->fetch_assoc()['total'];
$children_count = $conn->query("SELECT COUNT(*) as total FROM students WHERE parent_id = '$parent_id'")->fetch_assoc()['total'];

// Fetch announcements
$announcements = $conn->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

// Fetch messages for the parent
// Fetch messages for the parent
$messages = $conn->query("SELECT * FROM messages WHERE parent_id = '$parent_id' ORDER BY sent_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard for <?= htmlspecialchars($parent_name) ?></h1> <!-- Display the parent's name -->
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Attendance</h5>
                                <p class="card-text"><?= $attendance_count ?> entries</p>
                                <a href="attendance.php" class="btn btn-primary">View Attendance</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Grades</h5>
                                <p class="card-text"><?= $grades_count ?> grades recorded</p>
                                <a href="grades.php" class="btn btn-primary">View Grades</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">My Children</h5>
                                <p class="card-text"><?= $children_count ?> child(ren) linked</p>
                                <a href="children.php" class="btn btn-primary">View Children</a>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Latest Announcements</h2>
                <ul class="list-group mb-4">
                    <?php foreach ($announcements as $announcement): ?>
                        <li class="list-group-item">
                            <strong><?= htmlspecialchars($announcement['title']) ?></strong> <br>
                            <?= htmlspecialchars($announcement['message']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>


            </main>
        </div>
    </div>

</body>
</html>
