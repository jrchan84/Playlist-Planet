<?php

/**
  * List all users with a link to edit
  */

try {
    require "../config.php";
    require "../common.php";

    // Establish database connection
    $connection = new PDO($dsn, $username, $password, $options);

    // Grab all users using SQL
    $sql = "SELECT * FROM station_members";

    // Prepare and execute SQL statement
    $statement = $connection->prepare($sql);
    $statement->execute();

    // Store result
    $result = $statement->fetchAll();

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<h2>Update station member information</h2>

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

            <th>Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $row): ?>
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
            <td><a href="updatestationmember.php?id=<?php echo escape($row["host_id"]);?>">Edit</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>