<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/ban.css">

    <link rel="stylesheet" href="../src/styles/common/body.css" >
    <link rel="stylesheet" href="../src/styles/common/header.css" >

    <link rel="stylesheet" href="../src/styles/common/navbar.css" >
    <link rel="stylesheet" href="../src/styles/common/footer.css" >
    <link rel="stylesheet" href="../src/styles/common/form.css" >
    <title>Activate account</title>
</head>

<body>
<?php include 'common/navbar.php'; ?>

<main>
    <h1 class="header">Activate account</h1>
    <form action="activate/activate" method="post" class = "form">
        <label for="username">Activation Code: </label>
        <?php
        $codeErrorClass = isset($_SESSION['error']) ? '--error' : '';
        ?>
        <input type="text" class="form__field<?php echo $codeErrorClass; ?>" name="username" placeholder="" id="username" autocomplete="off" required>
        <?php if(isset($_SESSION['error']))
        {
            echo '<p class="form__error">'.$_SESSION['error'].'</p>';
        }
        ?>
        <button type="submit" class="form__button">Activate</button>
    </form>
    <div class="sep"></div>
</main>

<?php include 'common/footer.php'; ?>
</body>

</html>