<?php
include "/xampp/htdocs/School-management-website/connect.php"; // Database connection

// Get parent ID (Assume the parent is logged in and their ID is stored in a session variable)
session_start();
$parent_id = $_SESSION['parent_id'];
$logged_in_parent_id = $_SESSION['parent_id'];

// Fetch students based on parent ID
$sql = "SELECT first_name, last_name, class, fees_paid, total_fees, outstanding_fees FROM students WHERE parent_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();

// Include header and navbar
include 'includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Children's Fee Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Fee Record for Your Children</h1> <!-- Display the title -->
                </div>

                <div class="row">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                            <div class='col-md-4 mb-4'>
                                <div class='card'>
                                    <div class='card-body'>
                                        <h5 class='card-title'>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</h5>
                                        <p class='card-text'>
                                            <strong>Class:</strong> " . htmlspecialchars($row['class']) . "<br>
                                            <strong>Fees Paid:</strong> " . htmlspecialchars($row['fees_paid']) . "<br>
                                            <strong>Total Fees:</strong> " . htmlspecialchars($row['total_fees']) . "<br>
                                            <strong>Outstanding Fees:</strong> " . htmlspecialchars($row['outstanding_fees']) . "
                                        </p>
                                    </div>
                                </div>
                            </div>";
                        }
                    } else {
                        echo "<p>No fee records found for your children.</p>";
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>

</body>
</html>

<?php
// Close connection
$conn->close();
?>
