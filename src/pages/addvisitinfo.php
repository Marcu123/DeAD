<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../src/styles/about.css">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Add Visit Info</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">Add Visit Info</h1>
    <form action="AddVisitInfo/add" method="post" class = "form">
        <label for="request-id">Request ID: </label>
        <input type="text" class="form__field" name="request-id" id="request-id" placeholder="" autocomplete="off" required>

        <label for="prisoner-cnp">Inmate CNP: </label>
        <input type="text" class="form__field" name="prisoner-cnp" id="prisoner-cnp" placeholder="" autocomplete="off" required>

        <label for="objects">Objects Traded: </label>
        <input type="text" class="form__field" name="objects" id="objects" placeholder="" autocomplete="off">

        <label for="conversation">Conversation Resume: </label>
        <textarea class="form__field" name="conversation" id="conversation" rows="4" cols="50"></textarea>

        <label for="health">Health Status: </label>
        <select name="health" class="form__field" id="health">
            <option value="healthy">Healthy</option>
            <option value="sick">Sick</option>
        </select>

        <label for="mood">Mood: </label>
        <select name="mood" class="form__field" id="mood">
            <option value="angry">Angry</option>
            <option value="happy">Happy</option>
            <option value="sad">Sad</option>
            <option value="calm">Calm</option>
            <option value="anxious">Anxious</option>
        </select>

        <label for="witness">Witness(es): </label>
        <input type="text" class="form__field" name="witness" id="witness" placeholder="" autocomplete="off">

        <button type="submit" class="form__button">Add</button>
    </form>
    <div class="sep"></div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>