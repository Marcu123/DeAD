<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/deleteinmate.css" >

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Delete Inmate</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">Delete Inmate</h1>
    <form action="Deleteinmate/delete" method="post" class = "form">
        <?php
        if (isset($_SESSION['error'])) {
            $usernameErrorClass = '--error';
        } else if (isset($_SESSION['good'])) {
            $usernameErrorClass = '--good';
        } else {
            $usernameErrorClass = '';
        }

        ?>
        <label for="cnp">CNP: </label>
        <input type="text" class="form__field<?php echo $usernameErrorClass; ?>" name="cnp" id="cnp" placeholder="" autocomplete="off" required>
        <?php if(isset($_SESSION['error']))
        {
            echo '<p class="form__error">'.$_SESSION['error'].'</p>';
        }
        if(isset($_SESSION['good']))
        {
            echo '<p class="form__good">'.$_SESSION['good'].'</p>';
        }
        ?>
        <button type="submit" class="form__button">Delete</button>
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