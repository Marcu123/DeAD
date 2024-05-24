<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/ban.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Ban User</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">Ban</h1>
    <form action="Ban/execute" method="post" class = "form">
        <?php

        if(isset($_SESSION['error']))
        {
            $unbannedErrorClass = '--error';
        }
        else if(isset($_SESSION['good']))
        {
            $unbannedErrorClass = '--good';
        }
        else
        {
            $unbannedErrorClass = '';
        }
        ?>
        <label for="username">Username: </label>
        <input type="text" class="form__field<?php echo $unbannedErrorClass; ?>" name="username" placeholder="" id="username" autocomplete="off" required>
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
        <button type="submit" class="form__button">Ban</button>
    </form>
    <div class="sep"></div>
  </main>

    <?php include 'common/footer.php'; ?>
    <?php
    unset($_SESSION['error']);
    unset($_SESSION['good']);
    ?>
</body>

</html>