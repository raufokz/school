<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "school");

// Check connection
if (!$conn) {
 echo"failed ".mysqli_connect_error($conn);
}

?>