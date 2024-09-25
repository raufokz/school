<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the parent is logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: ../login.html"); // Redirect to login page if not logged in
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php"; // Database connection
$logged_in_parent_id = $_SESSION['parent_id'];

$parent_id = $_SESSION['parent_id'];
$parent_email = $_SESSION['parent_email'];
$parent_name = $_SESSION['parent_name'];

// Query to fetch students for the logged-in parent
$students = $conn->query("SELECT id, first_name, last_name FROM students WHERE parent_id = '$parent_id'")->fetch_all(MYSQLI_ASSOC);

// Query to fetch grades for the logged-in parent's students
$grades = [];
foreach ($students as $student) {
    $student_grades = $conn->query("SELECT subject, grade FROM grades WHERE student_id = '{$student['id']}'")->fetch_all(MYSQLI_ASSOC);
    $grades[$student['id']] = [
        'name' => $student['first_name'] . ' ' . $student['last_name'],
        'grades' => $student_grades
    ];
}

// Fetch announcements
$announcements = $conn->query("SELECT * FROM announcements ORDER BY date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

// Fetch messages for the parent
$messages = $conn->query("SELECT * FROM messages WHERE parent_id = '$parent_id' ORDER BY sent_at DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                </div>

                <?php if ($grades): ?>
                    <?php foreach ($grades as $student_id => $student_info): ?>
                        <h3><?= htmlspecialchars($student_info['name']) ?>'s Grades</h3>
                        <table class="table table-striped mb-4">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($student_info['grades']): ?>
                                    <?php foreach ($student_info['grades'] as $grade): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($grade['subject']) ?></td>
                                            <td><?= htmlspecialchars($grade['grade']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">No grades available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No students found for your account.</p>
                <?php endif; ?>
                
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
