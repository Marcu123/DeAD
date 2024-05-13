<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../publicfavicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/searchpage.css">

    <link rel="stylesheet" href="../src/styles/common/body.css" >
    <link rel="stylesheet" href="../src/styles/common/header.css" >

    <link rel="stylesheet" href="../src/styles/common/navbar.css" >
    <link rel="stylesheet" href="../src/styles/common/footer.css" >
    <link rel="stylesheet" href="../src/styles/common/form.css">
    <title>Search</title>
</head>

<body>

    <?php include 'common/navbar.php'; ?>
    <main>
        <h1 class="header">
            Search for inmate's profile.
        </h1>

        <form action="searchpage/getInfo" method="get" class="form">

            <label for="name">Name</label>
            <input type="text" class="form__field" id="name" name="name">

            <label for="prisoner-cnp">Inmate CNP</label>
            <input type="text" class="form__field" id="prisoner-cnp" name="prisoner-cnp">

            <label for="prison">Prison</label>
            <input type="text" class="form__field" id="prison" name="prison">

            <label for="date">Date of incarceration</label>
            <input type="text" class="form__field" id="date" name="date">

            <label for="end">End of incarceration</label>
            <input type="text" class="form__field" id="end" name="end">

            <label for="crime">Crime</label>
            <input type="text" class="form__field" id="crime" name="crime">

            <button type="submit" class="form__button">Submit</button>
        </form>
    </main>

    <?php include 'common/footer.php'; ?>

</body>

</html>