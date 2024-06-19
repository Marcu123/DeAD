<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/forgotpassword.css">
    <link rel="stylesheet" href="../src/styles/common/body.css">
    <link rel="stylesheet" href="../src/styles/common/header.css">
    <link rel="stylesheet" href="../src/styles/common/navbar.css">
    <link rel="stylesheet" href="../src/styles/common/footer.css">
    <link rel="stylesheet" href="../src/styles/common/form.css">
    <title>Forgot Password</title>
</head>

<body>
<?php include 'common/navbar.php'; ?>

<main class="form-container">
    <h1 class="header">Forgot Password?</h1>
    <form id="forgotPasswordForm" class="form">
        <label for="email">Email: </label>
        <input type="email" class="form__field" name="email" id="email" placeholder="" autocomplete="off" required>
        <div id="message"></div>
        <button type="submit" class="form__button">Submit</button>
    </form>
    <div class="sep"></div>
</main>

<?php include 'common/footer.php'; ?>

<script>
    document.getElementById('forgotPasswordForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const messageDiv = document.getElementById('message');
        const emailField = document.getElementById('email');

        fetch('http://localhost/DeAD/api/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: email })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = '<p class="form__message form__good">' + data.message + '</p>';
                    emailField.classList.remove('form__field--error');
                    emailField.classList.add('form__field--good');
                } else {
                    messageDiv.innerHTML = '<p class="form__message form__error">' + data.error + '</p>';
                    emailField.classList.remove('form__field--good');
                    emailField.classList.add('form__field--error');
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p class="form__message form__message--error">An error occurred. Please try again later.</p>';
                emailField.classList.add('form__field--error');
            });
    });
</script>
</body>

</html>
