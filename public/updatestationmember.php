<?php

/**
  * Use an HTML form to edit an entry in the
  * users table.
  *
  */

require "../config.php";
require "../common.php";

// Update station member information
if (isset($_POST['updateUserSubmit'])) {
    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // get user input
        $host_id = $_POST['updateHostInput'];
        $first_name = $_POST['updateFirstNameInput'];
        $lastName = $_POST['updateLastNameInput'];
        $province = $_POST['updateProvinceInput'];
        $postalCode = $_POST['updatePostalInput'];
        $pronouns = $_POST['updatePronounsInput'];
        $address = $_POST['updateAddressInput'];
        $city = $_POST['updateCityInput'];
        $email = $_POST['updateEmailInput'];
        $primaryPhone = $_POST['updatePrimaryPhoneInput'];
        $altPhone = $_POST['updateAltPhoneInput'];
        $interests = $_POST['updateInterestsInput'];
        $skills = $_POST['updateSkillsInput'];

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
        $statement->bindValue(':host_id', $host_id);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $lastName);
        $statement->bindValue(':province', $province);
        $statement->bindValue(':postalcode', $postalCode);
        $statement->bindValue(':pronouns', $pronouns);
        $statement->bindValue(':address', $address);
        $statement->bindValue(':city', $city);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':primary_phone', $primaryPhone);
        $statement->bindValue(':alt_phone', $altPhone);
        $statement->bindValue(':interests', $interests);
        $statement->bindValue(':skills', $skills);
        $statement->execute();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  }

header('location: host.php#updateUserTab');
echo '<script>alert("User has been updated")</script>' ;
?>