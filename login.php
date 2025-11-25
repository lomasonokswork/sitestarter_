<?php
session_start();
include 'config.php';

$errors = [];
if (isset($_POST['signup']) && $_POST['signup'] == 1) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $verify = $_POST['verify'] ?? '';

if ($username === '') $errors[] = "Enter a username.";
if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters long.";
if ($password !== $verify) $errors[] = "Passwords do not match.";

if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
if ($stmt->num_rows > 0) {
            $errors[] = "Username already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username,password_hash) VALUES (?,?)");
            $stmt->bind_param("ss", $username, $hash);
            if ($stmt->execute()) {
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit;
            } else {
                $errors[] = "DB error: ".$conn->error;
            }
        }
    }
}
}
if (isset($_POST['login']) && $_POST['login'] == 2) {
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username=? LIMIT 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $username, $hash);
        if ($stmt->fetch()) {
            if (password_verify($password, $hash)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                header("Location: home.php");
                exit;
            } else {
                $errors[] = "Wrong credentials.";
            }
        } else {
            $errors[] = "Wrong credentials.";
        }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log in</title>
    <link rel="stylesheet" href="style/switch.css" />
    <link rel="stylesheet" href="style/base_login.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
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
            <a class="link" href="profile.php"><i class="fas fa-user">&nbsp</i><?php echo $_SESSION['username'];?><a>
            <?php endif; ?>
          <button id="theme-toggle" class="toggle-btn" aria-pressed="false">
            <span class="knob"></span>
          </button>
        </div>
      </div>
      <div class="login">
        <div class="login_L">
          <div class="login_h1">Sign Up</div>

          <form method="POST" class="form signup-form" novalidate>
            <div class="form-group">
              <label for="signup-username">Username</label>
              <input
                id="signup-username"
                name="username"
                type="text"
                autocomplete="username"
                required
              />
            </div>

            <div class="form-group">
              <label for="signup-password">Password</label>
              <input
                id="signup-password"
                name="password"
                type="password"
                autocomplete="new-password"
                required
              />
            </div>

            <div class="form-group">
              <label for="signup-verify">Verify Password</label>
              <input
                id="signup-verify"
                name="verify"
                type="password"
                autocomplete="new-password"
                required
              />
            </div>
            <?php foreach($errors as $e) echo "<p style='color:red;'>".htmlspecialchars($e)."</p>"; ?>
            <div class="form-actions">
              <button type="submit" name="signup" class="btn" value="1">Create account</button>
            </div>
          </form>
        </div>
        <div class="login_R">
          <div class="login_h1">Log In</div>
          <form method="POST" class="form login-form" novalidate>
            <div class="form-group">
              <label for="login-username">Username</label>
              <input
                id="login-username"
                name="username"
                type="text"
                autocomplete="username"
                required
              />
            </div>

            <div class="form-group">
              <label for="login-password">Password</label>
              <input
                id="login-password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
              />
            </div>
            <?php foreach($errors as $e) echo "<p style='color:red;'>".htmlspecialchars($e)."</p>";?>
            <div class="form-actions">
              <button type="submit" name="login" class="btn" value="2">Log in</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>