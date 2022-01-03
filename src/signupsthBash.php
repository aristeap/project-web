<?php
  SESSION_START();
  include("connectionsthBash.php");
  include("functions.php");


  if($_SERVER['REQUEST_METHOD']=='POST')
  {
      //something was posted
      $username = $_POST['username'];
      $password = $_POST['password'];
      $email = $_POST['email'];


      if(!empty($username) && !empty($password) && !empty($email) )
      {

          //save to database
          $user_id = random_num(20);
          $query = "insert into user(username,password,email,user_id) values('$username','$password','$email','$user_id' )";
          mysqli_query($con,$query);

          header("Location:redirectedPage.php");
          die;
        }else
        {
          echo  "<script> alert('All fields are required');
                window.location.href='index.php';
              </script>";
        }


    }


 ?>
