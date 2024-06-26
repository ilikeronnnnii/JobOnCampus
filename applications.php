<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}

require_once "scripts/database.php";

// Fetch applications data for the logged-in user
$userID = $_SESSION['userID'];
$sql = "SELECT a.*, j.position, j.location, j.salary, j.deadline, f.facultyName
FROM application a
JOIN jobs j ON a.jobID = j.jobID
JOIN faculty f ON j.facultyID = f.facultyID
WHERE a.userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$applications = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $applications[] = $row;
  }
}

$numApplications = count($applications);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/applications.css" />
  <link rel="shortcut icon" type="x-icon" href="images/tab.png" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JobOnCampus</title>
</head>

<body>
  <header>
    <a href="home.php">
      <img class="logo" src="images/jobOnCampusBlack.png" alt="logo" /></a>
    <nav>
      <ul class="nav_links">
        <nav>
          <ul class="nav_links">
            <li><a href="careers.php">Careers</a></li>
            <?php if (isset($_SESSION['userID'])): ?>
              <li><a href="applications.php">Applications</a></li>
            <?php endif; ?>
            <li><a href="request.php">Job Requests</a></li>
          </ul>
        </nav>
      </ul>
    </nav>
    <?php if (isset($_SESSION['userID'])): ?>
      <a class="cta" href="scripts/logout.php"><button>Log Out</button></a>
    <?php else: ?>
      <a class="cta" href="index.php"><button>Log In</button></a>
    <?php endif; ?>
  </header>
  <section>
    <div class="applications-list-container">
      <h2><?php echo $numApplications; ?> Applications History</h2>
      <div class="applications">
        <?php foreach ($applications as $application): ?>
          <div class="application">
            <div class="job-header">
              <img src="images/<?php echo strtolower(str_replace(' ', '', $application['facultyName'])); ?>.png"
                alt="<?php echo htmlspecialchars($application['facultyName']); ?> Logo" class="company-logo" />
              <h3 class="job-title"><?php echo htmlspecialchars($application['position']); ?></h3>
              <div class="company-info">
                <p class="supervision">Supervised by Dr. Analiza</p>
              </div>
            </div>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with researching a couple of new ransomware.
            </div>
            <?php if ($application['status'] === 'accepted'): ?>
              <a href="#" class="details-btn">More Details</a>
            <?php endif; ?>
            <span class="application-status <?php echo htmlspecialchars($application['status']); ?>">
              <?php echo ucfirst(htmlspecialchars($application['status'])); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</body>

</html>