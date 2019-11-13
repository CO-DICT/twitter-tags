<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";
$userid=$_POST["userid"];
$pswd=$_POST["password"];
$email = $_POST["email"];


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed" . $conn->connect_error); 
    
}
$sql = "insert into admin(userid,password,email) values ('$userid','$pswd','$email')";


if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Submitted Successfully')</script>";
    header("location: admin.html");
}
else {
    echo "<script type='text/javascript'>alert('Error')</script>" . $sql . "<br>" . $conn->error;
}


$conn->close();
    
?>
