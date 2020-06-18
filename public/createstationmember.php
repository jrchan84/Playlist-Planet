<?php
//create a new user from host.html create form
require "../config.php";
require "../common.php";

if (isset($_POST['createSubmit'])) {

    try {
        // If the submission was valid, connect to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // get user info
        $firstName = $_POST['createFirstNameInput'];
        $lastName = $_POST['createLastNameInput'];
        $province = $_POST['createProvinceInput'];
        $postalCode = $_POST['createPostalCodeInput'];
        $pronouns = $_POST['createPronounsInput'];
        $address = $_POST['createAddressInput'];
        $city = $_POST['createCityInput'];
        $email = $_POST['createEmailInput'];
        $primaryPhone = $_POST['createPrimaryPhoneInput'];
        $altPhone = $_POST['createAltPhoneInput'];
        $interests = $_POST['createInterestsInput'];
        $skills = $_POST['createSkillsInput'];


        // SQL statement
        $sql = "INSERT INTO station_members (first_name, last_name, province, postalcode, pronouns, address, city, email, primary_phone, alt_phone, interests, skills)
                VALUES (:first_name, :last_name, :province, :postalcode, :pronouns, :address, :city, :email, :primary_phone, :alt_phone, :interests, :skills)";

        // Prepare and execute SQL statement
        $statement = $connection->prepare($sql);
        $statement->bindValue(':first_name', $firstName);
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
header('location: host.php#createUserTab');
echo '<script>alert("New user has been created")</script>' ;
?>