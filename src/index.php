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


    <form action="giaBash.php"  method="POST">
      <!-- USERNAME -->
      <p class="userInputs">Give a username:</p>
      <input type="text" id="usernameId" name="username" placeholder="Type a username">

      <br><br>


      <!-- EMAIL -->
      <p class="userInputs" >Give your email</p>
      <input type="email" id="emailId" name="email" placeholder="Type your email address">
      <br><br>



      <!-- PASSWORD -->
      <p class="userInputs">Give a password.It should contain at least :
          8 characters,one upper case letter,one number and a symbol(#,$,*,@)
      </p>
      <input type="password" id="passwordId" name="password" placeholder="Type a password">

      <p id="StrengthMessage">Weak</p>

      <!-- The button to submit the password will only show up if the password is strong -->
      <button type="submit" id="passwordButton" name="submit" style = "display:none;">Sumbit</button>
      <br>


    </form>


    <script>
      let timeout;
      let forTheButton = document.getElementById('passwordButton');
      let strengthBadge = document.getElementById('StrengthMessage');
      let password = document.getElementById('passwordId');
      let strongPassword = new RegExp ('(?=.*[A-z])(?=.*[0-9])(?=.*[^A-za-z0-9])(?=.{8,})');

      function passwordFunction(passwordParameter)
      {
            if(strongPassword.test(passwordParameter))
            {
                strengthBadge.style.backgroundColor = "green"
                strengthBadge.textContent = 'Strong';
                if(strengthBadge.textContent == 'Strong')
                    {
                          forTheButton.style.display = "block";
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