<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}

require_once "scripts/database.php";

// Fetch applications data for the logged-in user
$userID = $_SESSION['userID'];
$sql = "SELECT a.*, j.position, j.location, j.salary, j.deadline 
        FROM application a
        JOIN jobs j ON a.jobID = j.jobID
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
    <img class="logo" src="images/jobOnCampusBlack.png" alt="logo" />
    <nav>
      <ul class="nav_links">
        <li><a href="careers.php">Careers</a></li>
        <li><a href="applications.php">Applications</a></li>
        <li><a href="request.php">Job Requests</a></li>
      </ul>
    </nav>
    <a class="cta" href="index.php"><button>Log Out</button></a>
  </header>
  <section>
    <div class="applications-list-container">
      <h2>5 Applications History</h2>
      <div class="applications">
        <?php foreach ($applications as $application): ?>
          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title"><?php echo htmlspecialchars($application['position']); ?></h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status <?php echo htmlspecialchars($application['status']); ?>">
              <?php echo ucfirst(htmlspecialchars($application['status'])); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
  </section>
</body>

</html>