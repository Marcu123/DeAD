<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../../public//favicon.ico" type="image/x-icon">
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
      <form action="#" method="post" class="form">
        <label for="name">Name of the visitor/visitors:</label>
        <input type="text" id="name" name="name" class="form__field" placeholder="Petraru Marcu, Ioja Stefan">
        <div class="name-visitor">
          <h2>Instructions</h2>
          <p>Complete the name placeholder with your Last Name and First Name accordingly to your ID Card if you are not
            visiting alone, complete with the other visitors names</p>
          <p>Example: Ioja Stefan, Petraru Marcu</p>
        </div>

        <label for="visitType">Visitor Type</label>
        <select name="visitType" id="visitType" class="form__field">
          <option value="family">Family</option>
          <option value="friend">Friend</option>
          <option value="lawyer">Lawyer</option>
          <option value="legal guardian">Legal guardian</option>
        </select>
        <div class="type-visitor">
          <h2>Instructions</h2>
          <p>Choose the type of visitor you are. If there are others visitor, they don't need to complete.</p>
        </div>

        <label for="visit-type">Visit Type</label>
        <select name="visit-type" id="visit-type" class="form__field">
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
        <input type="date" id="date" class="form__field" name="date">

        <label for="cnp">CNP/CNPs:</label>
        <input type="text" id="cnp" class="form__field" name="cnp" placeholder="5030411111111, 3040411111111" autocomplete="off">
        <div class="cnp-visitor">
          <h2>Instructions</h2>
          <p>Complete the CNP placeholder with your CNP accordingly to your ID Card and if you are not visiting alone,
            complete with the other visitors's CNP </p>
          <p>Example: 5030411111111, 3040411111111</p>
        </div>

        <label for="imageUpload">Photo with the visitor/visitors:</label>
        <input type="file" id="imageUpload" class="form__field form__field--file" name="image" accept="image/*" multiple>

        <label for="email">Email/Emails:</label>
        <input type="email" id="email" class="form__field" name="email" placeholder="marcuioja@gmail.com, iojamarcu@yahoo.ro">
        <div class="email-visitor">
          <h2>Instructions</h2>
          <p>Complete the email placeholder with your email and if you are not visiting alone, complete with the other
            visitors's emails </p>
          <p>Example: marcuioja@gmail.com, iojamarcu@yahoo.ro</p>
        </div>

        <label for="phone-number">Phone Number/Numbers:</label>
        <input type="tel" id="phone-number" class="form__field" name="phone-number" placeholder="0743123456, 0787654321">
        <div class="phone-visitor">
          <h2>Instructions</h2>
          <p>Complete the Phone placeholder with your phone number and if you are not visiting alone, complete with the
            other visitors's phone numbers </p>
          <p>Example: 0743123456, 0787654321</p>
        </div>

        <label for="prisoner-cnp">Inmate CNP:</label>
        <input type="text" id="prisoner-cnp" class="form__field" name="prisoner-cnp" placeholder="5030411111111">
        <div class="inmate-cnp">
          <h2>Instructions</h2>
          <p>Complete the inmate CNP placeholder with the person you want to visit</p>
          <p>Example: 5030411111111</p>
        </div>

        <button type="submit" id="button" class="form__button">Submit</button>
      </form>
      </div>
  </main>

        <?php include 'common/footer.php'; ?>
</body>

</html>