<?php
session_start();
if (!isset($_SESSION['userID'])) {
  header("Location: index.php"); // Redirect to login page if not logged in
  exit();
}

require_once "scripts/database.php";

// Fetch applications data for the logged-in user
$userID = $_SESSION['userID'];
$sql = "SELECT a.*, j.position, j.location, j.salary, j.deadline, j.description, j.lecturer, f.facultyName
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
  <style>
    /* Modal Styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #ffffff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 16px;
      width: 80%;
      max-width: 500px;
      box-shadow: 0 4px 24px -8px rgba(2, 48, 71, 0.2);
      text-align: left;
    }

    .close {
      color: #aaaaaa;
      float: right;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: #000000;
      text-decoration: none;
    }

    .modal-content h2 {
      margin-top: 0;
      font-size: 24px;
      border-bottom: 1px solid #e0e0e0;
      padding-bottom: 10px;
    }

    #modalJobDetails p {
      font-size: 16px;
      color: #333;
      line-height: 1.6;
    }

    .modal-actions {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    button.close-modal-btn,
    button.offer-btn {
      background-color: #4CAF50;
      color: white;
      padding: 12px 24px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      margin: 10px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    button.close-modal-btn:hover,
    button.offer-btn:hover {
      background-color: #45a049;
      transform: scale(1.05);
    }

    button.reject-offer-btn {
      background-color: #f44336;
    }

    button.reject-offer-btn:hover {
      background-color: #e53935;
    }
  </style>
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
                <p class="supervision">Supervised by <?php echo htmlspecialchars($application['lecturer']); ?></p>
              </div>
            </div>
            <div class="details">
              <?php echo htmlspecialchars($application['description']); ?>
            </div>
            <?php if ($application['status'] === 'accepted'): ?>
              <a href="#" class="details-btn" data-jobid="<?php echo $application['jobID']; ?>"
                data-position="<?php echo htmlspecialchars($application['position']); ?>"
                data-location="<?php echo htmlspecialchars($application['location']); ?>"
                data-salary="<?php echo htmlspecialchars($application['salary']); ?>"
                data-deadline="<?php echo htmlspecialchars($application['deadline']); ?>"
                data-faculty="<?php echo htmlspecialchars($application['facultyName']); ?>"
                data-description="<?php echo htmlspecialchars($application['description']); ?>"
                data-lecturer="<?php echo htmlspecialchars($application['lecturer']); ?>"
                data-status="<?php echo htmlspecialchars($application['status']); ?>">More Details</a>
            <?php endif; ?>
            <span class="application-status <?php echo htmlspecialchars($application['status']); ?>">
              <?php echo ucfirst(htmlspecialchars($application['status'])); ?>
            </span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div id="detailsModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Job Details</h2>
      <div id="modalJobDetails"></div>
      <div id="modalActions" class="modal-actions"></div>
    </div>
  </div>

  <script>
    var modal = document.getElementById("detailsModal");
    var span = document.getElementsByClassName("close")[0];
    var closeModalBtn = document.querySelector('.close-modal-btn');

    document.querySelectorAll('.details-btn').forEach(function (button) {
      button.addEventListener('click', function (event) {
        event.preventDefault();
        var jobID = this.getAttribute('data-jobid');
        var position = this.getAttribute('data-position');
        var location = this.getAttribute('data-location');
        var salary = this.getAttribute('data-salary');
        var deadline = this.getAttribute('data-deadline');
        var faculty = this.getAttribute('data-faculty');
        var description = this.getAttribute('data-description');
        var lecturer = this.getAttribute('data-lecturer');
        var status = this.getAttribute('data-status');

        // Fetch job details
        var jobDetails = `
          <p><strong>Position:</strong> ${position}</p>
          <p><strong>Location:</strong> ${location}</p>
          <p><strong>Salary:</strong> RM${salary} per hour</p>
          <p><strong>Faculty:</strong> ${faculty}</p>
          <p><strong>Lecturer:</strong> ${lecturer}</p>
          <p><strong>Details:</strong> ${description}</p>
        `;

        document.getElementById('modalJobDetails').innerHTML = jobDetails;

        // Show or hide offer buttons based on job status
        var modalActions = document.getElementById('modalActions');
        if (status === 'accepted') {
          modalActions.innerHTML = `
            <form method="POST" action="scripts/update_status_user.php">
              <input type="hidden" name="jobID" value="${jobID}">
              <button type="submit" name="status" value="working" class="offer-btn accept-offer-btn">Accept Offer</button>
              <button type="submit" name="status" value="rejected" class="offer-btn reject-offer-btn">Reject Offer</button>
            </form>
          `;
        } else {
          modalActions.innerHTML = '';
        }

        modal.style.display = "block";
      });
    });

    span.onclick = function () {
      modal.style.display = "none";
    };

    closeModalBtn.onclick = function () {
      modal.style.display = "none";
    };

    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>

</html>