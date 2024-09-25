<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

include "../connect.php";

$logged_in_student_id = $_SESSION['student_id'];

// Fetch student grades
$grades_query = $conn->query("SELECT * FROM grades WHERE student_id = '$logged_in_student_id'");
$grades = $grades_query->fetch_all(MYSQLI_ASSOC);

// Fetch student info
$student_info = $conn->query("SELECT * FROM students WHERE id = '$logged_in_student_id'")->fetch_assoc();
$student_name = $student_info['first_name'] . ' ' . $student_info['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Grades for <?= htmlspecialchars($student_name) ?></h1> <!-- Display the student's name -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Term</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($grades as $grade): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($grade['subject']) ?></td>
                                        <td><?= htmlspecialchars($grade['grade']) ?></td>
                                        <td><?= htmlspecialchars($grade['term']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>
</html>
