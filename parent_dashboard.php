<?php
session_start();

// Check if parent is logged in
if (!isset($_SESSION['parent'])) {
    header("Location: login.html"); // Redirect to login if session is not set
    exit();
}

// Include database connection
include "connect.php";

// Fetch the parent's email from the session
$email = $_SESSION['parent'];

// Fetch parent's data from the database
$sql = "SELECT * FROM `parent` WHERE `email` = '$email'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $parent = mysqli_fetch_assoc($result); // Fetch parent data
} else {
    echo "Error: Unable to fetch parent data.";
    exit(); // Exit if there's an error
}

// Fetch student's data from the database (assuming there's a student table linked to parent)
$studentSql = "SELECT * FROM `students` WHERE `parent_id` = '" . $parent['id'] . "'";
$studentResult = mysqli_query($conn, $studentSql);

if (mysqli_num_rows($studentResult) > 0) {
    $student = mysqli_fetch_assoc($studentResult); // Fetch student data
} else {
    echo "Error: Unable to fetch student's data.";
    exit(); // Exit if there's an error
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            overflow-x: hidden; /* Prevent horizontal overflow */
        }
        .navbar {
            margin-bottom: 20px;
        }
        .sidebar {
            height: 100vh; /* Full height sidebar */
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #007bff; /* Primary color */
            color: white;
            padding: 15px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h4 {
            color: #ffffff; /* White color for header */
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            display: block;
            padding: 10px 0;
            transition: background 0.3s; /* Smooth transition for hover effect */
        }
        .sidebar a:hover {
            background-color: #0056b3; /* Darker blue on hover */
            padding-left: 10px; /* Indent effect on hover */
        }
        .dashboard-content {
            margin-left: 270px; /* Space for sidebar */
            padding: 20px;
        }
        .dashboard-card {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .dashboard-header {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333; /* Darker color for header */
        }
        .student-info {
            margin-top: 20px; /* Space between sections */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Parent Dashboard</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="sidebar">
        <h4>Navigation</h4>
        <ul class="list-unstyled">
            <li><a href="#">Home</a></li>
            <li><a href="#">Student Information</a></li>
            <li><a href="#">Attendance</a></li>
            <li><a href="#">Grades</a></li>
            <li><a href="#">Contact Teachers</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

    <div class="dashboard-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-card">
                        <h1 class="dashboard-header">Welcome, <?php echo $parent['first_name'] . ' ' . $parent['sur_name']; ?>!</h1>
                        
                        <p><strong>Email:</strong> <?php echo $parent['email']; ?></p>
                        <p><strong>Phone:</strong> <?php echo $parent['phone']; ?></p>
                        <p><strong>Address:</strong> <?php echo $parent['address']; ?></p>

                        <hr>
                        <div class="student-info">
                            <h3>Your Student's Information</h3>
                            <!-- Display student's details here -->
                            <p><strong>Student Name:</strong> <?php echo $student['name'] . ' ' . $student['surname']; ?></p>
                            <p><strong>Class:</strong> <?php echo $student['class']; ?></p>
                            <p><strong>Attendance:</strong> <?php echo $student['attendance']; ?>%</p>
                            <p><strong>Grades:</strong> <?php echo $student['grades']; ?></p>

                            <!-- Add more details as per requirements -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
