<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/common/panel.css">
  <link rel="stylesheet" href="../src/styles/userprofile.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <title>User Account</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

      <main>
        <h1 class="header">Your account</h1>
        <div class = "panel">
          <div class="panel__buttons">
            <a href="changeinfo" class="panel__button">Change Information</a>
            <a href="changepassword" class="panel__button">Change Password</a>
            <a href="requestuser.php" class="panel__button">Requests</a>
            <a href="visitinfo.php" class="panel__button">See Visit Info</a>
              <a href="javascript:void(0);" onclick="logoutUser();" class="panel__button">Log Out</a>

              <script>
                  function logoutUser() {
                      fetch('userprofile', {
                          method: 'POST',
                          headers: {
                              'Content-Type': 'application/x-www-form-urlencoded'
                          },
                          body: 'logout=1'
                      }).then(response => {
                          window.location.href = 'userprofile/logout';
                      }).catch(error => console.error('Error:', error));
                  }
              </script>
          </div>
          <div>
          </div>
          <div class = "panel__info">
            <img class="img" src = "../src/assets/user.png" alt="user">
            <div class = "panel__text">username: <?php echo $_SESSION["username"] ?></div>
            <div class = "panel__text">email: <?php echo $_SESSION["email"]?></div>
            <div class = "panel__text">cnp: <?php echo $_SESSION["cnp"]?></div>
            <div class = "panel__text">phone number: <?php echo $_SESSION["phone_number"]?></div>
        </div>
        </div>
        
      </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>