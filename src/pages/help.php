<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/help.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <title>Help</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">
      Help
    </h1>
      <div class="box">
        <h2 class="box__title">For Users</h2>
        <h3 class="box__subtitle">Placing a Request</h3>
        <p class="box__text">You can request a visit with an inmate even if you don't have 
            an account in the request page of the website,
            just follow the instructions in the form.
        </p>
        <h3 class="box__subtitle">Account Administration</h3>
        <p class="box__text">In your account panel which you can access by logging in you can: </p>
        <ul class="box__list">
            <li>
                <p class="box__text">Change your information</p>
            </li>
            <li>
                <p class="box__text">Change you password</p>
            </li>
            <li>
                <p class="box__text">See your request history</p>
            </li>
            <li>
                <p class="box__text">See information registered about your last visits</p>
            </li>
        </ul>
      </div>

      <div class="box">
        <h2 class="box__title">For Admins</h2>
        <h3 class="box__subtitle">Prison Administration</h3>
        <p class="box__text">In your admin panel you can do the following: </p>
        <ul class="box__list">
            <li>
                <p class="box__text">Add, Delete and Update information about inmates</p>
            </li>
            <li>
                <p class="box__text">Add, Delete, Update and See information about specific visits that happened
                in your prison</p>
            </li>
            <li>
                <p class="box__text">See and accept/deny request placed for visiting inmates in your prison</p>
            </li>
            <li>
                <p class="box__text">Generate statistics related to a certain criteria in 
                    3 different formats: html, json, csv
                </p>
            </li>
            <li>
                <p class="box__text">Ban users that don't follow this app's guidelines</p>
            </li>
        </ul>
        </div>
        
  </main>

    <?php include 'common/footer.php'; ?>

</body>

</html>