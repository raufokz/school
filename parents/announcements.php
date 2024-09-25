<?php
session_start();
if (!isset($_SESSION['parent_id'])) { // Assuming a user_id is set for other users
    header("Location: ../login.html");
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";
$logged_in_parent_id = $_SESSION['parent_id'];
// Mark all unread announcements as read
$conn->query("UPDATE announcements SET is_read = 1 WHERE is_read = 0");
// Fetch all announcements
$announcements = $conn->query("SELECT * FROM announcements ORDER BY date DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Announcements</h1>
                </div>

                <?php if (count($announcements) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($announcements as $announcement): ?>
                                <tr>
                                    <td><?= htmlspecialchars($announcement['title']) ?></td>
                                    <td><?= htmlspecialchars($announcement['message']) ?></td>
                                    <td><?= htmlspecialchars($announcement['date']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No announcements found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
