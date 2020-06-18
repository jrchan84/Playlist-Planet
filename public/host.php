<?php
    require "../config.php";
    require "../common.php";

    try {
      $connection = new PDO($dsn, $username, $password, $options);
    } catch (PDOException $error) {
      echo 'Cannot connect';
      die;
    }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>PlaylistPlanet</title>
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <link href="images/favicon.jpg" rel="shortcut icon" type="image/x-icon">
  <link href="images/webclip.jpg" rel="apple-touch-icon">
</head>
<body class="subpage-background">
  <div data-collapse="medium" data-animation="default" data-duration="400" role="banner" class="nav-bar w-nav">
    <div class="container w-container"><a href="index.php" class="brand-link w-nav-brand"><img src="images/playlistPlanetStandaloneLogo.png" width="52" srcset="images/playlistPlanetStandaloneLogo-p-500.png 500w, images/playlistPlanetStandaloneLogo.png 800w" sizes="52px" alt="" class="logo"></a>
      <nav role="navigation" class="nav-menu w-nav-menu"><a href="host.php" aria-current="page" class="nav-link w-nav-link w--current">hosts</a><a href="shows.php" class="nav-link w-nav-link">Shows</a><a href="episodes.php" class="nav-link w-nav-link">Episodes</a><a href="media.php" class="nav-link w-nav-link">Media</a><a href="artists.php" class="nav-link w-nav-link">Artists</a><a href="libraries.php" class="nav-link w-nav-link">Libraries</a><a href="studios.php" class="nav-link w-nav-link">Studios</a><a href="audit.php" class="nav-link w-nav-link">Audit</a><a href="functionality.php" class="nav-link w-nav-link">Other Tools</a></nav>
    </div>
  </div>
  <div class="div-block">
    <div data-duration-in="300" data-duration-out="100" class="tabs w-tabs">
      <div class="tabs-menu w-tab-menu">
        <a data-w-tab="tab-1" class="tab-link-education w-inline-block w-tab-link">
          <div data-w-id="1500da78-712a-0c21-26bb-da34fa782cb0" class="text-block-3">Create New User</div>
        </a>
        <a data-w-tab="tab-2" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Update User Info</div>
        </a>
        <a data-w-tab="tab-3" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Search Users</div>
        </a>
        <a data-w-tab="tab-4" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Remove User</div>
        </a>
        <a data-w-tab="tab-5" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Find Users Information</div>
        </a>
      </div>
      <div class="tabs-content w-tab-content">
        <div id="createUserTab" data-w-tab="tab-1" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="createstationmember.php" method="POST">
                <label>First Name</label>
                <input type="text" class="text-field w-input" name="createFirstNameInput" required="">
                <label>Last Name</label>
                <input type="text" class="text-field w-input" name="createLastNameInput" required="">
                <label>Province</label>
                <input type="text" class="w-input" name="createProvinceInput" required="">
                <label>Postal Code</label>
                <input type="text" class="w-input" name="createPostalCodeInput" required="">
                <label>Pronouns</label>
                <input type="text" class="w-input" name="createPronounsInput" required="">
                <label>Address</label>
                <input type="text" class="w-input" name="createAddressInput" required="">
                <label>City</label>
                <input type="text" class="w-input" name="createCityInput" required="">
                <label>Email</label>
                <input type="email" class="w-input" name="createEmailInput" required="">
                <label>Primary Phone</label>
                <input type="text" class="w-input" name="createPrimaryPhoneInput" required="">
                <label>Alt. Phone</label>
                <input type="text" class="w-input" name="createAltPhoneInput">
                <label>Interests</label>
                <input type="text" class="w-input" name="createInterestsInput">
                <label>Skills</label>
                <input type="text" class="w-input" name="createSkillsInput">
                <br>
                <input type="submit" name="createSubmit" data-wait="Please wait..." class="submit-button w-button">
            </form>
          </div>
        </div>
        <div id=updateUserTab data-w-tab="tab-2" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
              <label>Select a user to update</label>
              <select id="updateUserSelect" name="updateUserSelect" required="" class="select-field w-select">
                  <?php
                      $sql = "SELECT host_id, first_name FROM station_members ORDER BY host_id";
                      $statement = $connection->prepare($sql);
                      $statement->execute();
                      $result = $statement->fetchALL(PDO::FETCH_ASSOC);
                      foreach($result as $row) {
                      echo '<option value="'.$row['host_id'].'">'.$row['first_name']." | Host ID: ".$row['host_id'].'</option>';
                      }
                  ?>
              </select>
              <input type="submit" value="Select" name="updateUserSelectSubmit" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
              <?php
              if (isset($_POST['updateUserSelect'])) {
                  $id = $_POST["updateUserSelect"];
                  $sql = "SELECT * FROM station_members WHERE host_id = :host_id";
                  $statement = $connection->prepare($sql);
                  $statement->bindValue(':host_id', $id);
                  $statement->execute();
                  $result = $statement->fetchALL(PDO::FETCH_ASSOC);

                  echo "<table border='1'>
                  <tr>
                  <th>host_id</th>
                  <th>first_name</th>
                  <th>last_name</th>
                  <th>province</th>
                  <th>postalcode</th>
                  <th>pronouns</th>
                  <th>address</th>
                  <th>city</th>
                  <th>email</th>
                  <th>primary_phone</th>
                  <th>alt_phone</th>
                  <th>interests</th>
                  <th>skills</th>
                  </tr>";

                  foreach($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['host_id'] . "</td>";
                    echo "<td>" . $row['first_name'] . "</td>";
                    echo "<td>" . $row['last_name'] . "</td>";
                    echo "<td>" . $row['province'] . "</td>";
                    echo "<td>" . $row['postalcode'] . "</td>";
                    echo "<td>" . $row['pronouns'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['primary_phone'] . "</td>";
                    echo "<td>" . $row['alt_phone'] . "</td>";
                    echo "<td>" . $row['interests'] . "</td>";
                    echo "<td>" . $row['skills'] . "</td>";
                    echo "</tr>";
                  }

                  echo "</table>";
              }
              ?>
          </div>
          <div class="form-block w-form">
            <form class="form" action="updatestationmember.php" method="POST">
                <label for="updateHostInput">Host Id - KEEP THE SAME</label>
                <input type="text" class="text-field w-input" name="updateHostInput" required="">
                <label for="updateFirstNameInput">First Name</label>
                <input type="text" class="text-field w-input" name="updateFirstNameInput" required="">
                <label for="updateLastNameInput">Last Name</label>
                <input type="text" class="text-field w-input" name="updateLastNameInput" required="">
                <label for="updateProvinceInput">Province</label>
                <input type="text" class="w-input" name="updateProvinceInput" required="">
                <label for="updatePostalInput">Postal Code</label>
                <input type="text" class="w-input" name="updatePostalInput" required="">
                <label for="updatePronounsInput">Pronouns</label>
                <input type="text" class="w-input" name="updatePronounsInput" required="">
                <label for="updateAddressInput">Address</label>
                <input type="text" class="w-input" name="updateAddressInput" required="">
                <label for="updateCityInput">City</label>
                <input type="text" class="w-input" name="updateCityInput" required="">
                <label for="updateEmailInput">Email</label>
                <input type="email" class="w-input" name="updateEmailInput" required="">
                <label for="updatePrimaryPhoneInput">Primary Phone</label>
                <input type="text" class="w-input" name="updatePrimaryPhoneInput" required="">
                <label for="updateAltPhoneInput">Alt. Phone</label>
                <input type="text" class="w-input" name="updateAltPhoneInput">
                <label for="updateInterestsInput">Interests</label>
                <input type="text" class="w-input" name="updateInterestsInput">
                <label for="updateSkillsInput">Skills</label>
                <input type="text" class="w-input"  name="updateSkillsInput">
                <br>
                <input type="submit" name="updateUserSubmit" value="Update" class="submit-button w-button">
            </form>
          </div>
        </div>
        <div data-w-tab="tab-3" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
                <label>Select fields to view</label>
                <br>
                <input type='checkbox' name='fields[]' value='first_name'>First Name<br>
                <input type='checkbox' name='fields[]' value='last_name'>Last Name<br>
                <input type='checkbox' name='fields[]' value='province'>Province<br>
                <input type='checkbox' name='fields[]' value='postalcode'>Postal Code<br>
                <input type='checkbox' name='fields[]' value='pronouns'>Pronouns<br>
                <input type='checkbox' name='fields[]' value='address'>Address<br>
                <input type='checkbox' name='fields[]' value='city'>City<br>
                <input type='checkbox' name='fields[]' value='email'>Email<br>
                <input type='checkbox' name='fields[]' value='primary_phone'>Primary Phone<br>
                <input type='checkbox' name='fields[]' value='alt_phone'>Alternate Phone<br>
                <input type='checkbox' name='fields[]' value='interests'>Interests<br>
                <input type='checkbox' name='fields[]' value='skills'>Skills<br>
                <br/>
                <label>Search by First Name</label>
                <input type="text" class="text-field w-input" name="searchUserInput" required="">
                <input type="submit" name="searchSubmit" value="View Results" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
              <?php
                  if(isset($_POST['searchSubmit'])){
                    $first_name = $_POST['searchUserInput'];
                    if(isset($_POST['fields'])){
                        $field = $_POST['fields'];
                    }
                    if (isset($_POST['fields'])) {
                        $sql = "SELECT " . implode(',', $_POST['fields']) .
                                " FROM station_members
                                WHERE first_name = :first_name";
                    } else {
                        $sql = "SELECT *
                                FROM station_members
                                WHERE first_name = :first_name";
                    }
                    $statement = $connection->prepare($sql);
                    $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
                    $statement->execute();
                    $result = $statement->fetchAll();
                  }


                  if (isset($_POST['searchSubmit'])) {
                      if ($result && $statement->rowCount() > 0) { ?>
                          <hr />
                          <h2>Search Results</h2>

                          <table>
                              <thead>
                                  <tr>
                                      <?php if (isset($_POST['fields'])) {
                                          $fields = $_POST['fields'];
                                          foreach ($fields as $field) { ?>
                                              <th><?php echo $field?></th>
                                      <?php }
                                          } else { ?>
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
                                      <?php } ?>
                                  </tr>
                              </thead>
                              <tbody>
                                  <?php foreach ($result as $row) { ?>
                                  <tr>
                                      <?php if (isset($_POST['fields'])) {
                                          foreach ($fields as $field) { ?>
                                              <td><?php echo escape($row["$field"]); ?></td>
                                      <?php }
                                          } else { ?>
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
                                      <?php } ?>
                                  </tr>
                                  <?php } ?>
                              </tbody>
                          </table>
                      <?php } else { ?>
                              No results found for <?php echo escape($_POST['first_name']); ?>.
                      <?php }
                  } ?>
          </div>
        </div>
        <div id="deleteUserTab" data-w-tab="tab-4" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="deletestationmembers.php" method="POST">
              <label>Select User to Delete</label>
              <select name="removeUserSelect" required="" class="select-field w-select">
                <?php
                  $sql = "SELECT host_id, first_name FROM station_members ORDER BY host_id";
                  $statement = $connection->prepare($sql);
                  $statement->execute();
                  $result = $statement->fetchALL(PDO::FETCH_ASSOC);
                  foreach($result as $row) {
                    echo '<option value="'.$row['host_id'].'">'.$row['first_name']." | Host ID: ".$row['host_id'].'</option>';
                  }
                ?>
              </select>
              <input type="submit" name="submitDelete" value="Delete" class="submit-button w-button">
            </form>
          </div>
        </div>
        <div data-w-tab="tab-5" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
                <label>Search by User Fields</label>
                <input type='checkbox' name='fields[]' value='first_name'>First Name<br>
                <input type='checkbox' name='fields[]' value='last_name'>Last Name<br>
                <input type='checkbox' name='fields[]' value='province'>Province<br>
                <input type='checkbox' name='fields[]' value='postalcode'>Postal Code<br>
                <input type='checkbox' name='fields[]' value='pronouns'>Pronouns<br>
                <input type='checkbox' name='fields[]' value='address'>Address<br>
                <input type='checkbox' name='fields[]' value='city'>City<br>
                <input type='checkbox' name='fields[]' value='email'>Email<br>
                <input type='checkbox' name='fields[]' value='primary_phone'>Primary Phone<br>
                <input type='checkbox' name='fields[]' value='alt_phone'>Alternate Phone<br>
                <input type='checkbox' name='fields[]' value='interests'>Interests<br>
                <input type='checkbox' name='fields[]' value='skills'>Skills<br>
                <br>
                <input type="submit" name="projectSubmit" value="View Results" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
            <?php
                if (isset($_POST['projectSubmit'])) {
                    if (isset($_POST['fields'])) {
                        $field = $_POST['fields'];

                        $sql = "SELECT " . implode(',', $_POST['fields']) .
                                " FROM station_members";

                        $statement = $connection->prepare($sql);
                        $statement->execute();
                        $result = $statement->fetchAll();
                    }
                }

                if (isset($_POST['projectSubmit']) and isset($_POST['fields'])) {
                    // Check to see if there is a non-empty set of results
                    if ($result && $statement->rowCount() > 0) { ?>
                        <?php // Get posted value
                        $fields = $_POST['fields'];
                        ?>
                        <hr />
                        <h2>Information Results</h2>

                        <table>
                            <thead>
                                <tr>
                                    <?php foreach ($fields as $field) { ?>
                                        <th><?php echo $field?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $row) { ?>
                                <tr>
                                    <?php foreach ($fields as $field) { ?>
                                        <td><?php echo escape($row["$field"]); ?></td>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        Could not display the selected fields.
                    <?php }
                } else { ?>
                    No fields were selected.
                <?php }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="footer-flex-container">
      <h2 class="footer-heading">Created by Patrick Lee, Carol Zhang, Justin Chan | <a href="https://github.com/RedundantComputation/playlist-planet" target="_blank" class="link">Gitub Repo</a></h2>
    </div>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.4.1.min.220afd743d.js?site=5ee5e62f04a8815a44b1dce8" type="text/javascript" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
</body>
</html>
