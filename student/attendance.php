<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

include "../connect.php";

$logged_in_student_id = $_SESSION['student_id'];

// Fetch student attendance records using a prepared statement to avoid SQL injection
$attendance_stmt = $conn->prepare("SELECT * FROM attendance WHERE student_id = ?");
$attendance_stmt->bind_param("i", $logged_in_student_id);
$attendance_stmt->execute();
$attendance_result = $attendance_stmt->get_result();
$attendance = $attendance_result->fetch_all(MYSQLI_ASSOC);

// Fetch student info
$student_info_stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$student_info_stmt->bind_param("i", $logged_in_student_id);
$student_info_stmt->execute();
$student_info = $student_info_stmt->get_result()->fetch_assoc();
$student_name = htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Add Bootstrap CSS -->
</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Attendance Records for <?= $student_name ?></h1> <!-- Display the student's name -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($attendance): ?>
                                    <?php foreach ($attendance as $record): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($record['date']) ?></td>
                                            <td><?= htmlspecialchars($record['status']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2">No attendance records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
