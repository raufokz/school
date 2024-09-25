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

// Query to fetch children for the logged-in parent
$children = $conn->query("SELECT * FROM students WHERE parent_id = '$parent_id'")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Children</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">My Children</h1> <!-- Page title -->
                </div>

                <?php if (count($children) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Date of Birth</th>
                                <th>Class</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($children as $child): ?>
                                <tr>
                                    <td><?= htmlspecialchars($child['id']) ?></td>
                                    <td><?= htmlspecialchars($child['first_name']) ?></td>
                                    <td><?= htmlspecialchars($child['dob']) ?></td>
                                    <td><?= htmlspecialchars($child['class']) ?></td>
                                    <td>
                                        <a href="view_student.php?id=<?= $child['id'] ?>" class="btn btn-info btn-sm">View Details</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No children found for the logged-in parent.</p>
                <?php endif; ?>

            </main>
        </div>
    </div>

</body>
</html>
