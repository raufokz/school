<?php 

include("../connect.php");
session_start();
     
$admin=$_SESSION['admin'];

if ($admin==true) {

}
else{
  header("location:admin_login.html");
}

$name = $_POST["name"];
$lname=$_POST["lastname"];
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$email=$_POST["email"];
$address = $_POST["address"];
$contact = $_POST["phone"];
$pass =$_POST["password"];

$sql = "INSERT INTO `staff`(`id`, `first_name`, `sur_name`, `gender`, `phone`, `email`, `password`, `birthdate`,`address`) VALUES (NULL,'$name','$lname','$gender','$contact','$email','$pass','$dob','$address')";

    if (mysqli_query($conn, $sql)) {
        header("location:staffmanagement.php");

        } 
        else {
        echo mysqli_error($conn);
    }

    mysqli_close($conn);


?>
