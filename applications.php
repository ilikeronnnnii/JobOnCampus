<?php
  session_start();
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
          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title">Software Engineer</h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with
              researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status working">Currently Working</span>
          </div>
          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title">Software Engineer</h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with
              researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status rejected">Rejected</span>
          </div>

          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title">Software Engineer</h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with
              researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status accepted">Accepted</span>
          </div>

          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title">Software Engineer</h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with
              researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status pending">Pending</span>
          </div>

          <div class="application">
            <img src="images/coding.png" alt="" />
            <h3 class="job-title">Software Engineer</h3>
            <h4 class="supervision">Supervised by Dr. Analiza</h4>
            <div class="details">
              Responsible to find bugs, in UTM Website, together with
              researching a couple of new ransomware.
            </div>
            <a href="#" class="details-btn">More Details</a>
            <span class="application-status past">Past Position</span>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
