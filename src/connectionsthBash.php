<?php


  $server = "localhost:3308";
  $username = "root";
  $password = "aristea";
  $dbname = "WebProject";

  if(!$con = mysqli_connect($server,$username,$password,$dbname))
  {
    die("failed to connect");
  }


?>
