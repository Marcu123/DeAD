<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/inmateprofile.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">
  <title>Inmate profile</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

      <main>
        <div class = "user-account">
            <img src = "../assets/prisoner.png" class = "user-account__image" alt="user">
            <div class="user-account__info">
                <p class = "user-account__info__text">ID: 1</p>
                <p class = "user-account__info__text">First-Name: John</p>
                <p class = "user-account__info__text">Last-Name: Doe</p>
                <p class = "user-account__info__text">CNP: 50300000000</p>
                <p class = "user-account__info__text">Prison: Jilava</p>
                <p class = "user-account__info__text">Date of incarceration: 16-04-2003</p>
                <p class = "user-account__info__text">End of incarceration: 16-04-2050</p>
                <p class = "user-account__info__text">Crime: money laundering</p>

            </div>
        </div>
        
      </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>