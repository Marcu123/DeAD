<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/userlog.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">
  <title>User Account</title>
</head>

<body>
  <?php include 'common/navbar.php'; ?>

  <main class = "form-container">
    <div>
        <h1 class = "header">Login</h1>
    <form action="userlog/login" method="post" class = "form">
        <?php

        $usernameErrorClass = isset($_SESSION['error']) ? '--error' : '';
        $passwordErrorClass = isset($_SESSION['error']) ? '--error' : '';

        ?>
        <label for="username1">Username: </label>
        <input type="text" class="form__field<?php echo $usernameErrorClass; ?>" name="username" id="username1" placeholder="" autocomplete="off" required>

        <label for="password1">Password: </label>
        <input type="password" class="form__field<?php echo $passwordErrorClass; ?>" name="password" id="password1" placeholder="" autocomplete="off" required>

        <?php if(isset($_SESSION['error']))
        {
            echo '<p class="form__error">'.$_SESSION['error'].'</p>';
        }
        ?>
        <label for="keeplogged">
          <input type="radio" class="form__radio" name="keeplogged" id="keeplogged" value="true">Remember me
        </label>


        <button type="submit" class="form__button" name="log_btn">Submit</button>

        <a href="forgotpassword" class="link">Forgot password?</a>
    </form>
</div>

      <div>
          <h1 class="header">Register</h1>
          <form action="userlog/register" method="post" class="form" enctype="multipart/form-data">
              <?php
                if (isset($_SESSION['error'])) {
                    $usernameErrorClass = '--error';
                } else if (isset($_SESSION['good'])) {
                    $usernameErrorClass = '--good';
                } else {
                    $usernameErrorClass = '';
                }

              ?>
              <label for="username">Username: </label>
              <input type="text" class="form__field" name="username" id="username" placeholder="" autocomplete="off" required>

              <label for="password">Password: </label>
              <input type="password" class="form__field" name="password" id="password" placeholder="" autocomplete="off" required>
              <div id="password-hint" class="password-hint">
                  <p id="password-complexity"></p>
                  <p>Minimum requirements:</p>
                  <ul>
                      <li id="min-length">At least 8 characters</li>
                      <li id="uppercase">At least one uppercase letter</li>
                      <li id="lowercase">At least one lowercase letter</li>
                      <li id="number">At least one number</li>
                      <li id="special">At least one special character</li>
                  </ul>
              </div>

              <label for="email">E-mail address: </label>
              <input type="email" class="form__field" name="email" id="email" placeholder="" autocomplete="off" required>

              <label for="cnp">CNP: </label>
              <input type="text" class="form__field" name="cnp" id="cnp" placeholder="" autocomplete="off" required>

              <label for="imageUpload">Photo: </label>
              <input type="file" id="imageUpload" class="form__field form__field--file" name="fileToUpload" accept="image/*" multiple>

              <label for="phone-number">Phone Number: </label>
              <input type="tel" class="form__field" name="phone-number" id="phone-number" placeholder="" autocomplete="off" required>

              <?php if(isset($_SESSION['error']))
              {
                  echo '<p class="form__error">'.$_SESSION['error'].'</p>';
              }
                if(isset($_SESSION['good']))
                {
                    echo '<p class="form__good">'.$_SESSION['good'].'</p>';
                }
              ?>
              <button type="submit" class="form__button" name="reg_btn" id="reg_btn" disabled>Submit</button>
          </form>
      </div>

  </main>

    <?php include 'common/footer.php'; ?>
  <?php
    unset($_SESSION['error']);
    unset($_SESSION['good']);
  ?>

  <script>
      document.getElementById('password').addEventListener('input', function() {
          const password = this.value;
          const complexityEl = document.getElementById('password-complexity');
          const minLengthEl = document.getElementById('min-length');
          const uppercaseEl = document.getElementById('uppercase');
          const lowercaseEl = document.getElementById('lowercase');
          const numberEl = document.getElementById('number');
          const specialEl = document.getElementById('special');
          const submitBtn = document.getElementById('reg_btn');

          const minLength = password.length >= 8;
          const hasUppercase = /[A-Z]/.test(password);
          const hasLowercase = /[a-z]/.test(password);
          const hasNumber = /[0-9]/.test(password);
          const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

          minLengthEl.className = minLength ? 'valid' : 'invalid';
          uppercaseEl.className = hasUppercase ? 'valid' : 'invalid';
          lowercaseEl.className = hasLowercase ? 'valid' : 'invalid';
          numberEl.className = hasNumber ? 'valid' : 'invalid';
          specialEl.className = hasSpecial ? 'valid' : 'invalid';

          const complexity = [minLength, hasUppercase, hasLowercase, hasNumber, hasSpecial].filter(Boolean).length;
          const complexityText = ['Very Weak', 'Weak', 'Moderate', 'Strong', 'Very Strong'];
          const complexityIndex = complexity - 1 >= 0 ? complexity - 1 : 0;
          complexityEl.textContent = `Password Complexity: ${complexityText[complexityIndex]}`;

          if (minLength && hasUppercase && hasLowercase && hasNumber && hasSpecial) {
              submitBtn.disabled = false;
          } else {
              submitBtn.disabled = true;
          }
      });
  </script>



</body>

</html>