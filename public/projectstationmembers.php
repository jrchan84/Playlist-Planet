<?php

/**
  * Function to query information based on
  * a table fields
  *
  */

if (isset($_POST['submit'])) {
    try {
        require "../config.php";
        require "../common.php";

        // make database connection
        $connection = new PDO($dsn, $username, $password, $options);

        // Store first name variable
        $field = $_POST['field'];
        $value = $field[0];

        // SQL read statement
        $sql = "SELECT " . $value .
                " FROM station_members";

        // Prepare, bind and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindParam(':'.$value, $value, PDO::PARAM_STR);
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
        <?php // Get posted value
        $field = $_POST['field'];
        $value = $field[0];
        ?>
        
        <h2>Information Results</h2>

        <table>
            <thead>
                <tr>
                    <th><?php echo $value?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo escape($row["$value"]); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        No results found for <?php echo escape($_POST['first_name']); ?>.
    <?php }
} ?>

<h2>Find specific station member information</h2>

<form method="post">
    <label>Select field</label>
    <select name="field[]" id="field">
        <option value="first_name">First Name</option>
        <option value="last_name">Last Name</option>
        <option value="province">Province</option>
        <option value="postalcode">Postal Code</option>
        <option value="pronouns">Pronouns</option>
        <option value="address">Address</option>
        <option value="city">City</option>
        <option value="email">Email</option>
        <option value="primary_phone">Primary Phone</option>
        <option value="alt_phone">Alternative Phone</option>
        <option value="interests">Interests</option>
        <option value="skills">Skills</option>

    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>