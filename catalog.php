<?php
$json = file_get_contents("data/ideas.json");
$data = json_decode($json, true);
$projects = $data['projects'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Catalog</title>
  <link rel="stylesheet" href="style/base_catalog.css" />
  <link rel="stylesheet" href="style/switch.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <script src="node.js" defer></script>
</head>

<body>
  <div class="main">
    <div class="navbar">
      <div class="nav_left">
        <a class="link" href="home.html">SiteStarter</a>
      </div>
      <div class="nav_mid">
        <a class="link" href="discover.html">Discover</a>
        <a class="link active" href="catalog.html">Catalog</a>
        <a class="link" href="saved.html">Saved</a>
      </div>
      <div class="nav_right">
        <a class="link" href="login.html"><i class="fas fa-user"></i> Login</a>
        <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
          <span class="knob"></span>
        </button>
      </div>
    </div>
    <div class="catalog">
      <div class="catalog-projects">
        <?php
        foreach ($projects as $project) {
          echo "<div class='catalog-title'>Project Name: {$project['name']}</div>";
          echo "<div class='catalog-description'>Description: {$project['description']}</div>";
          echo '<div class="catalog-steps">Steps: ' . '<br>' . implode("<br>", $project['steps']) . "</div>";
          echo '<div class="catalog-tags">Tags: ' . implode(", ", $project['tags']) . '</div>';
          echo '<div class="catalog-languages">Languages: ' . implode(", ", $project['lang']) . "</div><br>";

          for ($i = 0; $i < count($project['links']); $i++) {
            echo "<a class='btn' href='{$project['links'][$i]}'>{$project['linkNames'][$i]}</a><br><br>";
          }
          echo "<hr>";
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>