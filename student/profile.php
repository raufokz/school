<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

include "../connect.php";

$logged_in_student_id = $_SESSION['student_id'];

// Prepare and execute the student query
$student_query = "SELECT * FROM students WHERE id = ?";
$stmt = $conn->prepare($student_query);
$stmt->bind_param("i", $logged_in_student_id);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();

// Fetch student name
$student_name = htmlspecialchars($rows['first_name'] . ' ' . $rows['last_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="text-center fw-bolder">Hey <?= $student_name ?>!</h1>

                <div class="row">
                    <!-- First Profile Card -->


                    <!-- Second Profile Card (Copy the above block and modify if necessary) -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header text-center">
                                <img src="<?= htmlspecialchars($rows['image'] ?? 'default.jpg') ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                <h4 class="mt-2"><?= htmlspecialchars($rows['first_name']) ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="upload_image.php" method="POST" enctype="multipart/form-data" class="image-upload-form mb-3">
                                    <label for="image">Upload Profile Image:</label>
                                    <input type="file" name="image" id="image" required class="form-control">
                                    <input type="hidden" name="student_id" value="<?= htmlspecialchars($rows['id']); ?>">
                                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                </form>
                                <p class="profile-info">ID: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['id']); ?></span></p>
                                <p class="profile-info">Class: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['class']); ?></span></p>
                                <p class="profile-info">Date of Birth: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['dob']); ?></span></p>
                            </div>
                        </div>
                    </div>

                <!-- Details Section for the First Student -->
                 <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5>Details:</h5>
                        <p class="profile-info">Full Name: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['first_name'] . ' ' . $rows['last_name']); ?></span></p>
                        <p class="profile-info">Father Name: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['father_name']); ?></span></p>
                        <p class="profile-info">Mother Name: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['mother_name']); ?></span></p>
                        <p class="profile-info">Gender: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['gender']); ?></span></p>
                        <p class="profile-info">Email: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['email']); ?></span></p>
                        <p class="profile-info">Phone No: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['phone']); ?></span></p>
                        <p class="profile-info">Total Fees: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['total_fees']); ?></span></p>
                        <p class="profile-info">Remaining Fees: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['outstanding_fees']); ?></span></p>
                        <p class="profile-info">Address: <span class="fw-bold text-primary"><?= htmlspecialchars($rows['address']); ?></span></p>
                    </div>
                </div>
            </main>
        </div>
    </div>
    </div>

    </div>

</body>
</html>
