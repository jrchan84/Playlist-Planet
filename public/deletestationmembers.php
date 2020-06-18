<?php

/**
  * Delete station members
  */

require "../config.php";
require "../common.php";

if (isset($_POST["submitDelete"])) {
    try {
        // Make database connection
        $connection = new PDO($dsn, $username, $password, $options);
  
        $id = $_POST["removeUserSelect"];
  
        $sql = "DELETE FROM station_members WHERE host_id = :host_id";
        
        // Prepare, bind, execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindValue(':host_id', $id);
        $statement->execute();
  
        echo "User successfully deleted";
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
header('location: host.php#deleteUserTab');
echo '<script>alert("User has been deleted")</script>' ;
?>

