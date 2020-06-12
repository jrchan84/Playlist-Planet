<?php include "templates/header.php"; ?>

    <?php
    if (isset($_POST['submit'])) {
        require "../config.php";

        try {
            // If the submission was valid, connect to the database
            $connection = new PDO($dsn, $username, $password, $options);

            // Store all user info into an array
            $new_user = array(
                "first_name"    => $_POST['first_name'],
                "last_name"     => $_POST['last_name'],
                "province"      => $_POST['province'],
                "postalcode"    => $_POST['postalcode'],
                "pronouns"      => $_POST['pronouns'],
                "address"       => $_POST['address'],
                "city"          => $_POST['city'],
                "email"         => $_POST['email'],
                "primary_phone" => $_POST['primary_phone'],
                "alt_phone"     => $_POST['alt_phone'],
                "interests"     => $_POST['interests'],
                "skills"        => $_POST['skills']
              );

            // SQL statement
            $sql = "INSERT INTO station_members (first_name, last_name, province, postalcode, pronouns, address, city, email, primary_phone, alt_phone, interests, skills)
                    VALUES (:first_name, :last_name, :province, :postalcode, :pronouns, :address, :city, :email, :primary_phone, :alt_phone, :interests, :skills)";
            
            // Prepare and execute SQL statement
            $statement = $connection->prepare($sql);
            $statement->execute($new_user);

        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
    ?>

    <!-- Input form for creating a new station member -->
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

        </br>
        </br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>