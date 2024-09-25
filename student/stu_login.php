<?php 
session_start();

include "../connect.php";

$Email = $_POST["uname"];
$pass = $_POST["pass"];

// Prepare the SQL statement
$sql = "SELECT * FROM `students` WHERE `Email` = ?";

// Create a prepared statement
$stmt = mysqli_prepare($conn, $sql);

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "s", $Email);

// Execute the statement
mysqli_stmt_execute($stmt);

// Get the result
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result); // Fetch the student's data

    // Verify the password
    if (password_verify($pass, $student['password'])) {
        // Store the student's ID and email in the session
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_email'] = $student['email'];
        $_SESSION['student_name'] = $student['first_name'] . ' ' . $student['last_name'];
        $_SESSION['image'] = $student['image'];
        header("location:dashboard.php");
        exit(); // Ensure no further code is executed
    } else {
        // Incorrect password
        echo displayErrorPage("Invalid password");
    }
} else {
    // No user found with that email
    echo displayErrorPage("User not found");
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);


// Function to display the error page
function displayErrorPage($message) {
    return '
    <div id="error-page">
        <div class="content">
            <h2 class="header" data-text=" OOPS! ">OOPS!</h2>
            <h4 data-text="' . $message . '">' . $message . '</h4>
            <div class="btns">
                <a href="login.html">Try Again</a>
            </div>
        </div>
    </div>';
}
?>
  </body>
  <style>
   @import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700&display=swap');
*{
 margin: 0;
 padding: 0;
 outline: none;
 box-sizing: border-box;
 font-family: 'Poppins', sans-serif;
}
body{
 height: 100vh;
 background: -webkit-repeating-linear-gradient(-45deg, #71b7e6, #69a6ce, #b98acc, #ee8176, #b98acc, #69a6ce, #9b59b6);
 background-size: 400%;
}
#error-page{
 position: absolute;
 top: 10%;
 left: 15%;
 right: 15%;
 bottom: 10%;
 display: flex;
 align-items: center;
 justify-content: center;
 background: #fff;
 box-shadow: 0px 5px 10px rgba(0,0,0,0.1);
}
#error-page .content{
 max-width: 600px;
 text-align: center;
}
.content h2.header{
 font-size: 18vw;
 line-height: 1em;
 position: relative;
}
.content h2.header:after{
 position: absolute;
 content: attr(data-text);
 top: 0;
 left: 0;
 right: 0;
 background: -webkit-repeating-linear-gradient(-45deg, #71b7e6, #69a6ce, #b98acc, #ee8176, #b98acc, #69a6ce, #9b59b6);
 background-size: 400%;
 -webkit-background-clip: text;
 -webkit-text-fill-color: transparent;
 text-shadow: 1px 1px 2px rgba(255,255,255,0.25);
 animation: animate 10s ease-in-out infinite;
}
@keyframes animate {
 0%{
   background-position: 0 0;
 }
 25%{
   background-position: 100% 0;
 }
 50%{
   background-position: 100% 100%;
 }
 75%{
   background-position: 0% 100%;
 }
 100%{
   background-position: 0% 0%;
 }
}
.content h4{
 font-size: 1.5em;
 margin-bottom: 20px;
 text-transform: uppercase;
 color: #000;
 font-size: 2em;
 max-width: 600px;
 position: relative;
}
.content h4:after{
 position: absolute;
 content: attr(data-text);
 top: 0;
 left: 0;
 right: 0;
 text-shadow: 1px 1px 2px rgba(255,255,255,0.4);
 -webkit-background-clip: text;
 -webkit-text-fill-color: transparent;
}
.content p{
 font-size: 1.2em;
 color: #0d0d0d;
}
.content .btns{
 margin: 25px 0;
 display: inline-flex;
}
.content .btns a{
 display: inline-block;
 margin: 0 10px;
 text-decoration: none;
 border: 2px solid #69a6ce;
 color: #69a6ce;
 font-weight: 500;
 padding: 10px 25px;
 border-radius: 25px;
 text-transform: uppercase;
 transition: all 0.3s ease;
}
.content .btns a:hover{
 background: #69a6ce;
 color: #fff;
}  
  </style>
</html>