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
    document.addEventListener('DOMContentLoaded', function () {
        fetch('./requestadmin/getRequests')
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
                        <p class="request-container__text">Status: ${request.status}</p>
                        <p class="request-container__subtitle">Visitor(s) Info:</p>
                        <img src="${request.photo}" alt="Visitor Photo" class="request-container__visitor-photo">
                        <p class="request-container__text">Name: ${request.visitor_name}</p>
                        <p class="request-container__text">CNP: ${request.cnp}</p>
                        <p class="request-container__text">Visitor Type: ${request.visitor_type}</p>
                        <p class="request-container__text">Email: ${request.email}</p>
                        <p class="request-container__text">Phone number: ${request.phone_number}</p>
                        ${request.visitor1_name ? `
                            <p class="request-container__subtitle">Additional Visitor 1 Info:</p>
                            <img src="${request.visitor1_photo}" alt="Visitor 1 Photo" class="request-container__visitor-photo">
                            <p class="request-container__text">Name: ${request.visitor1_name}</p>
                            <p class="request-container__text">CNP: ${request.visitor1_cnp}</p>
                            <p class="request-container__text">Email: ${request.visitor1_email}</p>
                            <p class="request-container__text">Phone number: ${request.visitor1_phone}</p>
                        ` : ''}
                        ${request.visitor2_name ? `
                            <p class="request-container__subtitle">Additional Visitor 2 Info:</p>
                            <img src="${request.visitor2_photo}" alt="Visitor 2 Photo" class="request-container__visitor-photo">
                            <p class="request-container__text">Name: ${request.visitor2_name}</p>
                            <p class="request-container__text">CNP: ${request.visitor2_cnp}</p>
                            <p class="request-container__text">Email: ${request.visitor2_email}</p>
                            <p class="request-container__text">Phone number: ${request.visitor2_phone}</p>
                        ` : ''}
                        <p class="request-container__subtitle">Inmate Info:</p>
                        <p class="request-container__text">Name: ${request.inmate_name}</p>
                        <p class="request-container__text">CNP: ${request.inmate_cnp}</p>
                        <p class="request-container__subtitle">Date of visit:</p>
                        <p class="request-container__text">${request.date_of_visit}</p>
                    `;

                    if (request.status === 'pending') {
                        requestDiv.innerHTML += `
                            <button type="button" class="request-container__button accept-button" data-id="${request.id}">Accept</button>
                            <button type="button" class="request-container__button deny-button" data-id="${request.id}">Deny</button>
                        `;
                    }

                    requestsContainer.appendChild(requestDiv);
                });

                document.querySelectorAll('.accept-button').forEach(button => {
                    button.addEventListener('click', function () {
                        updateRequestStatus(this.getAttribute('data-id'), 'accepted', this);
                    });
                });

                document.querySelectorAll('.deny-button').forEach(button => {
                    button.addEventListener('click', function () {
                        updateRequestStatus(this.getAttribute('data-id'), 'denied', this);
                    });
                });
            })
            .catch(error => console.error('Error:', error));
    });

    function updateRequestStatus(requestId, status, button) {
        console.log(`Updating request ID ${requestId} to status ${status}`);

        fetch('./requestadmin/updateRequestStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: requestId, status: status })
        })
            .then(response => {
                console.log('Response received:', response);
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.success) {
                    console.log("Status updated successfully.");
                    button.parentElement.querySelector('.request-container__text').innerText = 'Status: ' + status;
                    button.parentElement.querySelectorAll('.accept-button, .deny-button').forEach(btn => btn.style.display = 'none');
                } else {
                    console.error('Failed to update request status:', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }

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
