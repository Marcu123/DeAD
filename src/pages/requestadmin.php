<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public//favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/common/requestpage.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">

  <title>Requests</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>
    <main id="requests-container">
        <div id="request-container"></div>
    </main>

    <?php include 'common/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('./requestadmin/getRequests')
                .then(response => response.json())
                .then(data => {
                    //console.log(data);
                    var requestsContainer = document.getElementById('requests-container');
                    data.forEach(request => {
                        var requestDiv = document.createElement('div');
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
                <button type="submit" class="request-container__button">Accept</button>
                <button type="submit" class="request-container__button">Deny</button>
            `;
                        requestsContainer.appendChild(requestDiv);
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>