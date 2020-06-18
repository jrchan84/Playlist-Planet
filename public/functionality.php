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
      <nav role="navigation" class="nav-menu w-nav-menu"><a href="host.php" class="nav-link w-nav-link">hosts</a><a href="shows.php" class="nav-link w-nav-link">Shows</a><a href="episodes.php" class="nav-link w-nav-link">Episodes</a><a href="media.php" class="nav-link w-nav-link">Media</a><a href="artists.php" class="nav-link w-nav-link">Artists</a><a href="libraries.php" class="nav-link w-nav-link">Libraries</a><a href="studios.php" class="nav-link w-nav-link">Studios</a><a href="audit.php" class="nav-link w-nav-link">Audit</a><a href="functionality.php" aria-current="page" class="nav-link w-nav-link w--current">Other Tools</a></nav>
    </div>
  </div>
  <div class="div-block">
    <div data-duration-in="300" data-duration-out="100" class="tabs w-tabs">
      <div class="tabs-menu w-tab-menu">
        <a data-w-tab="tab-1" class="tab-link-education w-inline-block w-tab-link w--current">
          <div class="text-block-3">Episodes in Every Show</div>
        </a>
        <a data-w-tab="tab-2" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Episodes in _ Shows</div>
        </a>
        <a data-w-tab="tab-3" class="tab-link-education w-inline-block w-tab-link w--current">
          <div class="text-block-3"># of Members in a Collective</div>
        </a>
      </div>
      <div class="tabs-content w-tab-content">
        <div data-w-tab="tab-1" class="tab-pane-education w-tab-pane w--tab-active">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
                <label>Search by Episode ID if episode is in ALL shows.</label>
                <input type="text" class="w-input" name="episodeDivision" required="">
                <input type="submit" name="divisionSubmit" value="View Results" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
            <?php
                if (isset($_POST['divisionSubmit'])) {
                    $sql = "SELECT E.episode_id, E.title
                                    FROM episodes E
                                    WHERE E.episode_id = :episode_id AND NOT EXISTS
                                        (SELECT *
                                        FROM shows S
                                        WHERE NOT EXISTS
                                            (SELECT X.episode_id
                                            FROM show_has_episode X
                                            WHERE E.episode_id = X.episode_id AND S.show_id = X.show_id))";

                    $episode = $_POST['episodeDivision'];

                    // Prepare and execute SQL statement
                    $statement = $connection->prepare($sql);
                    $statement->bindValue(':episode_id', $episode, PDO::PARAM_STR);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_CLASS);
                }

                if (isset($_POST['divisionSubmit']) && $result) {
                    ?><hr /><h2>Search Results</h2><?php
                    echo "Episode ";
                    foreach($result as $row){
                        print $row->episode_id;
                        print ", ";
                        print $row->title;
                    }
                    echo " is in every show";
                } else if (isset($_POST['divisionSubmit'])) {
                    ?><hr /><h2>Search Results</h2><?php
                    echo "Episode ";
                    echo $_POST["episodeDivision"];
                    echo " is NOT in every show";
                }
            ?>
          </div>
        </div>
        <div data-w-tab="tab-2" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
                <label>Search episodes in _ shows.</label>
                <input type="text" class="w-input" name="episodeNestAgg" required="">
                <input type="submit" name="nestedAggSubmit" value="View Results" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
            <?php
                if (isset($_POST['nestedAggSubmit'])) {
                    $sql = "SELECT episode_id, COUNT(show_id) AS count
                                    FROM show_has_episode
                                    GROUP BY episode_id
                                    HAVING COUNT(show_id) > :num";

                    $num = $_POST['episodeNestAgg'];

                    // Prepare and execute SQL statement
                    $statement = $connection->prepare($sql);
                    $statement->bindValue(':num', $num, PDO::PARAM_INT);
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_CLASS);
                }

                // Displays host_id of host who has hosted every episode if found
                if (isset($_POST['nestedAggSubmit']) && $result) {
                    ?><hr /><h2>Results</h2><?php
                    echo "Episodes ";
                    foreach($result as $row){
                        print $row->episode_id;
                        print " (";
                        print $row->count;
                        print ")";
                        print ", ";
                    }
                    echo " are in $num or more shows.";
                } else if (isset($_POST['nestedAggSubmit'])) {
                    ?><hr /><h2>Results</h2><?php
                    echo "No episodes are in $num or more shows";
                }
            ?>
          </div>
        </div>
        <div data-w-tab="tab-3" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
                <label>Choose a collective to see number of members.</label>
                <select id="field" name="aggSelect" class="w-select">
                <?php
                      $sql = "SELECT name FROM collectives";
                      $statement = $connection->prepare($sql);
                      $statement->execute();
                      $result = $statement->fetchALL(PDO::FETCH_ASSOC);
                      foreach($result as $row) {
                      echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                      }
                  ?>
                </select>
                <input type="submit" name="aggSubmit" value="View Results" class="submit-button w-button">
            </form>
          </div>
          <div class="contentdiv">
              <?php
                  if (isset($_POST['aggSubmit'])) {
                      $sql = "SELECT COUNT(*) AS no_of_members, c.name
                              FROM members_are_part_of_collectives AS m, collectives AS c
                              WHERE c.host_id = m.collective_id AND c.name = :collective_name
                              GROUP BY c.name, c.host_id";

                      // store collective_name variable
                      $collective_name = isset($_POST['aggSelect']) ? $_POST['aggSelect'] : false;

                      // Prepare, bind and execute SQL statement
                      $statement = $connection->prepare($sql);
                      $statement->bindParam(':collective_name', $collective_name, PDO::PARAM_STR);
                      $statement->execute();
                      // Fetch Result
                      $result = $statement->fetchAll();
                  }

                  if (isset($_POST['aggSubmit'])) {
                          // Check to see if there is a non-empty set of results
                          if ($result && $statement->rowCount() > 0) { ?>
                              <hr />
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
                              <?php echo escape($_POST['aggSelect']); ?>.

                          <?php } else { ?>
                              <hr />
                              <h2>Search Results</h2>
                                  There are 0 members in the <?php echo escape($_POST['aggSelect']); ?>.
                          <?php }
                      }
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
