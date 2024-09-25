<?php
// Database connection
include "../connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the student ID from the form
    $student_id = $_POST['student_id'];

    // Check if the file was uploaded without errors
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];

        // Set the upload directory
        $upload_dir = 'uploads/'; // Change this to your desired upload directory

        // Create the directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Create the directory with permissions
        }

        $upload_file = $upload_dir . basename($file_name);

        // Validate file type (optional)
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file_type, $allowed_types)) {
            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file_tmp, $upload_file)) {
                // Prepare the SQL statement to update the student image
                $update_query = "UPDATE students SET image = ? WHERE id = ?";
                $stmt = $conn->prepare($update_query);
                $stmt->bind_param("si", $upload_file, $student_id);

                if ($stmt->execute()) {
                    echo "Image uploaded successfully.";
                    header("Location: profile.php"); // Redirect back to the profile page
                    exit;
                } else {
                    echo "Error updating image in database.";
                }
            } else {
                echo "Error moving the uploaded file.";
            }
        } else {
            echo "Invalid file type. Please upload a JPEG, PNG, or GIF image.";
        }
    } else {
        echo "Error uploading the file.";
    }
}

// Close the statement and connection if they were defined
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>
