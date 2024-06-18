<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="css/careers.css" />
    <link rel="shortcut icon" type="x-icon" href="images/tab.png" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    />
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
      <div class="jobs-list-container">
        <h2>Trending Startups Company</h2>
        <div class="jobs">
          <div class="job">
            <div class="job-header">
              <img
                src="images/hyundai.png"
                alt="Hyundai Logo"
                class="company-logo"
              />
              <div class="company-info">
                <h3 class="company-title">Hyundai</h3>
                <p class="supervision">51-200 Employees</p>
              </div>
            </div>
            <div class="details">Cars zoom zoom, tokyo skibddi toilet rizz</div>
            <div class="type-tags">
              <span class="type active-hiring">Actively Hiring</span>
              <span class="type rating">4.2 Highly Rated</span>
              <span class="type growing-fast">Growing Fast</span>
            </div>
            <div class="positions">
              <span>15 open positions</span>
              <a> <i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div>
          </div>

          <div class="job">
            <div class="job-header">
              <img src="images/youtube.png" alt="" class="company-logo" />
              <div class="company-info">
                <h3 class="company-title">Youtube</h3>
                <p class="supervision">3 Employees</p>
              </div>
            </div>
            <div class="details">Cars zoom zoom, tokyo skibddi toilet rizz</div>
            <div class="type-tags">
              <span class="type active-hiring">Actively Hiring</span>
              <span class="type growing-fast">Growing Fast</span>
            </div>
            <div class="positions">
              <span>1 open positions</span>
              <a> <i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div>
          </div>

          <div class="job">
            <div class="job-header">
              <img src="images/namco.png" alt="" class="company-logo" />
              <div class="company-info">
                <h3 class="company-title">Namco</h3>
                <p class="supervision">3 Employees</p>
              </div>
            </div>
            <div class="details">Cars zoom zoom, tokyo skibddi toilet rizz</div>
            <div class="type-tags">
              <span class="type active-hiring">Actively Hiring</span>
              <span class="type growing-fast">Growing Fast</span>
            </div>
            <div class="positions">
              <span>25 open positions</span>
              <a> <i class="fa-solid fa-arrow-right-to-bracket"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <div id="jobModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Job Positions at <span id="companyName"></span></h2>
        <ul id="jobPositionsList">
          <!-- Job positions will be listed here -->
        </ul>
      </div>
    </div>
  </body>
</html>