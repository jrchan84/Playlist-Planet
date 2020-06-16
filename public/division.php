<?php
//Retrieve episode_id's of episodes that are in every show


if (isset($_POST['submit'])) {
// Pulling in required files
    require "../config.php";
    require "../common.php";

    try {
    // If the submission was valid, connect to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // SQL statement
        $sql = "SELECT E.episode_id, E.title
                FROM episodes E
                WHERE E.episode_id = :episode_id AND NOT EXISTS
                    (SELECT *
                    FROM shows S
                    WHERE NOT EXISTS
                        (SELECT X.episode_id
                        FROM show_has_episode X
                        WHERE E.episode_id = X.episode_id AND S.show_id = X.show_id))";

        $episode = $_POST['episode_id'];

        // Prepare and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindValue(':episode_id', $episode, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS);

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

    <div class="Input">
        <h2>See if a episode is in ALL shows</h2>

        <form action="division.php" method="post">
            <input type="text" name="episode_id" placeholder="Episode ID" />
            </br>
            <input type="submit" name="submit">
        </form>
    </div>

    <div class="Result">
        <?php
            // Displays host_id of host who has hosted every episode if found
            if (isset($_POST['submit']) && $result) {
                echo "Episode with ID #";
                foreach($result as $row){
                    print $row->episode_id;
                    print ", ";
                    print $row->title;
                }
                echo " is in every show";
            } else if (isset($_POST['submit'])) {
                echo "Episode with ID #";
                echo $_POST["episode_id"];
                echo " is NOT in every show";
            }
        ?>
    </div>

    <div class="Footer">
        <a href="index.php"> Back to main page</a>
    </div>
</div>

<?php include "templates/footer.php"; ?>