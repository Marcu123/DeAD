<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/changepassword.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Change Password</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

      <main>
        <h1 class="header">Change password</h1>
        <form action="changepassword/newPassword" method="post" class = "form">
            <?php

            if(isset($_SESSION['error']))
            {
                $passwordErrorClass = '--error';
            }
            else if(isset($_SESSION['good']))
            {
                $passwordErrorClass = '--good';
            }
            else
            {
                $passwordErrorClass = '';
            }
            ?>
            <label for="password">Current password: </label>
            <input type="password" class="form__field<?php echo $passwordErrorClass; ?>" name="password" id="password" placeholder="" autocomplete="off" required>
    
            <label for="new_password">New password: </label>
            <input type="password" class="form__field<?php echo $passwordErrorClass; ?>" name="new_password" id="new_password" placeholder="" autocomplete="off" required>

            <?php
            if(isset($_SESSION['error']))
            {
                echo '<p class="form__error">'.$_SESSION['error'].'</p>';
            }
            if(isset($_SESSION['good']))
            {
                echo '<p class="form__good">'.$_SESSION['good'].'</p>';
            }
            ?>
            <button type="submit" class="form__button">Submit</button>
        </form>
        <div class="sep"></div>
      </main>

    <?php include 'common/footer.php';
    unset($_SESSION['error']);
    unset($_SESSION['good']);
    ?>
</body>

</html>