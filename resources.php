<?php
session_start();

$json = file_get_contents("data/resources.json");
$data = json_decode($json, true);
$resources = $data['resources'];

$fonts = $resources['fonts'];
$color_schemes = $resources['color_schemes'];
$icons = $resources['icons'];
$images = $resources['images'];

if (isset($_POST['resource_type'])) {
  $_SESSION['resource_type'] = $_POST['resource_type'];
}
else {
  if (!isset($_SESSION['resource_type'])) {
    $_SESSION['resource_type'] = 1;
  }
}
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
          <a class="link" href="index.php">SiteStarter</a>
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
            <a class="link" href="profile.php"><i class="fas fa-user"></i><?php if (isset($_SESSION['username'])) { echo "Profile"; }; ?></a>
            <?php endif; ?>
          <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
            <span class="knob"></span>
          </button>
        </div>
      </div>
    <div class="resources">
      <div class="sidebar">
        <form method="POST">
          <button name="resource_type" value="1" class="sidebar-item <?php if ($_SESSION['resource_type'] == 1){ echo ' active';}?>">Fonts</button>
          <button name="resource_type" value="2" class="sidebar-item <?php if ($_SESSION['resource_type'] == 2){ echo ' active';}?>">Color Schemes</button>
          <button name="resource_type" value="3" class="sidebar-item <?php if ($_SESSION['resource_type'] == 3){ echo ' active';}?>">Images</button>
          <button name="resource_type" value="4" class="sidebar-item <?php if ($_SESSION['resource_type'] == 4){ echo ' active';}?>">Icons</button>
        </form>
      </div>
    <div class="resources-main">
  <?php if ($_SESSION['resource_type'] == 1) { ?>
    <div class="info-box">
      <strong>How to use:</strong> Add @import url("URL") at the top of your CSS file, then use the font-family property in your styles.
    </div>

    <div class="font-items">
      <?php foreach ($fonts as $font) { ?>
        <div class="font-item">
          <h3 class="font-title"><?php echo $font['name']; ?></h3>
          <p class="font-description" style="font-family: <?php echo $font['stylename']; ?>">
            <?php echo $font['text']; ?>
          </p>
          <button class="copy-btn" data-url="<?php echo $font['url']; ?>">
            <i class="fas fa-link"></i> Copy URL
          </button>
          <button class="copy-btn" data-font="<?php echo $font['stylename']; ?>">
            <i class="fas fa-font"></i> Copy Font-Family
          </button>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

  <?php if ($_SESSION['resource_type'] == 2) { ?>

    <div class="font-items">
      <?php foreach ($color_schemes as $color_scheme) { ?>
        <div class="font-item" style="background-color: <?php echo $color_scheme['colors']['background']?>">
          <h3 class="color-title" style="color: <?php echo $color_scheme['colors']['text']; ?>"><?php echo $color_scheme['name']; ?></h3>
          <p class="font-description" style="color: <?php echo $color_scheme['colors']['primary']; ?>">
            <?php echo $color_scheme['text']; ?>
          </p>
          <p class="font-description" style="color: <?php echo $color_scheme['colors']['secondary']; ?>">
            Description: <?php echo $color_scheme['colors']['primary']; ?><br> This text: <?php echo $color_scheme['colors']['secondary']; ?><br>
            Background: <?php echo $color_scheme['colors']['background']; ?> <br> Title: <?php echo $color_scheme['colors']['text']; ?>
          </p>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

  <?php if ($_SESSION['resource_type'] == 3) { ?>
    <div class="info-box">
      Places where you can find good quality stock images.
    </div>

    <div class="font-items">
      <?php foreach ($images as $image) { ?>
        <div class="font-item">
          <h3 class="font-title"><?php echo $image['name']; ?></h3>
          <p class="font-description">
            <?php echo $image['text']; ?>
          </p>
          <button class="copy-btn">
            <a href="<?php echo $image['url']?>">Take me there</a>
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      <?php } ?>
    </div>
  <?php } ?>

  <?php if ($_SESSION['resource_type'] == 4) { ?>
    <div class="info-box">
      Places where you can find good quality icons for your website.
    </div>

    <div class="font-items">
      <?php foreach ($icons as $icon) { ?>
        <div class="font-item">
          <h3 class="font-title"><?php echo $icon['name']; ?></h3>
          <p class="font-description">
            <?php echo $icon['text']; ?>
            
          </p>
          <button class="copy-btn">
            <a href="<?php echo $icon['url']?>">Take me there</a>
            <i class="fas fa-arrow-right"></i>
          </button>
        </div>
      <?php } ?>
    </div>
  <?php } ?>
</div>
</div>
</div>
</div>

</body>

</html>