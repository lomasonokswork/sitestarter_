<?php
session_start();

$json = file_get_contents("resources.json");
$data = json_decode($json, true);
$resources = $data['resources'];
$fonts = $data['resources']['fonts'];
$colors = $data['resources']['color_schemes'];
$images = $data['resources']['images'];
$icons = $data['resources']['icons'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Discover</title>
  <link rel="stylesheet" href="style/base_resources.css" />
  <link rel="stylesheet" href="style/switch.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="icon" type="image/x-icon" href="/img/image.png">
  <script src="node.js" defer></script>
</head>

<body>
  <div class="main">
    <div class="navbar">
      <div class="nav_left">
        <a class="link" href="home.php">SiteStarter</a>
      </div>
      <div class="nav_mid">
        <a class="link active" href="resources.php">Resources</a>
        <a class="link" href="catalog.php">Catalog</a>
        <a class="link" href="saved.php">Saved</a>
      </div>
      <div class="nav_right">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a class="link" href="login.php">
            <i class="fas fa-user"></i> Login
          </a>
        <?php else: ?>
          <a class="link" href="profile.php"><i class="fas fa-user">&nbsp</i><?php echo $_SESSION['username']; ?><a>
            <?php endif; ?>
            <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
              <span class="knob"></span>
            </button>
      </div>
    </div>
    <div class="resources">
      <div class="sidebar">
        <form method="GET">
          <button name="resource_type" value="1" class="sidebar-item">Fonts</button>
          <button name="resource_type" value="2" class="sidebar-item">Color Schemes</button>
          <button name="resource_type" value="3" class="sidebar-item">Images</button>
          <button name="resource_type" value="4" class="sidebar-item">Icons</button>
        </form>
      </div>
    </div>
    <div class="resources-main"></div>
  </div>
  </div>
</body>

</html>