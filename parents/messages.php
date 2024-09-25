<?php
session_start();
if (!isset($_SESSION['parent_id'])) {
    header("Location: ../login.html");
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";

$logged_in_parent_id = $_SESSION['parent_id'];

// Mark all unread messages as read
$conn->query("UPDATE messages SET is_read = 1 WHERE parent_id = '$logged_in_parent_id' AND is_read = 0");

// Fetch all messages for the parent
$messages = $conn->query("SELECT * FROM messages WHERE parent_id = '$logged_in_parent_id' ORDER BY sent_at DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
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
                    <h1 class="h2">Messages</h1> <!-- Page title -->
                </div>

                <?php if (count($messages) > 0): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Body</th>
                                <th>Content</th>
                                <th>Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($messages as $message): ?>
                                <tr>
                                    <td><?= htmlspecialchars($message['subject']) ?></td>
                                    <td><?= htmlspecialchars($message['body']) ?></td>
                                    <td><?= htmlspecialchars($message['content']) ?></td>
                                    <td><?= htmlspecialchars($message['sent_at']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No messages found.</p>
                <?php endif; ?>
            </main>
        </div>
    </div>

</body>
</html>
