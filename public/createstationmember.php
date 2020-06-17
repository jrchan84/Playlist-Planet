<?php

/**
  * Use an HTML form to create a new entry in the
  * users table.
  *
  */

    if (isset($_POST['submit'])) {
        // Pulling in required files
        require "../config.php";
        require "../common.php";

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

    <?php require "templates/header.php"; ?>

    <head>
    <link rel="stylesheet" href="css/subpage.css" />
    </head>

    <div class="Main">
        <br>
        <br>
        <?php 
            // Displays station member first name is user was sucessfully created.
            if (isset($_POST['submit']) && $statement) {
                echo $_POST['first_name'];
                echo " successfully added.";
            } ?>

    <div class="Form">  
        
        <h2> Add a station member </h2>
    
    <!-- Input form for creating a new station member -->
        <form method="post">
            <div class="form-group">
                <input placeholder="First Name" type="text" name="first_name" id="first_name" class="input-control">
                    <input placeholder="Last Name" type="text" name="last_name" id="last_name" class="input-control">
                        <input placeholder="Pronouns" type="text" name="pronouns" id="pronouns" class="input-control">
            </div>
            
            <div class="form-group">
                <input placeholder="Address" type="text" name="address" id="address" class="input-control">
                    <input placeholder="City" type="text" name="city" id="city" class="input-control" style="flex: 6">
                        <input placeholder="Province" type="text" name="province" id="province" class="input-control" style="flex: 1">
                            <input placeholder="Postal Code" type="text" name="postalcode" id="postalcode" class="input-control" style="flex: 2">
            </div>
            
            <div class="form-group">
                <input placeholder="Email Address" type="text" name="email" id="email" class="input-control" style="flex: 6">
                    <input placeholder="Primary Phone" type="text" name="primary_phone" id="primary_phone" class="input-control" style="flex: 3">
                        <input placeholder="Alternate Phone" type="text" name="alt_phone" id="alt_phone" class="input-control" style="flex: 3">
            </div>

            <div class="form-group">
                <input placeholder="Interests" type="text" name="interests" id="interests" class="input-control">
            </div>

            <div class="form-group">
                <input placeholder="Skills" type="text" name="skills" id="skills" class="input-control">
            </div>
        
            <input type="submit" name="submit" value="Submit">

        </form>

    </div>

    <div style="padding:20px; font-weight:bold" class="Footer-Overflow">
            <a href="index.php">Back to main page</a>
    </div>  

    </div>  


<?php include "templates/footer.php"; ?>