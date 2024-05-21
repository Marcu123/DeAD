<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/forgotpassword.css" >

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
    <h1 class="header">Forgot Password?</h1>
    <form action="#" method="post" class = "form">
        <label for="email">Email: </label>
        <input type="email" class="form__field" name="email" id="email" placeholder="" autocomplete="off" required>
        <button type="submit" class="form__button">Submit</button>
    </form>
    <div class="sep"></div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>