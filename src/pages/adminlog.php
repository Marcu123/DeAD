<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/adminlog.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Admin Login</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <div>
        <h1 class = "header">Login</h1>
    <form action="adminlog/login" method="post" class = "form">
        <label for="username">Username: </label>
        <input type="text" class="form__field" name="username" placeholder="" id="username" autocomplete="off" required>

        <label for="admin_key">Admin Key: </label>
        <input type="password" class="form__field" name="admin_key" placeholder="" id="admin_key" autocomplete="off" required>

        <button type="submit" class="form__button" name="log_btn">Submit</button>
    </form>
    <div class="sep">
    </div>
</div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>