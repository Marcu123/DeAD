<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
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

    <form action="#" method="get" class="form">

        <label for="name">Name</label>
        <input type="text" class="form__field" id="name" name="name">

        <label for="prisoner-cnp">Inmate CNP</label>
        <input type="text" class="form__field" id="prisoner-cnp" name="prisoner-cnp" required>

        <label for="date">Date of incarceration</label>
        <input type="text" class="form__field" id="date" name="date">

        <label for="end">End of incarceration</label>
        <input type="text" class="form__field" id="end" name="end">

        <label for="crime">Crime</label>
        <input type="text" class="form__field" id="crime" name="crime">

        <button type="submit" class="form__button">Update</button>
    </form>

    <div class="sep"></div>
</main>

    <?php include 'common/footer.php'; ?>
</body>

</html>