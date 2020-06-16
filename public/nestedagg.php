<?php
//Retrieve episodes that are in more than x shows

if (isset($_POST['submit'])) {
// Pulling in required files
    require "../config.php";
    require "../common.php";

    try {
    // If the submission was valid, connect to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // SQL statement
        $sql = "SELECT episode_id, COUNT(show_id) AS count
                FROM show_has_episode
                GROUP BY episode_id
                HAVING COUNT(show_id) > :num";

        $num = $_POST['num'];

        // Prepare and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindValue(':num', $num, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS);

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<h2>See episodes that are in more than _ shows </h2>

<form action="nestedagg.php" method="post">
    <input type="text" name="num" placeholder="num" />
    </br>
    <input type="submit" name="submit">
</form>

</br>
</br>

<?php
    // Displays host_id of host who has hosted every episode if found
    if (isset($_POST['submit']) && $result) {
        echo "Episodes ";
        foreach($result as $row){
            print $row->episode_id;
            print " (";
            print $row->count;
            print ")";
            print ", ";
        }
        echo " are in $num or more shows.";
    } else if (isset($_POST['submit'])) {
        echo "No episodes are in $num or more shows";
    }
?>

</br>
<a href="index.php"> Back to main page</a>
<?php include "templates/footer.php"; ?>