<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/changeinfo.css">

    <link rel="stylesheet" href="../src/styles/common/body.css" >
    <link rel="stylesheet" href="../src/styles/common/header.css" >

    <link rel="stylesheet" href="../src/styles/common/navbar.css" >
    <link rel="stylesheet" href="../src/styles/common/footer.css" >
    <link rel="stylesheet" href="../src/styles/common/form.css">
    <title>Change Info</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

    <main>
        <h1 class = "header">Change your account's information</h1>
        <form action="changeinfo/change" method="post" class = "form">
            <label for="username">Username: </label>
            <input type="text" class="form__field" name="username" id="username" placeholder="" autocomplete="off">
    
            <label for="email">E-mail address: </label>
            <input type="email" class="form__field" name="email" id="email" placeholder="" autocomplete="off">
    
            <label for="cnp">CNP: </label>
            <input type="text" class="form__field" name="cnp" id="cnp" placeholder="" autocomplete="off">
    
            <label for="imageUpload">Photo: </label>
            <input type="file" name="image" class="form__field form__field--file" id="imageUpload" accept="image/*">
    
            <label for="phone-number">Phone Number: </label>
            <input type="tel" class="form__field" name="phone-number" id="phone-number" placeholder="" autocomplete="off">
    
            <button type="submit" class="form__button">Submit</button>
        </form>
    </main>

    <?php include 'common/footer.php'; ?>

</body>

</html>