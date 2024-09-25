<?php
session_start();
if (!isset($_SESSION['parent_id'])) {
    header("Location: ../login.html");
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";
$logged_in_parent_id = $_SESSION['parent_id'];

$parent_id = $_SESSION['parent_id'];
$students = $conn->query("SELECT * FROM students WHERE parent_id = '$parent_id'")->fetch_all(MYSQLI_ASSOC);

// Fetch attendance records for each student
$attendance_records = [];
foreach ($students as $student) {
    $student_id = $student['id'];
    $attendance_records[$student_id] = $conn->query("SELECT * FROM attendance WHERE student_id = '$student_id'")->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Records</title>
    <style>
        .card-header {
            background-color: #007bff; /* Change to your desired color */
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            <div class="col-md-9">
                <h1 class="my-4">Attendance Records</h1>
                <div class="row">
                    <?php foreach ($students as $student): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h5> <!-- Display student name -->
                                </div>
                                <div class="card-body">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($attendance_records[$student['id']] as $record): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($record['date']) ?></td>
                                                    <td><?= htmlspecialchars($record['status']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
