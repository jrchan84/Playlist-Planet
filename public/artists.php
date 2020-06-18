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
      <nav role="navigation" class="nav-menu w-nav-menu"><a href="host.php" class="nav-link w-nav-link">hosts</a><a href="shows.php" class="nav-link w-nav-link">Shows</a><a href="episodes.php" class="nav-link w-nav-link">Episodes</a><a href="media.php" class="nav-link w-nav-link">Media</a><a href="artists.php" aria-current="page" class="nav-link w-nav-link w--current">Artists</a><a href="libraries.php" class="nav-link w-nav-link">Libraries</a><a href="studios.php" class="nav-link w-nav-link">Studios</a><a href="audit.php" class="nav-link w-nav-link">Audit</a><a href="functionality.php" class="nav-link w-nav-link">Other Tools</a></nav>
    </div>
  </div>
  <div class="div-block">
    <div data-duration-in="300" data-duration-out="100" class="tabs w-tabs">
      <div class="tabs-menu w-tab-menu">
        <a data-w-tab="tab-1" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">View Artists</div>
        </a>
        <a data-w-tab="tab-2" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Add a New Artist</div>
        </a>
        <a data-w-tab="tab-3" class="tab-link-education w-inline-block w-tab-link">
          <div class="text-block-3">Remove Artists</div>
        </a>
        <a data-w-tab="tab-4" class="tab-link-education w-inline-block w-tab-link w--current">
          <div class="text-block-3">Search Album Artists</div>
        </a>
      </div>
      <div class="tabs-content w-tab-content">
        <div data-w-tab="tab-1" class="tab-pane-education w-tab-pane"></div>
        <div data-w-tab="tab-2" class="tab-pane-education w-tab-pane"></div>
        <div data-w-tab="tab-3" class="tab-pane-education w-tab-pane"></div>
        <div data-w-tab="tab-4" class="tab-pane-education w-tab-pane">
          <div class="form-block w-form">
            <form class="form" action="#" method="POST">
            <label>Search by Info</label>
            <input type="text" name="searchAlbumInput" class="w-select"></select>
            <input type="submit" name="artistSubmit" value="View Results" class="submit-button w-button"></form>
          </div>
          <div class="contentdiv">
            <?php
                if (isset($_POST['artistSubmit'])) {
                    // SQL read statement
                    $sql = "SELECT artists.artist_id, artists.name, performed_by.media_id, tracks.album, tracks.genre
                            FROM artists
                            JOIN performed_by ON artists.artist_id = performed_by.artist_id
                            JOIN tracks ON tracks.media_id = performed_by.media_id
                            WHERE
                                tracks.album = :album_name";

                    // Store album name variable
                    $album_name = $_POST['searchAlbumInput'];

                    // Prepare, bind and execute SQL statement
                    $statement = $connection->prepare($sql);
                    $statement->bindParam(':album_name', $album_name, PDO::PARAM_STR);
                    $statement->execute();

                    // Fetch result
                    $result = $statement->fetchAll();
                }

                if (isset($_POST['artistSubmit'])) {
                    if ($result && $statement->rowCount() > 0) { ?>
                        <hr />
                        <h2>Search Results</h2>

                        <table>
                            <thead>
                                <tr>
                                    <th>Artist ID</th>
                                    <th>Artist Name(s)</th>
                                    <th>Media ID</th>
                                    <th>Album Name</th>
                                    <th>Genre</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?php echo escape($row["artist_id"]); ?></td>
                                    <td><?php echo escape($row["name"]); ?></td>
                                    <td><?php echo escape($row["media_id"]); ?></td>
                                    <td><?php echo escape($row["album"]); ?></td>
                                    <td><?php echo escape($row["genre"]); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    <?php } else { ?>
                            No results found for <?php echo escape($_POST['album_name']); ?>.
                    <?php }
                } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <div class="footer-flex-container"><img src="images/playlistPlanetMusicLogo.png" width="37" alt="" class="footer-logo-link">
      <h2 class="footer-heading">Created by Patrick Lee, Carol Zhang, Justin Chan | <a href="https://github.com/RedundantComputation/playlist-planet" target="_blank" class="link">Gitub Repo</a></h2>
    </div>
  </div>
  <script src="https://d3e54v103j8qbb.cloudfront.net/js/jquery-3.4.1.min.220afd743d.js?site=5ee5e62f04a8815a44b1dce8" type="text/javascript" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="js/webflow.js" type="text/javascript"></script>
</body>
</html>
