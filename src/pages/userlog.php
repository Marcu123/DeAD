<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public//favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/userlog.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">
  <title>User Account</title>
</head>

<body>
  <?php include 'common/navbar.php'; ?>

  <main class = "form-container">
    <div>
        <h1 class = "header">Login</h1>
    <form action="userlog/login" method="post" class = "form">
        <label for="username1">Username: </label>
        <input type="text" class="form__field" name="username" id="username1" placeholder="" autocomplete="off" required>

        <label for="password1">Password: </label>
        <input type="password" class="form__field" name="password" id="password1" placeholder="" autocomplete="off" required>

        <label for="keeplogged">
          <input type="radio" class="form__radio" name="keeplogged" id="keeplogged" value="true">Remember me
        </label>

        <button type="submit" class="form__button" name="log_btn">Submit</button>

        <a href="forgotpassword.php" class="link">Forgot password?</a>
    </form>
</div>

<div>
  <h1 class = "header">Register</h1>
<form action="userlog/register" method="post" class = "form">
  <label for="username">Username: </label>
  <input type="text" class="form__field" name="username" id="username" placeholder="" autocomplete="off" required>

  <label for="password">Password: </label>
  <input type="password" class="form__field" name="password" id="password" placeholder="" autocomplete="off" required>

  <label for="email">E-mail address: </label>
  <input type="email" class="form__field" name="email" id="email" placeholder="" autocomplete="off" required>

  <label for="cnp">CNP: </label>
  <input type="text" class="form__field" name="cnp" id="cnp" placeholder="" autocomplete="off" required>

  <label for="imageUpload">Photo: </label>
  <input type="file" name="image" class="form__field form__field--file" id="imageUpload" accept="image/*" required>

  <label for="phone-number">Phone Number: </label>
  <input type="tel" class="form__field" name="phone-number" id="phone-number" placeholder="" autocomplete="off" required>

  <button type="submit" class="form__button" name="reg_btn">Submit</button>
</form>
</div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>