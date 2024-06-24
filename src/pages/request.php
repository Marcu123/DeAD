<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/request.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css">

  <title>Request</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>
  <main>
    <h1 class="header">
      Form for requesting to visit a prisoner!
    </h1>
    <div class="form-instr">
        <form method="post" class="form" id="visitorForm" enctype="multipart/form-data">
            <?php

            if(isset($_SESSION['error']))
            {
                $requestErrorClass = '--error';
            }
            else if(isset($_SESSION['good']))
            {
                $requestErrorClass = '--good';
            }
            else
            {
                $requestErrorClass = '';
            }
            ?>
        <label for="name">Visitor Name:</label>
        <input type="text" id="name" name="name" class="form__field<?php echo $requestErrorClass; ?>" placeholder="Enter name">


        <label for="visitType">Visitor Type</label>
        <select name="visitType" id="visitType" class="form__field<?php echo $requestErrorClass; ?>">
          <option value="family">Family</option>
          <option value="friend">Friend</option>
          <option value="lawyer">Lawyer</option>
          <option value="legal guardian">Legal guardian</option>
        </select>


        <label for="visit-type">Visit Type</label>
        <select name="visit-type" id="visit-type" class="form__field<?php echo $requestErrorClass; ?>">
          <option value="health">Verify how he/she feels</option>
          <option value="communicate">Speak about personal information</option>
          <option value="process">Discuss how the process is going</option>
          <option value="monthly visit">Monthly visit</option>
          <option value="legal consultation">Legal consultation</option>
          <option value="family">Family visit</option>
          <option value="education">Educational session</option>
          <option value="religious">Religious services</option>
          <option value="therapy">Therapeutic session</option>
        </select>


        <label for="date">Date of the visit:</label>
        <input type="date" id="date" class="form__field<?php echo $requestErrorClass; ?>" name="date">

        <label for="cnp">CNP:</label>
        <input type="text" id="cnp" class="form__field<?php echo $requestErrorClass; ?>" name="cnp" placeholder="Enter cnp" autocomplete="off">


        <label for="imageUpload">Photo with the visitor:</label>
        <input type="file" id="imageUpload" class="form__field form__field--file" name="fileToUpload" accept="image/*" multiple>

        <label for="email">Email:</label>
        <input type="email" id="email" class="form__field<?php echo $requestErrorClass; ?>" name="email" placeholder="Enter email">


        <label for="phone-number">Phone Number:</label>
        <input type="tel" id="phone-number" class="form__field<?php echo $requestErrorClass; ?>" name="phone-number" placeholder="Enter phone number">


        <label for="prisoner-cnp">Inmate CNP:</label>
        <input type="text" id="prisoner-cnp" class="form__field<?php echo $requestErrorClass; ?>" name="prisoner-cnp" placeholder="Enter inmate cnp">

            <?php
            if(isset($_SESSION['error']))
            {
                echo '<p class="form__error">'.$_SESSION['error'].'</p>';
            }
            if(isset($_SESSION['good']))
            {
                echo '<p class="form__good">'.$_SESSION['good'].'</p>';
            }
            ?>
          <button type="button" id="addMore" class="form__button">+</button>
          <button type="submit" id="button" class="form__button">Submit</button>
      </form>
      </div>
  </main>

        <?php include 'common/footer.php';
        unset($_SESSION['error']);
        unset($_SESSION['good']);
        ?>

    <script>
        let numClicks = 0;
        const maxClicks = 2;

        document.getElementById('addMore').addEventListener('click', function() {
            if (numClicks < maxClicks) {
                const form = document.querySelector('.form');
                const delimiter = document.createElement('hr');
                delimiter.style.border = 'none';
                delimiter.style.height = '5px';
                delimiter.style.backgroundColor = '#ccc';
                form.insertBefore(delimiter, document.getElementById('addMore'));

                const fields = [
                    { label: 'Visitor Name:', type: 'text', id: 'name_extra' + numClicks, name: 'name_extra' + numClicks, placeholder: 'Enter name' },
                    { label: 'CNP:', type: 'text', id: 'cnp_extra' + numClicks, name: 'cnp_extra' + numClicks, placeholder: 'Enter CNP' },
                    { label: 'Photo with the visitor:', type: 'file', id: 'fileToUpload' + numClicks, name: 'fileToUpload' + numClicks, accept: 'image/*', multiple: true },
                    { label: 'Email:', type: 'email', id: 'email_extra' + numClicks, name: 'email_extra' + numClicks, placeholder: 'Enter email' },
                    { label: 'Phone Number:', type: 'tel', id: 'phone-number_extra' + numClicks, name: 'phone-number_extra' + numClicks, placeholder: 'Enter phone number' }
                ];

                fields.forEach(field => {
                    const fieldContainer = document.createElement('div');
                    const label = document.createElement('label');
                    label.htmlFor = field.id;
                    label.textContent = field.label;
                    const input = document.createElement('input');
                    input.type = field.type;
                    input.id = field.id;
                    input.name = field.name;
                    input.placeholder = field.placeholder;
                    if (field.type === 'file') {
                        input.accept = field.accept;
                        input.multiple = field.multiple;
                    }
                    input.className = 'form__field';
                    fieldContainer.appendChild(label);
                    fieldContainer.appendChild(input);
                    form.insertBefore(fieldContainer, document.getElementById('addMore'));
                });

                numClicks++;
            }

            if (numClicks >= maxClicks) {
                document.getElementById('addMore').style.display = 'none';
            }
        });

        document.getElementById('visitorForm').addEventListener('submit', function(event) {
            //event.preventDefault();
            const formData = new FormData(this);
            formData.append('clickCount', numClicks.toString());

            fetch('request/form', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    console.log('Success:', response.statusText);
                } else {
                    console.error('Error:', response.statusText);
                }
            }).catch(error => console.error('Error:', error));
        });
    </script>


</body>

</html>