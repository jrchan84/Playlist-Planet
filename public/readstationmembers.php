<?php

/**
  * Function to query information based on
  * a parameter: in this case, first name.
  *
  */

if (isset($_POST['submit'])) {
    try {
        require "../config.php";
        require "../common.php";

        // make database connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Store first name variable and selected columns
        $first_name = $_POST['first_name'];
        if (isset($_POST['fields']))
            $field = $_POST['fields'];

        // SQL read statement
        if (isset($_POST['fields'])) {
            $sql = "SELECT " . implode(',', $_POST['fields']) .
                    " FROM station_members
                    WHERE first_name = :first_name";
        } else {
            $sql = "SELECT *
                    FROM station_members
                    WHERE first_name = :first_name";
        }

        // Prepare, bind and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $statement->execute();

        // Fetch result
        $result = $statement->fetchAll();

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
    <?php
    if (isset($_POST['submit'])) {
        // Check to see if there is a non-empty set of results
        if ($result && $statement->rowCount() > 0) { ?>

        <div class="Result">
            <hr />
            <h2>Search Results</h2>
    
            <table>
                <thead>
                    <tr>
                        <?php if (isset($_POST['fields'])) {
                            $fields = $_POST['fields'];
                            foreach ($fields as $field) { ?>
                                <th><?php echo $field?></th>
                        <?php }
                            } else { ?>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Province</th>
                        <th>Postal Code</th>
                        <th>Pronouns</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>E-mail Address</th>
                        <th>Primary #</th>
                        <th>Alt #</th>
                        <th>Interests</th>
                        <th>Skills</th>
                        <?php } ?> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) { ?>
                    <tr>
                        <?php if (isset($_POST['fields'])) {
                            foreach ($fields as $field) { ?>
                                <td><?php echo escape($row["$field"]); ?></td>
                        <?php }
                            } else { ?> 
                        <td><?php echo escape($row["host_id"]); ?></td>
                        <td><?php echo escape($row["first_name"]); ?></td>
                        <td><?php echo escape($row["last_name"]); ?></td>
                        <td><?php echo escape($row["province"]); ?></td>
                        <td><?php echo escape($row["postalcode"]); ?></td>
                        <td><?php echo escape($row["pronouns"]); ?></td>
                        <td><?php echo escape($row["address"]); ?></td>
                        <td><?php echo escape($row["city"]); ?></td>
                        <td><?php echo escape($row["email"]); ?></td>
                        <td><?php echo escape($row["primary_phone"]); ?></td>
                        <td><?php echo escape($row["alt_phone"]); ?></td>
                        <td><?php echo escape($row["interests"]); ?></td>
                        <td><?php echo escape($row["skills"]); ?></td>
                        <?php } ?> 
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } else { ?>
            <div class="Result">
                No results found for <?php echo escape($_POST['first_name']); ?>.
            </div>
        <?php }
    } ?>
    
    
    <form method="post">
        
        <div class="Input">
            <h2>Find station member information based on first name</h2>
            <label style="font-weight: bold; font-size:20px; text-decoration: underline">Select fields to view</label><br>
                
                    <input type='checkbox' name='fields[]' value='first_name'>First Name<br>
                    <input type='checkbox' name='fields[]' value='last_name'>Last Name<br>
                    <input type='checkbox' name='fields[]' value='province'>Province<br>
                    <input type='checkbox' name='fields[]' value='postalcode'>Postal Code<br>
                    <input type='checkbox' name='fields[]' value='pronouns'>Pronouns<br>
                    <input type='checkbox' name='fields[]' value='address'>Address<br>
                    <input type='checkbox' name='fields[]' value='city'>City<br>
                    <input type='checkbox' name='fields[]' value='email'>Email<br>
                    <input type='checkbox' name='fields[]' value='primary_phone'>Primary Phone<br>
                    <input type='checkbox' name='fields[]' value='alt_phone'>Alternate Phone<br>
                    <input type='checkbox' name='fields[]' value='interests'>Interests<br>
                    <input type='checkbox' name='fields[]' value='skills'>Skills<br>
                <br/>
            
                <input placeholder="Search by first name" type="text" id="first_name" name="first_name">
                <input type="submit" name="submit" value="View Results">
        </div>

    </form>


    <div class="Footer">
            <a href="index.php"> Back to main page</a>
        </div>

        <div class="Credits">
            Made by Justin Chan, Patrick Lee, Carol Zhang | 
            <a href="https://github.com/RedundantComputation/playlist-planet"> <b>Github Repo</b></a>
         </div>
</div>

<?php include "templates/footer.php"; ?>