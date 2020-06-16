<?php

/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */

require "../config.php";
require "../common.php";

// Update station member information
if (isset($_POST['submit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // Store updated information in array
        $user = array(
            "host_id"       => $_POST['host_id'],
            "first_name"    => $_POST['first_name'],
            "last_name"     => $_POST['last_name'],
            "province"      => $_POST['province'],
            "postalcode"    => $_POST['postalcode'],
            "pronouns"      => $_POST['pronouns'],
            "address"       => $_POST['address'],
            "city"          => $_POST['city'],
            "email"         => $_POST['email'],
            "primary_phone" => $_POST['primary_phone'],
            "alt_phone"     => $_POST['alt_phone'],
            "interests"     => $_POST['interests'],
            "skills"        => $_POST['skills']
          );

        $sql = "UPDATE station_members
                SET first_name = :first_name,
                    last_name = :last_name,
                    province = :province,
                    postalcode = :postalcode,
                    pronouns = :pronouns,
                    address = :address,
                    city = :city,
                    email = :email,
                    primary_phone = :primary_phone,
                    alt_phone = :alt_phone,
                    interests = :interests,
                    skills = :skills
                WHERE host_id = :host_id";

        $statement = $connection->prepare($sql);
        $statement->execute($user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  }

// Display user information of selected station member
if (isset($_GET['host_id'])) {
    try {
        // Make database connection, grabbing selected station member
        $connection = new PDO($dsn, $username, $password, $options);
        $id = $_GET['host_id'];
    
        // SQL execution
        $sql = "SELECT * FROM station_members WHERE host_id = :host_id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':host_id', $id);
        $statement->execute();
    
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "This user could not be found!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
  <?php echo escape($_POST['first_name']); ?> successfully updated.
<?php endif; ?>

<h2>Edit a station member's information</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
      <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" 
            <?php echo ($key === 'id' ? 'readonly' : null); ?>>
    <?php endforeach; ?>

    <input type="submit" name="submit" value="Submit">
</form>

<div style="padding:20px; font-weight:bold" class="Footer-Overflow">
     <a href="index.php">Back to main page</a>
</div>

<?php require "templates/footer.php"; ?>