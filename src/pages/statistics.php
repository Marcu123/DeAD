<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/statistics.css" >

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">

  <title>Statistics</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>
  <main>
    <h1 class="header">
      Statistics generator
    </h1>
      <form action="#" method="post" class="form">
        <label for="criteria">Criteria:</label>
        <select name="criteria" class="form__field" id="criteria">
          <option value="crime category">Crime Category</option>
          <option value="age group">Age group</option>
          <option value="gender">Gender</option>
        </select>

        <label for="format">Format:</label>
        <select name="format" class="form__field" id="format">
          <option value="html">HTML</option>
          <option value="json">JSON</option>
          <option value="csv">CSV</option>
        </select>

        <button type="submit" class="form__button">Generate</button>
    </form>
    <div class="sep"></div>

  </main>

        <?php include 'common/footer.php'; ?>
</body>

</html>