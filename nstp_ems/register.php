<?php 

include 'connect.php';

if(isset($_POST['signUp'])){
    $firstName=$_POST['fName'];
    $lastName=$_POST['lName'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password);

     $checkEmail="SELECT * From users where email='$email'";
     $result=$conn->query($checkEmail);
     if($result->num_rows>0){
        echo "Email Address Already Exists !";
     }
     else{
      $insertQuery = "INSERT INTO users (firstName, lastName, email, password, role)
                VALUES ('$firstName', '$lastName', '$email', '$password', 'student')";

            if($conn->query($insertQuery)==TRUE){
                header("location: indexlogin.php");
            }
            else{
                echo "Error:".$conn->error;
            }
     }
   

}

if(isset($_POST['signIn'])){
   $email = $_POST['email'];
   $password = md5($_POST['password']);

   $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
   $result = $conn->query($sql);

   if($result->num_rows > 0){
       session_start();
       $row = $result->fetch_assoc();
      $_SESSION['userId'] = $row['userId'];  // Add this line
$_SESSION['email'] = $row['email'];
$_SESSION['role'] = $row['role'];


       if ($row['role'] === 'admin') {
           header("Location: index.php"); // admin dashboard
       } else {
           header("Location: studentEnrollment.php"); // student enrollment page
       }
       exit();
   } else {
       echo "Not Found, Incorrect Email or Password";
   }
}