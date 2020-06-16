<?php

/**
  * Function to query information based on
  * a parameter: in this case, collective name.
  *
  */
require "../config.php";
require "../common.php";

// make database connection
$connection = new PDO($dsn, $username, $password, $options);

if (isset($_POST['submit'])) {
    try {
    
        // SQL read statement
        $sql = "SELECT COUNT(*) AS no_of_members, c.name
                FROM members_are_part_of_collectives AS m, collectives AS c
                WHERE c.host_id = m.collective_id AND c.name = :collective_name
                GROUP BY c.name, c.host_id";
    
        // store collective_name variable
        $collective_name = isset($_POST['collective_name']) ? $_POST['collective_name'] : false;
    
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

try {
    // Get all collective names
    $c_sql = "SELECT name
            FROM collectives";
    $c_statement = $connection->prepare($c_sql);
    $c_statement->execute();
    
    // Fetch result of collective name query
    $c_result = $c_statement->fetchAll();
    
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>



<?php require "templates/header.php"; ?>

<head>
    <link rel="stylesheet" href="css/subpage.css" />
</head>

<div class="Main">

    <div class="Input">
    <h2>Find the Number of Members in a Collective</h2>  
        <form method="post">
            <label for="collective_name">Choose a collective:</label>
            <select name="collective_name" id="collective_name">
                <?php foreach ($c_result as $row): ?>
                <option id="collective_name" name="collective_name" value="<?php echo escape($row["name"]); ?>">
                    <?php echo escape($row["name"]); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" name="submit" value="View Results">
        </form>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        // Check to see if there is a non-empty set of results
        if ($result && $statement->rowCount() > 0) { ?>
        
        <div class="Result">
            <hr/>
            <h2>Search Results</h2>
            There 
            <?php 
                if ($result[0]['no_of_members'] > 1) {
                    echo "are";
                } else {
                    echo "is";
                }
            ?> 
            <?php echo escape($result[0]['no_of_members']); ?> 
            member(s) in the 
            <?php echo escape($_POST['collective_name']); ?>.
        </div>
    
        <?php } else { ?>
            <div class="Result">
            <hr/>
            <h2>Search Results</h2>
                There are 0 members in the <?php echo escape($_POST['collective_name']); ?>.
            </div>

        <?php }
    } ?>

    <div class="Footer">
        <a href="index.php"> Back to main page</a>
    </div> 

</div>


<?php include "templates/footer.php"; ?>