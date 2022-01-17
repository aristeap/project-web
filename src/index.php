<!DOCTYPE html>
<html>
<head>
     <title>WebProject</title>

     <style>
        .userInputs
        {
           font-size: 150%;
           background-color:  #c0904d;
        }

    </style>

</head>
<body>


  <!--This code "onkeydown="return event.keyCode != 13;""is to disable the enter key from the form.For example if I fill all the fields and
     I press enter nothing will happen.I will only have the options of login and SignUp! -->

    <form  method="POST"  action="loginsthBash.php">
      <!-- USERNAME -->
      <p class="userInputs">Give a username:</p>
      <input type="text" id="usernameId" name="username" placeholder="Type a username" onkeydown="return event.keyCode != 13;">

      <br><br>

      <!-- EMAIL -->
      <p class="userInputs" >Give your email</p>
      <input type="email" id="emailId" name="email" placeholder="Type your email address" onkeydown="return event.keyCode != 13;">
      <br><br>


      <!-- PASSWORD -->
      <p class="userInputs">Give a password.It should contain at least :
          8 characters,one upper case letter,one number and a symbol(#,$,*,@)
      </p>
      <input type="password" id="passwordId" name="password" placeholder="Type a password" onkeydown="return event.keyCode != 13;">

      <p id="StrengthMessage">Weak</p>

      <!-- The button or the link to login or signup will only show up if the password is strong -->
      <button type="submit" id="passwordButton" formaction="loginsthBash.php" style = "display:none;">Login</button><br>
      <button type="submit" formaction="signupsthBash.php" id="signupId" style = "display:none;">SignUp</button>



  <br>





    </form>


    <script>
      let timeout;
      //To display the Login button
      let forTheLoginButton = document.getElementById('passwordButton');
      //To display the sign up button
      let forTheSignUpLink = document.getElementById('signupId');
      //To display the weak or strong message for the password
      let strengthBadge = document.getElementById('StrengthMessage');
      //It takes the password we wrote
      let password = document.getElementById('passwordId');
      //The regular expression to test the password's strength
      let strongPassword = new RegExp ('(?=.*[A-z])(?=.*[0-9])(?=.*[^A-za-z0-9])(?=.{8,})');

      function passwordFunction(passwordParameter)
      {
            if(strongPassword.test(passwordParameter))
            {
                strengthBadge.style.backgroundColor = "green"
                strengthBadge.textContent = 'Strong';
                if(strengthBadge.textContent == 'Strong')
                    {
                          forTheLoginButton.style.display = "block";
                          forTheSignUpLink.style.display = "block";

                    }else
                    {
                           forTheButton.style.display = "none";
                    }

            }else
            {
                strengthBadge.style.backgroundColor = "red"
                strengthBadge.textContent = 'Weak';
             }
      }



      /* We won’t call the function immediately after every keystroke. When the user types quickly, we should wait until a pause occurs. So, instead of checking the strength immediately, we’ll set a timeout. */

     password.addEventListener("input", () => {

          //The badge is hidden by default, so we show it

          strengthBadge.style.display = 'block';
          clearTimeout(timeout) ;    //clearing the previous timeout if there is any

          //We then call the passwordFunction function as a callback then pass the typed password to it
          timeout = setTimeout(() => passwordFunction(password.value), 500);
          if (password.value.length !== 0)
          {
                  strengthBadge.style.display = 'block';

           }else
          {
                  strengthBadge.style.display = 'none';

          }

        } );






    </script>

</body>
</html>
