<?php
session_start();

function getSavedProjects($userId)
{
  if (!$userId)
    return [];

  $saveFile = "saves/user_{$userId}.json";
  if (file_exists($saveFile)) {
    return json_decode(file_get_contents($saveFile), true) ?? [];
  }
  return [];
}

$savedProjects = getSavedProjects($_SESSION['user_id'] ?? null);

$json = file_get_contents("data/ideas.json");
$data = json_decode($json, true);
$projects = $data['projects'];

$filterType = isset($_GET['type']) ? $_GET['type'] : '';
$filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
$filterFeature = isset($_GET['feature']) ? $_GET['feature'] : '';
$filterDifficulty = isset($_GET['difficulty']) ? $_GET['difficulty'] : '';

$filteredProjects = [];
foreach ($projects as $project) {
  $show = true;

  if ($filterType != '' && isset($project['type']) && $project['type'] != $filterType) {
    $show = false;
  }

  if ($filterCategory != '' && isset($project['category']) && $project['category'] != $filterCategory) {
    $show = false;
  }

  if ($filterFeature != '' && isset($project['features'])) {
    if (!in_array($filterFeature, $project['features'])) {
      $show = false;
    }
  }

  if ($filterDifficulty != '' && isset($project['difficulty']) && $project['difficulty'] != $filterDifficulty) {
    $show = false;
  }

  if ($show) {
    $filteredProjects[] = $project;
  }
}
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
  <link rel="stylesheet" href="style/expand.css" />
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
          <a class="link" href="resources.php">Resources</a>
          <a class="link active" href="catalog.php">Catalog</a>
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
    <div class="catalog">
      <div class="filters">
        <form method="GET" action="catalog.php">

          <div class="filter-section">
            <h3 class="filter-title">
              Type <button class="expand-button collapsed" aria-label="Expand">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15" />
                </svg>
              </button>
            </h3>
            <div class="filter-options collapsed">
              <div class="filter-option">
                <input type="radio" id="type-all" name="type" value="" <?php if ($filterType == '')
                  echo 'checked'; ?>>
                <label for="type-all">All</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="type-frontend" name="type" value="Frontend" <?php if ($filterType == 'Frontend')
                  echo 'checked'; ?>>
                <label for="type-frontend">Frontend</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="type-fullstack" name="type" value="Fullstack" <?php if ($filterType == 'Fullstack')
                  echo 'checked'; ?>>
                <label for="type-fullstack">Fullstack</label>
              </div>
            </div>
          </div>

          <div class="filter-section">
            <h3 class="filter-title">
              Features <button class="expand-button collapsed" aria-label="Expand">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15" />
                </svg>
            </h3>
            <div class="filter-options collapsed">
              <div class="filter-option">
                <input type="radio" id="feature-all" name="feature" value="" <?php if ($filterFeature == '')
                  echo 'checked'; ?>>
                <label for="feature-all">All</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-api" name="feature" value="API" <?php if ($filterFeature == 'API')
                  echo 'checked'; ?>>
                <label for="feature-api">API</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-database" name="feature" value="Database" <?php if ($filterFeature == 'Database')
                  echo 'checked'; ?>>
                <label for="feature-database">Database</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-auth" name="feature" value="Authentication" <?php if ($filterFeature == 'Authentication')
                  echo 'checked'; ?>>
                <label for="feature-auth">Authentication</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-payment" name="feature" value="Payment" <?php if ($filterFeature == 'Payment')
                  echo 'checked'; ?>>
                <label for="feature-payment">Payment</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-realtime" name="feature" value="Real-time" <?php if ($filterFeature == 'Real-time')
                  echo 'checked'; ?>>
                <label for="feature-realtime">Real-time</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="feature-analytics" name="feature" value="Analytics" <?php if ($filterFeature == 'Analytics')
                  echo 'checked'; ?>>
                <label for="feature-analytics">Analytics</label>
              </div>
            </div>
          </div>

          <div class="filter-section">
            <h3 class="filter-title">
              Category <button class="expand-button collapsed" aria-label="Expand">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15" />
                </svg>
            </h3>
            <div class="filter-options collapsed">
              <div class="filter-option">
                <input type="radio" id="category-all" name="category" value="" <?php if ($filterCategory == '')
                  echo 'checked'; ?>>
                <label for="category-all">All</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-personal" name="category" value="Personal" <?php if ($filterCategory == 'Personal')
                  echo 'checked'; ?>>
                <label for="category-personal">Personal</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-creative" name="category" value="Creative" <?php if ($filterCategory == 'Creative')
                  echo 'checked'; ?>>
                <label for="category-creative">Creative</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-productivity" name="category" value="Productivity" <?php if ($filterCategory == 'Productivity')
                  echo 'checked'; ?>>
                <label for="category-productivity">Productivity</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-ecommerce" name="category" value="E-commerce" <?php if ($filterCategory == 'E-commerce')
                  echo 'checked'; ?>>
                <label for="category-ecommerce">E-commerce</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-lifestyle" name="category" value="Lifestyle" <?php if ($filterCategory == 'Lifestyle')
                  echo 'checked'; ?>>
                <label for="category-lifestyle">Lifestyle</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-health" name="category" value="Health" <?php if ($filterCategory == 'Health')
                  echo 'checked'; ?>>
                <label for="category-health">Health</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-education" name="category" value="Education" <?php if ($filterCategory == 'Education')
                  echo 'checked'; ?>>
                <label for="category-education">Education</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-finance" name="category" value="Finance" <?php if ($filterCategory == 'Finance')
                  echo 'checked'; ?>>
                <label for="category-finance">Finance</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="category-entertainment" name="category" value="Entertainment" <?php if ($filterCategory == 'Entertainment')
                  echo 'checked'; ?>>
                <label for="category-entertainment">Entertainment</label>
              </div>
            </div>
          </div>

          <div class="filter-section">
            <h3 class="filter-title">
              Difficulty <button class="expand-button collapsed" aria-label="Expand">
                <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="18 15 12 9 6 15" />
                </svg>
            </h3>
            <div class="filter-options collapsed">
              <div class="filter-option">
                <input type="radio" id="difficulty-all" name="difficulty" value="" <?php if ($filterDifficulty == '')
                  echo 'checked'; ?>>
                <label for="difficulty-all">All</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="difficulty-beginner" name="difficulty" value="Beginner" <?php if ($filterDifficulty == 'Beginner')
                  echo 'checked'; ?>>
                <label for="difficulty-beginner">Beginner</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="difficulty-intermediate" name="difficulty" value="Intermediate" <?php if ($filterDifficulty == 'Intermediate')
                  echo 'checked'; ?>>
                <label for="difficulty-intermediate">Intermediate</label>
              </div>
              <div class="filter-option">
                <input type="radio" id="difficulty-advanced" name="difficulty" value="Advanced" <?php if ($filterDifficulty == 'Advanced')
                  echo 'checked'; ?>>
                <label for="difficulty-advanced">Advanced</label>
              </div>
            </div>
          </div>

          <div class="filter-actions">
            <button class="filter-btn apply-btn">Apply</button>
            <a href="catalog.php" class="filter-btn clear-btn">Clear</a>
          </div>
        </form>
      </div>
      <div class="catalog-projects">
        <?php
        if (count($filteredProjects) > 0) {
          foreach ($filteredProjects as $project) {
            $isSaved = in_array($project['name'], $savedProjects);
            $saveIcon = $isSaved ? 'fas fa-bookmark' : 'far fa-bookmark';

            echo "<div class='project'>";

            echo "<button class='save-btn' data-project='{$project['name']}' data-saved='" . ($isSaved ? 'true' : 'false') . "'>";
            echo "<i class='{$saveIcon}'></i>";
            echo "</button>";

            echo "<div class='name'>{$project['name']}</div>";
            echo "<div class='description'><div class='desc'>Description: <br></div>{$project['description']}</div>";
            echo '<div class="tags"><div class="tag">Tags: <br></div>' . implode(", ", $project['tags']) . '</div>';
            echo '<div class="languages"><div class="lang">Languages: <br></div>' . implode(", ", $project['lang']) . "</div>";
            echo "<div class='difficulty'><div class='diff'>Difficulty: </div>{$project['difficulty']}</div>";

            for ($i = 0; $i < count($project['links']); $i++) {
              echo "<a class='btn' href='{$project['links'][$i]}'>{$project['linkNames'][$i]}</a>";
            }
            echo "</div>";
          }
        } else {
          echo "<div class='no-results'>";
          echo "<i class='fas fa-search' style='font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;'></i><br>";
          echo "No projects found. Try different filters.";
          echo "</div>";
        }
        ?>
      </div>
    </div>
  </div>
</body>

</html>