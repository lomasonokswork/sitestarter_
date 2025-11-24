<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile</title>
  <link rel="stylesheet" href="style/base_profile.css" />
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
        <a class="link" href="resources.php">Resources</a>
        <a class="link" href="catalog.php">Catalog</a>
        <a class="link" href="saved.php">Saved</a>
      </div>
      <div class="nav_right">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <a class="link" href="login.php">
            <i class="fas fa-user"></i> Login
          </a>
        <?php else: ?>
          <a class="link" href="profile.php"><i class="fas fa-user">&nbsp</i><?php echo $_SESSION['username']; ?></a>
        <?php endif; ?>
        <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
          <span class="knob"></span>
        </button>
      </div>
    </div>
    <div class="profile">
      <p>Welcome to your profile, <?php echo $_SESSION['username']; ?></p>
      <button class="logout-btn" onclick="window.location.href='logout.php'">
        Log Out <i class="fas fa-arrow-right"></i>
      </button>
      <form method="POST" action="delete.php">
        <button class="delete-btn" type="submit" onclick="return confirm('Are you sure? This cannot be undone!');">
          Delete Account
        </button>
      </form>
    </div>
  </div>
</body>

</html>