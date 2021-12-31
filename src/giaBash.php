<?php
  $server = "localhost:3308";
  $username = "root";
  $password = "aristea";
  $dbname = "WebProject";

  $conn = mysqli_connect($server,$username,$password,$dbname);
  if(isset($_POST['submit']))
  {
      if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']) )
      {
          $username = $_POST['username'];
          $password = $_POST['password'];
          $email = $_POST['email'];


          $query = "INSERT INTO user(username,password,email) VALUES('$username','$password','$email' )";
          $run = mysqli_query($conn,$query) or die(mysqli_error());
          if ($run)
          {
              echo "Form submitted successfuly";
          } else
           {
              echo "Form not submitted";
           }


      }
  }else {
      echo "all fields are required";
  }




 ?>
