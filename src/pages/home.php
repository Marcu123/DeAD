<?php
    echo password_hash('dead', PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" >
  <meta name="viewport" content="width=device-width, initial-scale=1.0" >
  <link rel="icon" href="favicon.ico" type="image/x-icon" >
  <link rel="stylesheet" href="../src/styles/index.css" >

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >

  <title>Home</title>
</head>

<body>
<?php include 'common/navbar.php'; ?>
  <main>
    <div class="main-image-container">
      <img class="main-image" src="../src/assets/fundalbun.png" alt="Prison" >
      <div class="main-image-gradient"></div>
    </div>
    <h1 class="header">
      Welcome to DeAD, International Detention Administration!
    </h1>

    <ul class="button-list">
      <li class="button-list__element">
        <a href="searchpage">
          <img class="button-list__image" src="../src/assets/search_inmate.png" title="Search inmate" >
        </a>
        <p class="button-list__text">Search inmate</p>
      </li>
      <li class="button-list__element">
        <a href="request">
          <img class="button-list__image" src="../src/assets/request.png" title="Request" >
        </a>
        <p class="button-list__text">Request visit</p>
      </li>
      <li class="button-list__element">
        <a href="userlog">
          <img class="button-list__image" src="../src/assets/user.png" title="User account" >
        </a>
        <p class="button-list__text">User account</p>
      </li>
      <li class="button-list__element">
        <a href="adminlog">
          <img class="button-list__image" src="../src/assets/admin.png" title="Admin account" >
        </a>
        <p class="button-list__text">Admin account</p>
      </li>
    </ul>
  </main>

<?php include 'common/footer.php'; ?>

</body>

</html>