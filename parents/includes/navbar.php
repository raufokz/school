<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the parent is logged in
if (!isset($_SESSION['parent_id'])) {
    header("Location: ../login.html"); // Redirect to login page if not logged in
    exit();
}

include "/xampp/htdocs/School-management-website/connect.php";
$unread_messages_count = $conn->query("SELECT COUNT(*) as total FROM messages WHERE parent_id = '$logged_in_parent_id' AND is_read = 0")->fetch_assoc()['total'];

$logged_in_parent_id = $_SESSION['parent_id'];

// Query to fetch summarized data for the logged-in parent
$attendance_count = $conn->query("SELECT COUNT(*) as total FROM attendance WHERE parent_id = '$logged_in_parent_id'")->fetch_assoc()['total'];
$grades_count = $conn->query("SELECT COUNT(*) as total FROM grades WHERE parent_id = '$logged_in_parent_id'")->fetch_assoc()['total'];

// Fetch parent info
$parent_info = $conn->query("SELECT * FROM parents WHERE id = '$logged_in_parent_id'")->fetch_assoc();
$parent_name = htmlspecialchars($parent_info['first_name'] . ' ' . $parent_info['last_name']);
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Capital Education System | A Perfect Place To Learn.</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Welcome to Capital Education System - your gateway to quality education. Explore courses in SSC, HSC, expert tutoring, and comprehensive study materials. Join us for an enriching learning experience." />
        <meta name="keywords" content="Capital Education System, education, courses, tutoring, study materials, learning platform" />

        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="./css/style.css">
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid px-4 py-0">
                <img src="/School-management-website/img/logo1.jpg" height="48rem" width="50rem" >
                <a class="navbar-brand fw-bolder" href="#">Capital Education System</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 px-2 ms-auto mb-lg-0">
                    <li class="nav-item px-2">
                    <a class="nav-link fw-bolder" href="messages.php">
                        <i class="fa-solid fa-envelope"></i>
                        <?php if ($unread_messages_count > 0): ?>
                            <span class="badge bg-danger"><?= $unread_messages_count ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                        <li class="nav-item px-2">
                            <a class="nav-link fw-bolder" aria-current="page" href="dashboard.php">Home</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link fw-bolder" href="attendance.php">Attendance</a>
                        </li>
                        <li class="nav-item px-2">
                            <a class="nav-link fw-bolder" href="grades.php">Grades</a>
                        </li>
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link dropdown-toggle fw-bolder" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i>
                                <?php echo $parent_name; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="profile.php">My Profile</a></li>
                                <li><a class="dropdown-item" href="setting.php">Settings</a></li>
                                <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                            </ul>
                        </li>
                        </li>

                    </ul>
                </div>
            </div>
        </nav> 

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

        <!-- Tooltips -->
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        </script>

        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init({
                offset: 100,
                delay: 400,
            });
        </script>
    </body>
</html>
