<?php

/**
  * Function to query information based on
  * a parameter: in this case, collective name.
  *
  */

if (isset($_POST['submit'])) {
    try {
        require "../config.php";
        require "../common.php";

        // make database connection
        $connection = new PDO($dsn, $username, $password, $options);

        // SQL read statement
        $sql = "SELECT artists.artist_id, artists.name, performed_by.media_id, tracks.album, tracks.genre
                FROM collectives, station_members, members_are_part_of_collectives
                WHERE 
                    tracks.album = :collective_name";
        
        // Store collective name variable
        $collective_name = $_POST['collective_name'];

        // Prepare, bind and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindParam(':collective_name', $collective_name, PDO::PARAM_STR);
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
                    <th>Collective</th>
                    <th># of Members</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo escape($row["name"]); ?></td>
                    <td><?php echo escape($row["no_of_members"]); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <a href="index.php"> Back to main page</a>
    <?php } else { ?>
        No results found for <?php echo escape($_POST['collective_name']); ?>.
    <?php }
} ?>

<h2>Find Number of Members in a Collective</h2>

<form method="post">
    <label for="collective_name">Collective Name</label>
    <input type="text" id="collective_name" name="collective_name">

    <input type="submit" name="submit" value="View Results">
</form>

<a href="index.php"> Back to main page</a>

<?php include "templates/footer.php"; ?>