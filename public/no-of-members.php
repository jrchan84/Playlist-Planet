<?php

/**
  * Function to query information based on
  * a parameter: in this case, collective name.
  *
  */

try {
    require "../config.php";
    require "../common.php";

    // make database connection
    $connection = new PDO($dsn, $username, $password, $options);

    // SQL read statement
    $sql = "SELECT *
            FROM station_members";

    // Prepare, bind and execute SQL statement
    $statement = $connection->prepare($sql);
    $statement->execute();

    // Fetch result
    $result = $statement->fetchAll();

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<table>
    <thead>
        <tr>
            <th>Number of Members:</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row): ?>
        <tr>
            <td><?php echo escape($row["first_name"]); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include "templates/footer.php"; ?>