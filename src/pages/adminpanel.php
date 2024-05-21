<?php
//session_start();
//?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/common/panel.css">
  <link rel="stylesheet" href="../src/styles/adminpanel.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Admin Account</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">Welcome to Admin's Control Panel</h1>
    <div class="panel">
        <div class="panel__buttons">
            <a href ="Addinmate" class="panel__button">Add Inmate</a>
            <a href ="Deleteinmate" class="panel__button">Delete Inmate</a>
            <a href ="Updateinmate" class="panel__button">Update Inmate</a>
            <a href ="Addvisitinfo" class="panel__button">Add Visit Info</a>
            <a href ="Deletevisitinfo" class="panel__button">Delete Visit Info</a>
            <a href ="Updatevisitinfo" class="panel__button">Update Visit Info</a>
            <a href ="visitinfo" class="panel__button">See Visit Info</a>
            <a href ="requestadmin" class="panel__button">See Requests</a>
            <a href ="statistics" class="panel__button">Statistics</a>
            <a href ="ban" class="panel__button">Ban User</a>
            <a href="javascript:void(0);" onclick="logoutUser();" class="panel__button">Log Out</a>

            <script>
                function logoutUser() {
                    fetch('adminpanel', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: 'logout=1'
                    }).then(response => {
                        window.location.href = 'adminpanel/logout';
                    }).catch(error => console.error('Error:', error));
                }
            </script>
        </div>
        <div>
        </div>
        <div class="panel__info">
          <div class="panel__text">Prison: <?php echo $_SESSION['prison_name']?></div>
          <div class="panel__text">Number of inmates: <?php echo $_SESSION['inmates_nr']?></div>
          <div class="panel__text">Number of employees: <?php echo $_SESSION['empl_nr']?></div>
          <div class="panel__text">New visit requests: <?php echo $_SESSION['requests_nr']?></div>
          
        </div>
    </div>
    <div class="sep">
    </div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>