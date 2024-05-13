<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
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
            <a href ="addinmate.php" class="panel__button">Add Inmate</a>
            <a href ="deleteinmate.php" class="panel__button">Delete Inmate</a>
            <a href ="updateinmate.php" class="panel__button">Update Inmate</a>
            <a href ="addvisitinfo.php" class="panel__button">Add Visit Info</a>
            <a href ="deletevisitinfo.php" class="panel__button">Delete Visit Info</a>
            <a href ="updatevisitinfo.php" class="panel__button">Update Visit Info</a>
            <a href ="visitinfo.php" class="panel__button">See Visit Info</a>
            <a href ="requestadmin.php" class="panel__button">See Requests</a>
            <a href ="statistics.php" class="panel__button">Statistics</a>
            <a href ="ban.php" class="panel__button">Ban User</a>
            <a href ="home.php" class="panel__button">Log Out</a>
        </div>
        <div>
        </div>
        <div class="panel__info">
          <div class="panel__text">Prison: Jilava</div>
          <div class="panel__text">Number of inmates: 10000000</div>
          <div class="panel__text">Number of employees: 5</div>
          <div class="panel__text">New visit requests: 382</div>
          
        </div>
    </div>
    <div class="sep">
    </div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>