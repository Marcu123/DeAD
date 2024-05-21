<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/about.css">
  <link rel="stylesheet" href="../src/styles/addinmate.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Add Inmate</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">
        Add Inmate
    </h1>

    <form action="Addinmate/Add" method="get" class="form">

        <label for="first_name">First Name</label>
        <input type="text" class="form__field" id="first_name" name="first_name" required>

        <label for="last_name">Last Name</label>
        <input type="text" class="form__field" id="last_name" name="last_name" required>

        <label for="prisoner-cnp">Inmate CNP</label>
        <input type="text" class="form__field" id="prisoner-cnp" name="prisoner-cnp" required>

        <label for="age">Age</label>
        <input type="text" class="form__field" id="age" name="age" required>

        <label for="gender">Gender</label>
        <input type="text" class="form__field" id="gender" name="gender" required>

        <label for="date">Date of incarceration</label>
        <input type="text" class="form__field" id="date" name="date" required>

        <label for="end">End of incarceration</label>
        <input type="text" class="form__field" id="end" name="end" required>

        <label for="crime">Crime</label>
        <input type="text" class="form__field" id="crime" name="crime" required>

        <button type="submit" class="form__button">Add</button>
    </form>
    <div class="sep"></div>
</main>

<?php include 'common/footer.php'; ?>
</body>

</html>