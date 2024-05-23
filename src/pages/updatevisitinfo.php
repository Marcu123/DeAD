<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../src/styles/common/body.css" >
  <link rel="stylesheet" href="../src/styles/common/header.css" >

  <link rel="stylesheet" href="../src/styles/common/navbar.css" >
  <link rel="stylesheet" href="../src/styles/common/footer.css" >
  <link rel="stylesheet" href="../src/styles/common/form.css" >
  <title>Update Visit Info</title>
</head>

<body>
    <?php include 'common/navbar.php'; ?>

  <main>
    <h1 class="header">Update Visit Info</h1>
    <form action="updatevisitinfo/update" method="post" class = "form">
        <label for="id">Request Id: </label>
        <input type="text" class="form__field" name="id" id="id" placeholder="" autocomplete="off" required>

        <label for="objects_traded">Objects Traded: </label>
        <input type="text" class="form__field" name="objects_traded" id="objects_traded" placeholder="" autocomplete="off">

        <label for="conversation_resume">Conversation Resume: </label>
        <textarea class="form__field" name="conversation_resume" id="conversation_resume" rows="4" cols="50"></textarea>

        <label for="health_status">Health Status: </label>
        <select name="health_status" class="form__field" id="health_status">
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

        <button type="submit" class="form__button">Update</button>
    </form>
    <div class="sep"></div>
  </main>

    <?php include 'common/footer.php'; ?>
</body>

</html>