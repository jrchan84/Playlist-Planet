<?php

/**
  * Function to query information based on
  * a table fields
  *
  */

if (isset($_POST['submit'])) {
    if (isset($_POST['fields'])) {
        try {
            require "../config.php";
            require "../common.php";

            // make database connection
            $connection = new PDO($dsn, $username, $password, $options);

            // Store selected variables
            $field = $_POST['fields'];

            // SQL read statement
            $sql = "SELECT " . implode(',', $_POST['fields']) .
                    " FROM station_members";

            // Prepare, bind and execute SQL statement
            $statement = $connection->prepare($sql);
            //$statement->bindParam(':'.$value, $value, PDO::PARAM_STR);
            $statement->execute();

            // Fetch result
            $result = $statement->fetchAll();

        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
}
?>

<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit']) and isset($_POST['fields'])) {
    // Check to see if there is a non-empty set of results
    if ($result && $statement->rowCount() > 0) { ?>
        <?php // Get posted value
        $fields = $_POST['fields'];
        ?>
        
        <h2>Information Results</h2>

        <table>
            <thead>
                <tr>
                    <?php foreach ($fields as $field) { ?>
                        <th><?php echo $field?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                <tr>
                    <?php foreach ($fields as $field) { ?>
                        <td><?php echo escape($row["$field"]); ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        Could not display the selected fields.
    <?php }
} else { ?>
    No fields were selected.
<?php } ?> 

<h2>Find specific station member information</h2>

<form method="post">
    <label>Select fields</label><br>
    
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

    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to main page</a>

<?php include "templates/footer.php"; ?>