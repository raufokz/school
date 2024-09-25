<?php
session_start();

// Check if the parent is logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: login.html"); // Redirect to login page if not logged in
    exit();
}

include "../connect.php";

$logged_in_parent_id = $_SESSION['parent_id'];

// Prepare and execute the parent query
$parent_query = "SELECT * FROM parents WHERE id = ?";
$stmt = $conn->prepare($parent_query);
$stmt->bind_param("i", $logged_in_parent_id);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_assoc();

// Fetch parent name
$parent_name = htmlspecialchars($rows['first_name'] . ' ' . $rows['last_name']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
  
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-bottom: none;
            border-radius: 10px 10px 0 0;
            padding: 20px;
        }

        .card-header h4 {
            margin-top: 15px;
            font-size: 1.5rem;
        }

        .card-body {
            padding: 20px;
        }

        .card img {
            border: 3px solid #007bff;
            padding: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .profile-info {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        .fw-bolder {
            color: #007bff;
            font-size: 2rem;
        }

        .image-upload-form input[type="file"] {
            margin-bottom: 15px;
        }

        .profile-info .text-primary {
            color: #007bff;
            font-weight: bold;
        }

        .profile-info p span {
            font-weight: 500;
        }

        .text-center h1 {
            color: #007bff;
            font-weight: bold;
            font-size: 2rem;
        }


    </style>
</head>

<body>
    <?php include 'includes/navbar.php'; ?> <!-- Navbar inclusion -->

    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?> <!-- Sidebar inclusion -->

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h1 class="text-center fw-bolder">Hey <?= $parent_name ?>!</h1>

                <div class="row">
                    <!-- First Profile Card -->
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header text-center">
                                <img src="<?= htmlspecialchars($rows['profile_picture'] ?? 'default.jpg') ?>" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                                <h4 class="mt-2"><?= htmlspecialchars($rows['first_name']) ?></h4>
                            </div>
                            <div class="card-body">
                                <form action="upload_image.php" method="POST" enctype="multipart/form-data" class="image-upload-form mb-3">
                                    <label for="image" class="form-label">Upload Profile Image:</label>
                                    <input type="file" name="image" id="image" required class="form-control">
                                    <input type="hidden" name="parent_id" value="<?= htmlspecialchars($rows['id']); ?>">
                                    <button type="submit" class="btn btn-primary mt-2">Upload</button>
                                </form>
                                <p class="profile-info">ID: <span class="text-primary"><?= htmlspecialchars($rows['id']); ?></span></p>
                                <p class="profile-info">Date of Birth: <span class="text-primary"><?= htmlspecialchars($rows['date_of_birth']); ?></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Details Section -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5>Details:</h5>
                                <p class="profile-info">Full Name: <span class="text-primary"><?= htmlspecialchars($rows['first_name'] . ' ' . $rows['last_name']); ?></span></p>
                                <p class="profile-info">Gender: <span class="text-primary"><?= htmlspecialchars($rows['gender']); ?></span></p>
                                <p class="profile-info">Email: <span class="text-primary"><?= htmlspecialchars($rows['email']); ?></span></p>
                                <p class="profile-info">Phone No: <span class="text-primary"><?= htmlspecialchars($rows['phone']); ?></span></p>
                                <p class="profile-info">Address: <span class="text-primary"><?= htmlspecialchars($rows['address']); ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</body>

</html>

