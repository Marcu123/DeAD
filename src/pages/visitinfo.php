<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/visitinfo.css" >

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>See Visit Info</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">See Visit Info</h1>
    <form action="visitpage.php" method="get" class = "form">
        <label for="id">Request Id: </label>
        <input type="text" class="form__field" name="id" id="id" placeholder="" autocomplete="off" required>
        <button type="submit" class="form__button">Submit</button>
    </form>
    <div class="sep"></div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>