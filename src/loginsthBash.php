<?php
    SESSION_START();

        include("connectionsthBash.php");
        include("functions.php");


        if($_SERVER['REQUEST_METHOD']=='POST')
        {
          $username = $_POST['username'];
          $password = $_POST['password'];
          $email = $_POST['email'];


          if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email']))
            {
                    //read from database
                    $query = "select* from user where username= '$username' limit 1 ";

                    $result = mysqli_query($con,$query);

                    if($result)
                    {
                            if($result && mysqli_num_rows($result)>0)
                            {
                                    $user_data=mysqli_fetch_assoc($result);
                                    if($user_data['password'] === $password && $user_data['email'] === $email)
                                    {
                                          $_SESSION['user_id'] = $user_data['user_id'];
                                        //  header("Location: redirectedpageFromLogin.php");
                                          header("Location:redirectedPage.php");
                                        die;
                                    }else
                                    {

                                        echo "<script> alert('wrong password or email!');
                                                window.location.href='index.php';
                                              </script>";

                                    }

                              }else
                              {
                                echo "<script> alert('something's wrong with your inputs.Try again! ');
                                        window.location.href='index.php';
                                      </script>";
                              }


                    }
                    else
                    {
                        echo "<script> alert('check your inputs again');
                              window.location.href='index.php';
                            </script>";
                    }


            }
            else
            {
              echo  "<script> alert('All fields are required');
                    window.location.href='index.php';
                  </script>";
            }


        }

?>
