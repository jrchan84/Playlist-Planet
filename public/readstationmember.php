<?php include "templates/header.php"; ?>

<h2>Find user based on first name</h2>

<form method="post">
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name">

    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>