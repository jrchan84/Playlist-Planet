<?php

/**
  * Open a connection via PDO to delete the playlist_planet
  * database and table and all associated data.
  *
  */

require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
    
    $sql = file_get_contents("data/drop.sql");
    $connection->exec($sql);

    echo "Database and table users deleted successfully.";
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}