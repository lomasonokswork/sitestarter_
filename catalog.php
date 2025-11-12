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
  <title>Document</title>
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
        echo "<h2>Project Name: {$project['name']}</h2>";
        echo "<p>Description: {$project['description']}</p>";
        echo "<p>Steps: " . implode("<br>", $project['steps']) . "</p>";
        echo "<p>Tags: " . implode(", ", $project['tags']) . "</p>";
        echo "<p>Languages: " . implode(", ", $project['lang']) . "</p>";

        for ($i = 0; $i < count($project['links']); $i++) {
          echo "<a href='{$project['links'][$i]}'>{$project['linkNames'][$i]}</a><br>";
        }
        echo "<hr>";
      }
      ?>
      </div>
    </div>
  </div>
</body>

</html>