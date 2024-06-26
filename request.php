<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/request.css" />
  <link rel="shortcut icon" type="x-icon" href="images/tab.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JobOnCampus</title>
  <style>
    /* Modal Styling */
    .modal-alert {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
      padding-top: 60px;
    }

    .modal-alert-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 400px;
      border-radius: 10px;
      text-align: center;
    }

    .modal-alert-content h2 {
      margin-top: 0;
    }

    .modal-alert-content button {
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <header>
    <a href="home.php">
      <img class="logo" src="images/jobOnCampusBlack.png" alt="logo" /></a>
    <nav>
      <ul class="nav_links">
        <li><a href="careers.php">Careers</a></li>
        <?php if (isset($_SESSION['userID'])): ?>
          <li><a href="applications.php">Applications</a></li>
        <?php endif; ?>
        <li><a href="request.php">Job Requests</a></li>
      </ul>
    </nav>
    <?php if (isset($_SESSION['userID'])): ?>
      <a class="cta" href="scripts/logout.php"><button>Log Out</button></a>
    <?php else: ?>
      <a class="cta" href="index.php"><button>Log In</button></a>
    <?php endif; ?>
  </header>
  <main>
    <section class="request-job-container">
      <h2>Request a Job</h2>
      <form id="job-request-form" action="scripts/submit_request.php" method="post">
        <div class="form-group">
          <label for="job-title">Job Title</label>
          <input list="job-titles" id="job-title" name="job_title" placeholder="Type to search..." required />
          <datalist id="job-titles">
            <option value="Software Engineer"></option>
            <option value="Data Analyst"></option>
            <option value="Product Manager"></option>
            <option value="Graphic Designer"></option>
          </datalist>
        </div>

        <div class="form-group">
          <label for="faculty">Faculty</label>
          <select id="education" name="education" required>
            <option value="computing">Computing</option>
            <option value="management">Management</option>
            <option value="science">Science</option>
            <option value="mechanical">Mechanical Engineering</option>
          </select>
        </div>

        <div class="form-group">
          <label for="about-yourself">About Yourself</label>
          <textarea id="about-yourself" name="about_yourself" rows="5" placeholder="Explain why you should get the job"
            required></textarea>
        </div>

        <div class="form-group">
          <label for="certifications">Certifications</label>
          <input type="text" id="certifications" name="certifications"
            placeholder="List any certifications (e.g., AWS Cloud Security, CompTia Security+)" />
        </div>

        <button type="submit">Submit Request</button>
      </form>
    </section>
  </main>

  <!-- Modal for Login Alert -->
  <div id="alertModal" class="modal-alert">
    <div class="modal-alert-content">
      <h2>Login Required</h2>
      <p>You need to log in to submit a job request.</p>
      <button id="alertClose">OK</button>
    </div>
  </div>

  <script>
    var alertModal = document.getElementById("alertModal");
    var alertCloseBtn = document.getElementById("alertClose");

    var isLoggedIn = <?php echo isset($_SESSION['userID']) ? 'true' : 'false'; ?>;

    document.getElementById("job-request-form").addEventListener("submit", function (e) {
      if (!isLoggedIn) {
        e.preventDefault();
        alertModal.style.display = "block";
        return;
      }
    });

    window.onclick = function (event) {
      if (event.target == alertModal) {
        alertModal.style.display = "none";
      }
    };

    alertCloseBtn.onclick = function () {
      alertModal.style.display = "none";
    };
  </script>
</body>

</html>