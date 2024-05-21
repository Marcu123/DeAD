<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/updateinmate.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Update Inmate</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">
        Update Inmate
    </h1>

    <form action="Updateinmate/update" method="post" class="form">

        <label for="first_name">First Name</label>
        <input type="text" class="form__field" id="first_name" name="first_name">

        <label for="last_name">Last Name</label>
        <input type="text" class="form__field" id="last_name" name="last_name">

        <label for="prisoner-cnp">Inmate CNP</label>
        <input type="text" class="form__field" id="prisoner-cnp" name="prisoner-cnp" required>

        <label for="age">Age</label>
        <input type="text" class="form__field" id="age" name="age">

        <label for="gender">Gender</label>
        <input type="text" class="form__field" id="gender" name="gender">

        <label for="date_of_incarceracion">Date of incarceration</label>
        <input type="text" class="form__field" id="date_of_incarceracion" name="date_of_incarceracion">

        <label for="end_of_incarceration">End of incarceration</label>
        <input type="text" class="form__field" id="end_of_incarceration" name="end_of_incarceration">

        <label for="crime">Crime</label>
        <input type="text" class="form__field" id="crime" name="crime">

        <button type="submit" class="form__button">Update</button>
    </form>

    <div class="sep"></div>
</main>

    <?php include 'common/footer.php'; ?>
</body>

</html>