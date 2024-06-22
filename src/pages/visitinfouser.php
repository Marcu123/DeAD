<?php
//session_start();
//?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../src/styles/common/panel.css">
    <link rel="stylesheet" href="../src/styles/adminpanel.css">

    <link rel="stylesheet" href="../src/styles/common/body.css" >
    <link rel="stylesheet" href="../src/styles/common/header.css" >

    <link rel="stylesheet" href="../src/styles/common/navbar.css" >
    <link rel="stylesheet" href="../src/styles/common/footer.css" >
    <link rel="stylesheet" href="../src/styles/common/form.css" >
    <title>Admin Account</title>
</head>

<body>
<?php include 'common/navbar.php'; ?>

<main>
    <?php
    foreach($data as $visitInfo){
        $inmate = $visitInfo->getInmate();
        $witnesses = $visitInfo->getWitnesses();
        echo '<div class = "user-account">
            <h2>Visit Info: </h2>
            <div class="user-account__info">
            <p class = "user-account__info__text">ID: ' . $visitInfo->getID() . '</p>
                <p class = "user-account__info__text">Request ID: ' . $visitInfo->getRequestID() . '</p>
                <h3>Inmate: </h3>
                <p class = "user-account__info__text">First-Name: ' . $inmate->getFirstName() . '</p>
                <p class = "user-account__info__text">Last-Name: ' . $inmate->getLastName() . '</p>
                <p class = "user-account__info__text">CNP: ' . $inmate->getCnp() . '</p>
                <p class = "user-account__info__text">Prison: ' . $inmate->getIdPrison() . '</p>
                <p class = "user-account__info__text">Date of incarceration: ' . $inmate->getDateOfIncarceration() . '</p>
                <p class = "user-account__info__text">End of incarceration: ' . $inmate->getEndOfIncarceration() . '</p>
                <p class = "user-account__info__text">Crime: ' . $inmate->getCrime() . '</p>
                
                <p class = "user-account__info__text">Objects Traded: ' . $visitInfo->getObjectsTraded() . '</p>
                <p class = "user-account__info__text">Conversation Resume: ' . $visitInfo->getConversationResume() . '</p>
                <p class = "user-account__info__text">Health Status: ' . $visitInfo->getHealthStatus() . '</p>
                <p class = "user-account__info__text">Mood: ' . $visitInfo->getMood() . '</p>
                
                <h3>Witnesses: </h3>';
        foreach ($witnesses as $witness) {
            //visitor
            if (strcmp($witness->getType(), 'visitor') == 0) {
                $visitor = $witness->getVisitor();
                echo '<p class = "user-account__info__text">Name: ' . $visitor->getVisitorName() . '</p>
                            <p class = "user-account__info__text">CNP: ' . $visitor->getCnp() . '</p>
                            <p class = "user-account__info__text">Email: ' . $visitor->getEmail() . '</p>
                            <p class = "user-account__info__text">Phone Number: ' . $visitor->getPhoneNumber() . '</p>';
            } else { //employee
                $employee = $witness->getEmployee();
                echo '<p class = "user-account__info__text">Employee</p>
                            <p class = "user-account__info__text">Name: ' . $employee->getName() . '</p>
                            <p class = "user-account__info__text">CNP: ' . $employee->getCnp() . '</p>';
            }
        }
        echo ' </div></div>';
    }
    ?>
</main>

<?php include 'common/footer.php'; ?>
</body>

</html>
