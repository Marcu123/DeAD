<?php
//session_start();
//?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/common/requestpage.css">
    <link rel="stylesheet" href="../src/styles/common/body.css">
    <link rel="stylesheet" href="../src/styles/common/header.css">
    <link rel="stylesheet" href="../src/styles/common/navbar.css">
    <link rel="stylesheet" href="../src/styles/common/footer.css">
    <link rel="stylesheet" href="../src/styles/common/form.css">

    <title>Requests</title>
</head>

<body>
<?php include 'common/navbar.php'; ?>
<main id="requests-container">
    <div id="request-container"></div>
</main>
<?php include 'common/footer.php'; ?>

<button id="scrollToTopBtn" class="form__button">Top</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('./requestuser/getRequests')
            .then(response => response.json())
            .then(data => {

                data.sort((a, b) => {
                    if (a.status === 'pending' && b.status !== 'pending') {
                        return -1;
                    }
                    if (a.status !== 'pending' && b.status === 'pending') {
                        return 1;
                    }
                    return 0;
                });

                const requestsContainer = document.getElementById('requests-container');
                data.forEach(request => {
                    const requestDiv = document.createElement('div');
                    requestDiv.className = 'request-container';
                    requestDiv.innerHTML = `
                        <p class="request-container__title">Request #${request.id}</p>
                        <p class="request-container__text">status: ${request.status}</p>
                        <p class="request-container__subtitle">Visitor(s) Info:</p>
                        <p class="request-container__text">${request.visitor_name}</p>
                        <p class="request-container__text">CNP: ${request.cnp}</p>
                        <p class="request-container__text">${request.visitor_type}</p>
                        <p class="request-container__text">email: ${request.email}</p>
                        <p class="request-container__text">phone number: ${request.phone_number}</p>
                        <p class="request-container__subtitle">Inmate Info: </p>
                        <p class="request-container__text">${request.inmate_name}</p>
                        <p class="request-container__text">CNP: ${request.inmate_cnp}</p>
                        <p class="request-container__subtitle">Date of visit: </p>
                        <p class="request-container__text">${request.date_of_visit}</p>
                    `;
                    requestsContainer.appendChild(requestDiv);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    scrollToTopBtn.style.position = "fixed";
    scrollToTopBtn.style.bottom = "20px";
    scrollToTopBtn.style.right = "30px";
    scrollToTopBtn.style.display = "none";

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
        const footer = document.querySelector('footer');
        const footerPosition = footer.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;

        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            if (footerPosition <= windowHeight) {
                scrollToTopBtn.style.display = "none";
            } else {
                scrollToTopBtn.style.display = "block";
            }
        } else {
            scrollToTopBtn.style.display = "none";
        }
    }

    scrollToTopBtn.addEventListener('click', function() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
</script>
</body>

</html>
