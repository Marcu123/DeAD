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
        <?php 
        if(count($data) == 0){
          echo '<div class = "user-account">
            <div class="user-account__info">
                <p class = "user-account__info__text">No inmate found</p>
            </div>
        </div>';
        }
        else foreach($data as $inmate) {
            echo '<div class = "user-account">
                  <img src = "../assets/prisoner.png" class = "user-account__image" alt="user">
            <div class="user-account__info">
                <p class = "user-account__info__text">First-Name: '. $inmate->getFirstName(). '</p>
                <p class = "user-account__info__text">Last-Name: ' . $inmate->getLastName(). '</p>
                <p class = "user-account__info__text">CNP: ' . $inmate->getCnp() . '</p>
                <p class = "user-account__info__text">Prison: ' . $inmate->getIdPrison() . '</p>
                <p class = "user-account__info__text">Date of incarceration: ' . $inmate->getDateOfIncarceration() . '</p>
                <p class = "user-account__info__text">End of incarceration: ' . $inmate->getEndOfIncarceration() . '</p>
                <p class = "user-account__info__text">Crime: ' . $inmate->getCrime() . '</p>
            </div>
        </div>';
        }   
        ?>     
      </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>