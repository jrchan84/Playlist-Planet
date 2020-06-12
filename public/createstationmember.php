<?php include "templates/header.php"; ?>

    <form method="post">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name">

        <label for="province">Province</label>
        <input type="text" name="province" id="province">

        <label for="postalcode">Postal Code</label>
        <input type="text" name="postalcode" id="postalcode">

        <label for="pronouns">Pronouns</label>
        <input type="text" name="pronouns" id="pronouns">

        <label for="address">Address </label>
        <input type="text" name="address" id="address">

        <label for="city">City</label>
        <input type="text" name="city" id="city">

        <label for="email">Email Address</label>
        <input type="text" name="email" id="email">

        <label for="primary_phone">Primary Phone Number</label>
        <input type="text" name="primary_phone" id="primary_phone">

        <label for="alt_phone">Alternative Phone Number</label>
        <input type="text" name="alt_phone" id="alt_phone">

        <label for="interests">Interests</label>
        <input type="text" name="interests" id="interests">

        <label for="skills">Skills</label>
        <input type="text" name="skills" id="skills">

        <br>
        <br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>