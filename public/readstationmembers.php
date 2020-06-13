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

        // SQL read statement
        $sql = "SELECT * 
                FROM station_members
                WHERE first_name = :first_name";
        
        // Store first name variable
        $first_name = $_POST['first_name'];

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

<?php
if (isset($_POST['submit'])) {
    // Check to see if there is a non-empty set of results
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Search Results</h2>

        <table>
            <thead>
                <tr>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                <tr>
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
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        No results found for <?php echo escape($_POST['first_name']); ?>.
    <?php }
} ?>

<h2>Find user based on first name</h2>

<form method="post">
    <label for="first_name">First Name</label>
    <input type="text" id="first_name" name="first_name">

    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>